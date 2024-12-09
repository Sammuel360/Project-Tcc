<?php

namespace Source\Core;

use PDO;
use PDOException;

/**
 * A classe Connect é responsável por entegrar um instância do PDO
 * 
 * @version ${1:1.0.0
 * @author Antonio César <antonio.magalhaes17102005@gmail.com>
 */
class Connect
{
    /**
     *  A variável HOSTNAME foi criada com o objetivo de armazenar o nome do host.
     */
    private const HOSTNAME = "localhost";
    /**
     *  A variável foi criada com o objetivo de armazenar o nome do usuário do banco.
     */
    private const USERNAME = "root";
    /**
     *  A variável foi criada com o objetivo de armazenar a senha do usuário do banco.
     */
    private const PASSWORD = "";
    /**
     *  A variável foi criada com o objetivo de armazenar o nome do banco.
     */
    private const DBNAME   = "fiscal_cidadao";
    /**
     *  A variável foi criada com o objetivo de armazenar a conexão e ser o ponto de acesso global com o banco.
     * 
     * @var PDO
     */
    public static $instance;
    /**
     *  A variável foi criada com o objetivo de armazenar a falha da conexão.
     * 
     * @var PDOException
     */
    private static $fail;

    /**
     * Estabelece uma conexão com o banco de dados usando o PDO
     * 
     * @return PDO|null Retorna uma instância do PDO se a conexão for bem-sucedida , ou null caso contrário. 
     */
    public static function getConn(): ?PDO
    {
        try {
            // Verifica se não há conexão com o banco de dados, caso não tenha ele vai iniciar uma nova conexão.
            if (empty(self::$instance)) {
                // Definir o charset e configurar o modo de erro para exceção
                $dsn = "mysql:dbname=" . self::DBNAME . ";host=" . self::HOSTNAME . ";charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lançar exceções em caso de erro
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Definir modo de fetch padrão
                    PDO::ATTR_EMULATE_PREPARES => false, // Desativar emulação de prepared statements
                ];

                // Criando a instância da conexão PDO
                self::$instance = new PDO($dsn, self::USERNAME, self::PASSWORD, $options);
            }
        } catch (PDOException $erro) {
            // Em caso de erro na conexão, armazena-se a falha e exibe a mensagem de erro
            self::$fail = $erro;
            echo "Erro na conexão com o banco de dados: " . $erro->getMessage();
            return null;
        }

        return self::$instance;
    }
}