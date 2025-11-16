<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/core/vendor/autoload.php';

$app = require_once __DIR__ . '/core/bootstrap/app.php';

// Inicializar el kernel de consola
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$status = $kernel->handle(
    $input = new Symfony\Component\Console\Input\ArrayInput([
        'command' => 'migrate',
        '--force' => true,
    ]),
    new Symfony\Component\Console\Output\ConsoleOutput
);

// Mostrar salida
echo "<strong>✅ Migraciones ejecutadas correctamente.</strong><br>";
echo nl2br(Artisan::output());

$kernel->terminate($input, $status);
