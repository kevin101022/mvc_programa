<?php

class Conexion
{
    private static $instance = NULL;

    private function __construct() {}

    public static function getConnect()
    {
        if (!isset(self::$instance)) {
            // Cargar variables de entorno
            require_once __DIR__ . '/EnvLoader.php';
            EnvLoader::load(__DIR__ . '/.env');

            $pdo_options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            $host = getenv('DB_HOST') ?: 'localhost';
            $db   = getenv('DB_NAME') ?: 'transversal';
            $user = getenv('DB_USER') ?: 'root';
            $pass = getenv('DB_PASS') ?: '';
            $port = getenv('DB_PORT') ?: '3306';
            $driver = getenv('DB_DRIVER') ?: 'mysql';

            // Verificar que el driver esté habilitado
            if (!in_array($driver, PDO::getAvailableDrivers())) {
                throw new Exception("El driver 'pdo_$driver' no está habilitado en su PHP.");
            }

            // DSN dinámico para soportar mysql o pgsql
            $dsn = "$driver:host=$host;port=$port;dbname=$db";
            
            try {
                self::$instance = new PDO($dsn, $user, $pass, $pdo_options);
            } catch (PDOException $e) {
                throw new Exception("Error al conectar a la base de datos: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}