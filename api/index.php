<?php

/**
 * Vercel Serverless Function Entry Point for Karakopo
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Ensure required /tmp directories exist for Laravel's read-only filesystem environment
$tmpDirs = [
    '/tmp/storage',
    '/tmp/storage/framework',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/storage/app',
    '/tmp/storage/app/public',
    '/tmp/storage/bootstrap',
    '/tmp/storage/bootstrap/cache',
];

foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// 2. Set runtime environment overrides for serverless operation
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
$_SERVER['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';

putenv('APP_CONFIG_CACHE=/tmp/storage/bootstrap/cache/config.php');
$_ENV['APP_CONFIG_CACHE'] = '/tmp/storage/bootstrap/cache/config.php';
$_SERVER['APP_CONFIG_CACHE'] = '/tmp/storage/bootstrap/cache/config.php';

putenv('APP_EVENTS_CACHE=/tmp/storage/bootstrap/cache/events.php');
$_ENV['APP_EVENTS_CACHE'] = '/tmp/storage/bootstrap/cache/events.php';
$_SERVER['APP_EVENTS_CACHE'] = '/tmp/storage/bootstrap/cache/events.php';

putenv('APP_PACKAGES_CACHE=/tmp/storage/bootstrap/cache/packages.php');
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/storage/bootstrap/cache/packages.php';
$_SERVER['APP_PACKAGES_CACHE'] = '/tmp/storage/bootstrap/cache/packages.php';

putenv('APP_ROUTES_CACHE=/tmp/storage/bootstrap/cache/routes.php');
$_ENV['APP_ROUTES_CACHE'] = '/tmp/storage/bootstrap/cache/routes.php';
$_SERVER['APP_ROUTES_CACHE'] = '/tmp/storage/bootstrap/cache/routes.php';

putenv('APP_SERVICES_CACHE=/tmp/storage/bootstrap/cache/services.php');
$_ENV['APP_SERVICES_CACHE'] = '/tmp/storage/bootstrap/cache/services.php';
$_SERVER['APP_SERVICES_CACHE'] = '/tmp/storage/bootstrap/cache/services.php';

putenv('BCRYPT_ROUNDS=12');
$_ENV['BCRYPT_ROUNDS'] = '12';
$_SERVER['BCRYPT_ROUNDS'] = '12';

// Safe default encryption key if not configured in Vercel environment
if (empty(getenv('APP_KEY')) && empty($_ENV['APP_KEY'])) {
    $fallbackKey = 'base64:RbgQHxDfHYfmFuPJuat5kuulqHtJWDShMiirxVZKbKo=';
    putenv("APP_KEY={$fallbackKey}");
    $_ENV['APP_KEY'] = $fallbackKey;
    $_SERVER['APP_KEY'] = $fallbackKey;
}

// 3. Database initialization for SQLite on serverless
$tmpDb = '/tmp/database.sqlite';
$candidateSeedDbs = [
    __DIR__ . '/../database/database.sqlite',
    dirname(__DIR__) . '/database/database.sqlite',
    '/var/task/database/database.sqlite',
    '/var/task/user/database/database.sqlite',
];

$seedDb = null;
foreach ($candidateSeedDbs as $candidate) {
    if (file_exists($candidate) && filesize($candidate) > 0) {
        $seedDb = $candidate;
        break;
    }
}

if (!file_exists($tmpDb) || filesize($tmpDb) === 0) {
    if ($seedDb) {
        @copy($seedDb, $tmpDb);
    } else {
        @touch($tmpDb);
    }
    @chmod($tmpDb, 0666);
}

putenv("DB_DATABASE={$tmpDb}");
$_ENV['DB_DATABASE'] = $tmpDb;
$_SERVER['DB_DATABASE'] = $tmpDb;

// 4. Serverless defaults
$_SERVER['HTTPS'] = 'on';
$_SERVER['SERVER_PORT'] = '443';

if (empty(getenv('SESSION_DRIVER')) || empty($_ENV['SESSION_DRIVER'])) {
    putenv('SESSION_DRIVER=cookie');
    $_ENV['SESSION_DRIVER'] = 'cookie';
    $_SERVER['SESSION_DRIVER'] = 'cookie';
}

if (empty(getenv('CACHE_STORE')) || empty($_ENV['CACHE_STORE'])) {
    putenv('CACHE_STORE=array');
    $_ENV['CACHE_STORE'] = 'array';
    $_SERVER['CACHE_STORE'] = 'array';
}

if (empty(getenv('LOG_CHANNEL')) || empty($_ENV['LOG_CHANNEL'])) {
    putenv('LOG_CHANNEL=stderr');
    $_ENV['LOG_CHANNEL'] = 'stderr';
    $_SERVER['LOG_CHANNEL'] = 'stderr';
}

if (empty(getenv('APP_MAINTENANCE_DRIVER')) || empty($_ENV['APP_MAINTENANCE_DRIVER'])) {
    putenv('APP_MAINTENANCE_DRIVER=array');
    $_ENV['APP_MAINTENANCE_DRIVER'] = 'array';
    $_SERVER['APP_MAINTENANCE_DRIVER'] = 'array';
}

// 5. Ensure relative storage symlink exists
$publicStorage = __DIR__ . '/../public/storage';
if (!file_exists($publicStorage) && !is_link($publicStorage)) {
    @symlink('../storage/app/public', $publicStorage);
}

// 6. Bootstrap Laravel and bind writable storage path
require __DIR__ . '/../vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Direct ALL Laravel storage writes to /tmp/storage
$app->useStoragePath('/tmp/storage');

// Bind in-memory maintenance mode for serverless (avoids any Manager::createDriver calls)
$app->singleton(
    \Illuminate\Contracts\Foundation\MaintenanceMode::class,
    fn () => new \Illuminate\Foundation\ArrayMaintenanceMode()
);

// Enforce non-empty runtime drivers during boot
$app->booting(function () {
    if (empty(config('session.driver'))) {
        config(['session.driver' => 'cookie']);
    }
    if (empty(config('cache.default'))) {
        config(['cache.default' => 'array']);
    }
    if (empty(config('app.maintenance.driver'))) {
        config(['app.maintenance.driver' => 'array']);
    }
    config([
        'hashing.driver' => 'bcrypt',
        'hashing.bcrypt.rounds' => 12,
        'hashing.rehash_on_login' => false,
    ]);
    if (empty(config('app.key'))) {
        config(['app.key' => 'base64:RbgQHxDfHYfmFuPJuat5kuulqHtJWDShMiirxVZKbKo=']);
    }
    $tmpDb = '/tmp/database.sqlite';
    $dbConn = config('database.default', 'sqlite');
    if ($dbConn === 'sqlite' || empty($dbConn)) {
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => $tmpDb,
        ]);

        if (!file_exists($tmpDb) || filesize($tmpDb) < 1000) {
            try {
                if (!file_exists($tmpDb)) {
                    @touch($tmpDb);
                    @chmod($tmpDb, 0666);
                }
                \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
                \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
            } catch (\Throwable $migErr) {
                error_log("Database auto-migration warning: " . $migErr->getMessage());
            }
        }
    }
});

// 7. Handle request with diagnostic error catching
try {
    $app->handleRequest(Request::capture());
} catch (\Throwable $e) {
    error_log("SERVER ERROR: " . $e->getMessage() . "\n" . $e->getTraceAsString());
    http_response_code(500);
    echo "<h1>Karakopo Server Error</h1>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " (Line " . $e->getLine() . ")</p>";
    echo "<pre style='background:#f4f4f4;padding:12px;border-radius:6px;overflow:auto;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
