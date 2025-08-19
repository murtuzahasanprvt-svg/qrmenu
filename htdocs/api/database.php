<?php

declare(strict_types=1);

/**
 * Simple Database Wrapper for API
 * 
 * Standalone database connection for API endpoints
 * Does not depend on MVC framework
 */

class Database
{
    private static ?self $instance = null;
    private ?PDO $pdo = null;
    private array $config;

    private function __construct()
    {
        // Load configuration
        if (!class_exists('Config')) {
            require_once __DIR__ . '/config.php';
            Config::load();
        }
        
        $this->config = [
            'host' => Config::get('database.host', 'sql109.infinityfree.com'),
            'port' => Config::get('database.port', '3306'),
            'dbname' => Config::get('database.name', 'if0_39497403_qrm'),
            'user' => Config::get('database.user', 'if0_39497403'),
            'pass' => Config::get('database.pass', 'Btk3W8k2SF3hYK'),
            'charset' => Config::get('database.charset', 'utf8'),
            'driver' => Config::get('database.driver', 'mysql'),
            'path' => Config::get('database.path', ''),
        ];
        $this->connect();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    private function connect(): void
    {
        try {
            $driver = $this->config['driver'];
            $dsn = $this->buildDsn($driver);
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            if ($driver === 'sqlite') {
                $this->pdo = new PDO($dsn, null, null, $options);
            } else {
                $this->pdo = new PDO($dsn, $this->config['user'], $this->config['pass'], $options);
            }
            
            // Set character set for MySQL
            if ($driver === 'mysql') {
                $this->pdo->exec("SET NAMES utf8mb4");
                $this->pdo->exec("SET CHARACTER SET utf8mb4");
                $this->pdo->exec("SET time_zone = '+06:00'");
            }
            
        } catch (PDOException $e) {
            throw new RuntimeException("Database connection failed: " . $e->getMessage());
        }
    }

    private function buildDsn(string $driver): string
    {
        switch ($driver) {
            case 'mysql':
                return sprintf(
                    'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                    $this->config['host'],
                    $this->config['port'],
                    $this->config['dbname'],
                    $this->config['charset']
                );
            case 'sqlite':
                return 'sqlite:' . $this->config['path'];
            default:
                throw new RuntimeException("Unsupported database driver: {$driver}");
        }
    }

    public function query(string $sql, array $params = []): PDOStatement
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new RuntimeException("Query failed: " . $e->getMessage() . " [SQL: " . $sql . "]");
        }
    }

    public function fetch(string $sql, array $params = []): ?array
    {
        $stmt = $this->query($sql, $params);
        $result = $stmt->fetch();
        return $result === false ? null : $result;
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    public function fetchColumn(string $sql, array $params = [], int $column = 0)
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchColumn($column);
    }

    public function execute(string $sql, array $params = []): bool
    {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount() > 0;
    }

    public function lastInsertId(string $name = null): string
    {
        return $this->pdo->lastInsertId($name);
    }

    public function beginTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->pdo->commit();
    }

    public function rollBack(): bool
    {
        return $this->pdo->rollBack();
    }

    public function inTransaction(): bool
    {
        return $this->pdo->inTransaction();
    }

    public function tableExists(string $table): bool
    {
        try {
            $sql = "SELECT 1 FROM `{$table}` LIMIT 1";
            $this->query($sql);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getStats(): array
    {
        return [
            'connected' => $this->pdo !== null,
            'driver' => $this->config['driver'],
            'host' => $this->config['host'] ?? 'unknown',
            'database' => $this->config['dbname'] ?? 'unknown'
        ];
    }

    private function __clone()
    {
        throw new RuntimeException("Cloning database connection is not allowed.");
    }

    public function __wakeup()
    {
        throw new RuntimeException("Unserializing database connection is not allowed.");
    }
}