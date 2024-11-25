<?php

namespace Source\Core;

use PDO;

class Connect
{
    private const HOSTNAME = "localhost";
    private const USERNAME = "root";
    private const PASSWORD = "";
    private const DBNAME = "fiscal_cidadao";
    private static $instance;
    public static $fail;

    private function __construct() {}

    public static function getInstance(): ?PDO
    {
        // Verificar se a instância de conexão foi criada
        if (empty(self::$instance)) {
            try {
                self::$instance = new PDO(
                    "mysql:host=" . self::HOSTNAME . ";dbname=" . self::DBNAME . ";",
                    self::USERNAME,
                    self::PASSWORD
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $exception) {
                self::$fail = $exception;
                error_log("Conexão falhou: " . $exception->getMessage());  // Loga o erro
                return null;  // Retorna null se a conexão falhar
            }
        }
        return self::$instance;
    }
}
