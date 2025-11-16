<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Lib\OddsApi\GetGames;
use App\Lib\OddsApi\GetOdds;
use App\Lib\OddsApi\GetSports;
use App\Lib\Referral;
use App\Models\Bet;
use App\Models\CronJob;
use App\Models\CronJobLog;
use App\Models\Game;
use App\Models\Transaction;
use App\Models\HouseEarning; // Para registrar comisión de la casa
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CronController extends Controller
{
    public function runManually(Request $request)
    {
        $alias = $request->alias;
        $result = $this->$alias();

        if (!$result['success']) {
            $notify[] = ['error', $result['error']];
            return back()->withNotify($notify);
        }

        $notify[] = ['success', 'Cron executed successfully'];
        return back()->withNotify($notify);
    }

    /* ===================== OTHERS (API) ===================== */

    public function fetchLeagues()
    {
        $startTime = now();
        $error = null;
        $this->updateLastCronTime('fetchLeagues');

        try {
            new GetSports();
        } catch (\Exception $e) {
            $error = $e->getMessage();
            Log::error('Failed to fetch and save leagues data: ' . $error);
        }

        $this->storeCronLog('fetchLeagues', $startTime, now(), $error);

        return $error ? ['success' => false, 'error' => $error] : ['success' => true];
    }

    public function fetchGames()
    {
        $startTime = now();
        $error = null;
        $this->updateLastCronTime('fetchGames');

        try {
            new GetGames();
        } catch (\Exception $e) {
            $error = $e->getMessage();
            Log::error('Failed to fetch and save game data: ' . $error);
        }

        $this->storeCronLog('fetchGames', $startTime, now(), $error);

        return $error ? ['success' => false, 'error' => $error] : ['success' => true];
    }

    public function fetchOdds()
    {
        $startTime = now();
        $error = null;
        $this->updateLastCronTime('fetchOdds');

        try {
            new GetOdds('active');
        } catch (\Exception $e) {
            $error = $e->getMessage();
            Log::error('Failed to fetch live matches: ' . $error);
        }

        $this->storeCronLog('fetchOdds', $startTime, now(), $error);

        return $error ? ['success' => false, 'error' => $error] : ['success' => true];
    }

    public function fetchInPlayOdds()
    {
        $startTime = now();
        $error = null;
        $this->updateLastCronTime('fetchInPlayOdds');

        try {
            new GetOdds('running');
        } catch (\Exception $e) {
            $error = $e->getMessage();
            Log::error('Failed to fetch running matches: ' . $error);
        }

        $this->storeCronLog('fetchInPlayOdds', $startTime, now(), $error);

        return $error ? ['success' => false, 'error' => $error] : ['success' => true];
    }

    /* ===================== LIQUIDAR GANADAS ===================== */

    public function win()
    {
        $startTime = now();
        $error = null;
        $this->updateLastCronTime('win');

        try {
            // 👇 NO usamos scopes, usamos lo que hay en la BD
            // Status::BET_WIN debería ser 1 (como en tu screenshot)
            $bets = Bet::where('status', Status::BET_WIN)
                ->where(function ($q) {
                    // is_settled puede venir null o 0
                    $q->whereNull('is_settled')
                      ->orWhere('is_settled', 0)
                      ->orWhere('is_settled', Status::NO);
                })
                ->orderBy('result_time', 'asc')
                ->with('user')
                ->limit(200)
                ->get();

            foreach ($bets as $bet) {
                // si no tiene user, no hay a quién pagar
                if (!$bet->user) {
                    // igual lo marcamos como liquidado para no trabarnos
                    $bet->is_settled = Status::YES;
                    $bet->save();
                    continue;
                }

                // evitar pagar dos veces
                $transactionExists = Transaction::where('trx', $bet->bet_number)
                    ->where('remark', 'bet_won')
                    ->where('user_id', $bet->user_id)
                    ->exists();

                // lo marcamos como liquidado SIEMPRE para que no se repita
                $bet->is_settled = Status::YES;
                $bet->save();

                if ($transactionExists) {
                    continue;
                }

                // Calcular ganancia neta (return_amount - stake_amount)
                $returnAmount = $bet->return_amount > 0 ? $bet->return_amount : $bet->stake_amount;
                $profit = $returnAmount - $bet->stake_amount; // Ganancia pura del usuario

                // Calcular comisión del 5% solo sobre la GANANCIA
                $commissionPercent = 5.00;
                $commissionAmount = round($profit * ($commissionPercent / 100), 8);
                
                // Pago final al usuario = return_amount - comisión del 5%
                $payout = $returnAmount - $commissionAmount;

                DB::transaction(function () use ($bet, $payout, $returnAmount, $commissionAmount, $commissionPercent, $profit) {
                    $user = $bet->user;

                    // sumar al balance el payout (ya con comisión descontada)
                    $user->balance += $payout;
                    $user->save();

                    // registrar transacción
                    $transaction               = new Transaction();
                    $transaction->user_id      = $user->id;
                    $transaction->amount       = $payout;
                    $transaction->post_balance = $user->balance;
                    $transaction->trx_type     = '+';
                    $transaction->trx          = $bet->bet_number;
                    $transaction->remark       = 'bet_won';
                    $transaction->details      = 'For bet winning (5% commission applied to profit)';
                    $transaction->save();

                    // Registrar la comisión del 5% para la casa
                    if ($commissionAmount > 0) {
                        HouseEarning::create([
                            'bet_id' => $bet->id,
                            'user_id' => $bet->user_id,
                            'bet_amount' => $bet->stake_amount,
                            'commission_amount' => $commissionAmount,
                            'commission_percent' => $commissionPercent,
                            'bet_number' => $bet->bet_number,
                            'type' => 'win_commission',
                            'description' => "House commission (5%) from winning bet. Profit: " . showAmount($profit) . ", Return: " . showAmount($returnAmount) . ", Payout: " . showAmount($payout),
                        ]);
                    }

                    // comisión por referido (si aplica) - calculada sobre el payout
                    if (gs('win_commission') && gs('referral_program')) {
                        Referral::levelCommission($user, $payout, $bet->bet_number, 'win');
                    }

                    // notificar
                    notify($user, 'BET_WIN', [
                        'username'   => $user->username,
                        'amount'     => $payout,
                        'bet_number' => $bet->bet_number,
                    ]);
                });
            }

            $this->storeCronLog('win', $startTime, now(), null);

            return [
                'success'    => true,
                'total_bets' => $bets->count(),
            ];
        } catch (\Exception $e) {
            $error = $e->getMessage();
            Log::error('Failed to process win data: ' . $error);
            $this->storeCronLog('win', $startTime, now(), $error);
            return ['success' => false, 'error' => $error];
        }
    }

    /* ===================== LIQUIDAR PERDIDAS ===================== */

    public function lose()
    {
        $startTime = now();
        $error = null;
        $this->updateLastCronTime('lose');

        try {
            $bets = Bet::where('status', Status::BET_LOSS)
                ->where(function ($q) {
                    $q->whereNull('is_settled')
                      ->orWhere('is_settled', 0)
                      ->orWhere('is_settled', Status::NO);
                })
                ->orderBy('result_time', 'asc')
                ->with('user')
                ->limit(200)
                ->get();

            foreach ($bets as $bet) {
                $bet->is_settled = Status::YES;
                $bet->save();

                if ($bet->user) {
                    notify($bet->user, 'BET_LOSS', [
                        'username'   => $bet->user->username,
                        'amount'     => $bet->stake_amount,
                        'bet_number' => $bet->bet_number,
                    ]);
                }
            }

            $this->storeCronLog('lose', $startTime, now(), null);

            return [
                'success'    => true,
                'total_bets' => $bets->count(),
            ];
        } catch (\Exception $e) {
            $error = $e->getMessage();
            Log::error('Failed to process lose data: ' . $error);
            $this->storeCronLog('lose', $startTime, now(), $error);
            return ['success' => false, 'error' => $error];
        }
    }

    /* ===================== LIQUIDAR REEMBOLSOS ===================== */

    public function refund()
    {
        $startTime = now();
        $error = null;
        $this->updateLastCronTime('refund');

        try {
            $bets = Bet::where('status', Status::BET_REFUNDED)
                ->where(function ($q) {
                    $q->whereNull('is_settled')
                      ->orWhere('is_settled', 0)
                      ->orWhere('is_settled', Status::NO);
                })
                ->orderBy('result_time', 'asc')
                ->with('user')
                ->limit(200)
                ->get();

            foreach ($bets as $bet) {
                if (!$bet->user) {
                    $bet->is_settled = Status::YES;
                    $bet->save();
                    continue;
                }

                $transactionExists = Transaction::where('trx', $bet->bet_number)
                    ->where('remark', 'bet_refunded')
                    ->where('user_id', $bet->user_id)
                    ->exists();

                $bet->is_settled = Status::YES;
                $bet->save();

                if ($transactionExists) {
                    continue;
                }

                DB::transaction(function () use ($bet) {
                    $user = $bet->user;

                    $user->balance += $bet->stake_amount;
                    $user->save();

                    $transaction               = new Transaction();
                    $transaction->user_id      = $user->id;
                    $transaction->amount       = $bet->stake_amount;
                    $transaction->post_balance = $user->balance;
                    $transaction->trx_type     = '+';
                    $transaction->trx          = $bet->bet_number;
                    $transaction->remark       = 'bet_refunded';
                    $transaction->details      = 'For bet refund';
                    $transaction->save();

                    notify($user, 'BET_REFUNDED', [
                        'username'   => $user->username,
                        'amount'     => $bet->stake_amount,
                        'bet_number' => $bet->bet_number,
                    ]);
                });
            }

            $this->storeCronLog('refund', $startTime, now(), null);

            return [
                'success'    => true,
                'total_bets' => $bets->count(),
            ];
        } catch (\Exception $e) {
            $error = $e->getMessage();
            Log::error('Failed to process refund data: ' . $error);
            $this->storeCronLog('refund', $startTime, now(), $error);
            return ['success' => false, 'error' => $error];
        }
    }

    /* ===================== ABRIR APUESTAS ===================== */

    public function setOpenForBetting()
    {
        $startTime = now();
        $error = null;
        $this->updateLastCronTime('setOpenForBetting');

        try {
            $games = Game::where('bet_start_time', '>=', now())
                ->where('status', Status::GAME_NOT_OPEN_FOR_BETTING)
                ->get();

            foreach ($games as $game) {
                $game->status = Status::GAME_OPEN_FOR_BETTING;
                $game->save();
            }

            $this->storeCronLog('setOpenForBetting', $startTime, now(), null);

            return [
                'success'     => true,
                'total_games' => $games->count(),
                'message'     => 'Games are set to open for betting',
            ];
        } catch (\Exception $e) {
            $error = $e->getMessage();
            Log::error('Failed to set games for open for betting: ' . $error);
            $this->storeCronLog('setOpenForBetting', $startTime, now(), $error);
            return ['success' => false, 'error' => $error];
        }
    }

    /* ===================== HELPERS ===================== */

    private function updateLastCronTime($alias)
    {
        $cronJob = CronJob::where('alias', $alias)->first();
        if ($cronJob) {
            $cronJob->last_run = now();
            $cronJob->save();
        }
    }

    private function storeCronLog($alias, $startTime, $endTime, $error = '')
    {
        $cronJob = CronJob::where('alias', $alias)->first();

        if ($cronJob) {
            $cronJob->last_run = $endTime;
            $cronJob->save();

            $startTime     = Carbon::parse($startTime);
            $endTime       = Carbon::parse($endTime);
            $diffInSeconds = $startTime->diffInSeconds($endTime);

            $cronLog              = new CronJobLog();
            $cronLog->cron_job_id = $cronJob->id;
            $cronLog->start_at    = $startTime;
            $cronLog->error       = $error;
            $cronLog->end_at      = $endTime;
            $cronLog->duration    = $diffInSeconds;
            $cronLog->save();
        }
    }
}
