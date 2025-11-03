<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\Auth\LoginController;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (solo usuarios autenticados)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Cron jobs manuales
    Route::controller('CronController')->prefix('cron')->name('cron.')->group(function () {
        Route::get('fetch-leagues', 'CronController@fetchLeagues')->name('fetch.leagues');
        Route::get('fetch-games', 'CronController@fetchGames')->name('fetch.games');
        Route::get('fetch-odds', 'CronController@fetchOdds')->name('fetch.odds');
        Route::get('fetch-in-play-odds', 'CronController@fetchInPlayOdds')->name('fetch.running.game.odds');
        Route::get('set-open-for-betting', 'CronController@setOpenForBetting')->name('set.open.for.betting');
        Route::get('bet-win', 'CronController@win')->name('bet.win');
        Route::get('bet-lose', 'CronController@lose')->name('bet.loss');
        Route::get('bet-refund', 'CronController@refund')->name('bet.refund');
        Route::get('run-manually/{alias}', 'CronController@runManually')->name('manual.run');
    });

    // Soporte de usuario
    Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
        Route::get('/', 'supportTicket')->name('index');
        Route::get('new', 'openSupportTicket')->name('open');
        Route::post('create', 'storeSupportTicket')->name('store');
        Route::get('view/{ticket}', 'viewTicket')->name('view');
        Route::post('reply/{id}', 'replyTicket')->name('reply');
        Route::post('close/{id}', 'closeTicket')->name('close');
        Route::get('download/{attachment_id}', 'ticketDownload')->name('download');
    });

    // Apuestas
    Route::controller('BetSlipController')->prefix('bet')->name('bet.')->group(function () {
        Route::get('add-to-bet-slip', 'addToBetSlip')->name('slip.add');
        Route::post('remove/{id}', 'remove')->name('slip.remove');
        Route::post('remove-all', 'removeAll')->name('slip.remove.all');
        Route::post('update', 'update')->name('slip.update');
        Route::post('update-all', 'updateAll')->name('slip.update.all');
    });

    // Streaming
    Route::get('/stream', [StreamController::class, 'index'])->name('stream');
    Route::post('/stream/update', [StreamController::class, 'update'])->name('stream.update');

    // Endpoint to fetch user balance (used by header JS)
    Route::get('user/balance', [\App\Http\Controllers\User\UserController::class, 'balance'])->name('user.balance');

    // Sitio principal protegido
    Route::controller('SiteController')->group(function () {
        Route::get('/contact', 'contact')->name('contact');
        Route::post('/contact', 'contactSubmit');
        Route::get('/change/{lang?}', 'changeLanguage')->name('lang');
        Route::get('/news', 'blog')->name('blog');
        Route::get('news/{slug}', 'blogDetails')->name('blog.details');
        Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');
        Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');
        Route::get('policy/{slug}', 'policyPages')->name('policy.pages');
        Route::get('odds-by-market/{id}', 'getOdds')->name('market.odds');
        Route::get('markets/{gameSlug}', 'markets')->name('game.markets');
        Route::get('league/{slug}', 'gamesByLeague')->name('league.games');
        Route::get('category/{slug}', 'gamesByCategory')->name('category.games');
        Route::get('switch-to', 'switchType')->name('switch.type');
        Route::get('odds-type/{type}', 'oddsType')->name('odds.type');
        Route::get('/', 'index')->name('home');
    });
});

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (visibles sin login)
|--------------------------------------------------------------------------
*/

// Limpieza de caché
Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return 'Cache cleared!';
});

// Rutas de registro
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register.post');

// Rutas de login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// 🔁 Redirección externa (para usuarios baneados)
Route::get('/user/banned', function () {
    return redirect()->away('https://ballosbet.com/paga-tu-entrada/');
})->name('user.banned');

// =========================================================
// 🖼 Imagen por defecto (para rutas como /admin/language, /admin/teams, etc.)
// =========================================================
Route::get('/placeholder-image/{size}', function ($size) {
    $imagePath = public_path('assets/images/default.png');

    // Si la imagen por defecto no existe, devolvemos un PNG básico generado por PHP
    if (!File::exists($imagePath)) {
        $placeholder = imagecreate(200, 200);
        $bg = imagecolorallocate($placeholder, 245, 245, 245);
        $textColor = imagecolorallocate($placeholder, 120, 120, 120);
        imagestring($placeholder, 5, 60, 90, 'No Image', $textColor);
        ob_start();
        imagepng($placeholder);
        $imageData = ob_get_clean();
        imagedestroy($placeholder);
        return Response::make($imageData, 200, ['Content-Type' => 'image/png']);
    }

    return response()->file($imagePath);
})->name('placeholder.image');

/*
|--------------------------------------------------------------------------
| 🟢 Nueva ruta para aceptar Cookies (segura y aislada)
|--------------------------------------------------------------------------
|
| Esta ruta crea la cookie 'cookiesAccepted' durante 1 año.
| No interfiere con ninguna autenticación ni middleware.
|
*/
Route::get('/accept-cookies', function () {
    return response('ok')->cookie('cookiesAccepted', true, 60 * 24 * 365);
})->name('accept.cookies');
