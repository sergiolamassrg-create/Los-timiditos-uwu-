<?php

namespace App\Core;

use PDO;
use PDOException;

/**
 * Database
 *
 * Clase encargada de gestionar la conexión a la base de datos MySQL/MariaDB.
 * Implementa el patrón Singleton para reutilizar una única instancia PDO
 * durante todo el ciclo de vida del request.
 *
 * Configuración vía variables de entorno (.env):
 *  - DB_HOST: host del servidor de base de datos
 *  - DB_NAME: nombre de la base de datos
 *  - DB_USER: usuario de conexión
 *  - DB_PASS: contraseña de conexión
 *
 * Charset: utf8mb4 (soporte completo de unicode).
 */
class Database
{
    /** @var PDO|null Instancia singleton de la conexión PDO. */
    private static ?PDO $pdo = null;

    /**
     * Obtiene la instancia de conexión PDO.
     *
     * Si no existe conexión previa, la crea usando las credenciales
     * del archivo .env. Configura PDO en modo excepción y fetch
     * asociativo por defecto.
     *
     * @return PDO Instancia activa de la conexión a base de datos.
     *
     * @throws PDOException Si la conexión falla.
     */
    public static function connect(): PDO
    {
        if (self::$pdo === null) {
            $host = $_ENV['DB_HOST'];
            $db   = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASS'];
            $charset = 'utf8mb4';

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

            try {
                self::$pdo = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                throw $e;
            }
        }

        return self::$pdo;
    }
}
