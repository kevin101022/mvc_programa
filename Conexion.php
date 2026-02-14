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
            $user = getenv('DB_USER') ?: 'postgres';
            $pass = getenv('DB_PASS') ?: '';
            $port = getenv('DB_PORT') ?: '5432';
            $driver = getenv('DB_DRIVER') ?: 'pgsql';

            // Verificar que el driver de PostgreSQL esté habilitado
            if (!in_array('pgsql', PDO::getAvailableDrivers())) {
                throw new Exception("El driver 'pdo_pgsql' no está habilitado en su PHP. Por favor, actívelo en el archivo php.ini de Laragon.");
            }

            $dsn = "pgsql:host=$host;port=$port;dbname=$db";
            try {
                self::$instance = new PDO($dsn, $user, $pass, $pdo_options);
            } catch (PDOException $e) {
                // Si falla por credenciales o base de datos no existe
                throw new Exception("Error al conectar a PostgreSQL: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
