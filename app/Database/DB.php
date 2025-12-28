<?php

namespace App\Database;

use PDO;

class DB
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (!self::$instance) {
            $config = require __DIR__ . '/../../config.php';

            $dsn = sprintf(
                'mysql:host=%s;dbname=%s%s',
                $config['db']['host'],
                $config['db']['dbname'],
                isset($config['db']['port']) ? ';port=' . $config['db']['port'] : '' // это для того чтобы можно было запускать и локально и через докер
            );

            self::$instance = new PDO(
                $dsn,
                $config['db']['user'],
                $config['db']['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]
            );

            self::$instance->exec('SET NAMES utf8mb4');
        }

        return self::$instance;
    }
}
