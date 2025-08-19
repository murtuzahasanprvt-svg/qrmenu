<?php

declare(strict_types=1);

/**
 * Configuration for QR Menu System
 */

class Config
{
    private static array $config = [
        'app' => [
            'name' => 'QR Menu System',
            'version' => '1.0.0',
            'debug' => true,
            'timezone' => 'Asia/Dhaka',
        ],
        
        'database' => [
            'host' => 'sql109.infinityfree.com',
            'port' => '3306',
            'name' => 'if0_39497403_qrm',
            'user' => 'if0_39497403',
            'pass' => 'Btk3W8k2SF3hYK',
            'charset' => 'utf8',
            'driver' => 'mysql',
        ],
        
        'api' => [
            'cors' => [
                'allowed_origins' => ['*'],
                'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                'allowed_headers' => ['Content-Type', 'Authorization'],
            ],
            'version' => '2.0',
        ],
        
        'security' => [
            'max_login_attempts' => 5,
            'lockout_time' => 300,
            'session_lifetime' => 7200,
        ],
        
        'upload' => [
            'max_size' => 10485760,
            'allowed_types' => ['jpg', 'jpeg', 'png', 'gif', 'pdf'],
            'path' => '../uploads/',
        ],
    ];

    public static function get(string $key, $default = null)
    {
        $keys = explode('.', $key);
        $value = self::$config;
        
        foreach ($keys as $k) {
            if (isset($value[$k])) {
                $value = $value[$k];
            } else {
                return $default;
            }
        }
        
        return $value;
    }

    public static function set(string $key, $value): void
    {
        $keys = explode('.', $key);
        $current = &self::$config;
        
        foreach ($keys as $k) {
            if (!isset($current[$k])) {
                $current[$k] = [];
            }
            $current = &$current[$k];
        }
        
        $current = $value;
    }

    public static function load(): void
    {
        // Load environment variables if they exist
        $envFile = __DIR__ . '../.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos(trim($line), '#') === 0) {
                    continue;
                }
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                if (!empty($value) && $value[0] === '"' && $value[-1] === '"') {
                    $value = substr($value, 1, -1);
                }
                putenv("$key=$value");
                $_ENV[$key] = $value;
            }
        }
        
        // Override database config with environment variables
        if ($host = getenv('DB_HOST')) {
            self::set('database.host', $host);
        }
        if ($port = getenv('DB_PORT')) {
            self::set('database.port', $port);
        }
        if ($name = getenv('DB_NAME')) {
            self::set('database.name', $name);
        }
        if ($user = getenv('DB_USER')) {
            self::set('database.user', $user);
        }
        if ($pass = getenv('DB_PASS')) {
            self::set('database.pass', $pass);
        }
        
        // Set timezone
        date_default_timezone_set(self::get('app.timezone', 'Asia/Dhaka'));
    }
}