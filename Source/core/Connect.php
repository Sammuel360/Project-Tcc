<?php
namespace Source\Core;

use PDO;

/**
 * A classe Connect é responsável por entegrar uma instância de PDO.
 * @version ${1:1.0.0
 * @author Gilson Santos <gilson.f.santos@ba.estudantes.senai.br>
 */
class Connect
{
    //Constantes são membros da classe
    private const HOSTNAME = "localhost";
    private const USERNAME = "root";
    private const PASSWORD = "";
    private const DBNAME = "processo_adm";
    //recurso de conexão com o banco
    private static $instance;
    public static $fail;
    private function __construct()
    {
    }
    public static function getInstance(): ?PDO
    {
        if (empty(self::$instance)) {
            try {
                self::$instance = new PDO(
                    "mysql:host=" . self::HOSTNAME .
                    ";dbname=" . self::DBNAME . ";",
                    self::USERNAME,
                    self::PASSWORD
                );
            } catch (\PDOException $exception) {
                self::$fail = $exception;
            }
        }
        return self::$instance;
    }
}
