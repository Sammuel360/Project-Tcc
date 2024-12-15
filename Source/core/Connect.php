<?php

namespace Source\Core;

use PDO;
use PDOException;

/**
 * A classe Connect é responsável por integrar uma instância do PDO
 *
 * @version 1.0.0
 * @author Antonio César <antonio.magalhaes17102005@gmail.com>
 */
class Connect
{
    private const HOSTNAME = "localhost";
    private const USERNAME = "root";
    private const PASSWORD = "";
    private const DBNAME = "fiscal_cidadao";

    public static $instance;
    private static $fail;

    // Conexão PDO com o banco de dados
    public static function getConn(): ?PDO
    {
        if (self::$instance === null) {
            try {
                // Dados da conexão
                $dsn = "mysql:dbname=" . self::DBNAME . ";host=" . self::HOSTNAME . ";charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];

                // Criação da instância PDO
                self::$instance = new PDO($dsn, self::USERNAME, self::PASSWORD, $options);

                // Log de sucesso
                error_log("Conexão estabelecida com sucesso.");
            } catch (PDOException $e) {
                // Log de erro, em vez de exibir diretamente
                self::$fail = $e;
                error_log("Erro de conexão com o banco: " . $e->getMessage());

                // Retorna null em caso de falha
                return null;
            }
        }
        return self::$instance;
    }

    // Obtenção da falha
    public static function getFail(): ?PDOException
    {
        return self::$fail;
    }
}