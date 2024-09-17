<?php

namespace Source\Core;
//classe pai

abstract class Model
{
    /** @var \stdClass */
    protected $data;

    /**  @var \PDOException  */

    protected $fail;

    /** @var string */
    protected $message;

    public function __set($name, $value) // Método mágico criado para obter propriedades como os dados inseridos na StdClass
    {
        if (empty($this->data)) {
            $this->data = new \stdClass;
        }
        $this->data->$name = $value;
    }
    public function getFail(): ?\PDOException
    {
        return ($this->fail ?? null);
    }
    public function getMessage(): ?string
    {
        return ($this->message ?? null);
    }
    public function getData(): ?\stdClass
    {
        return ($this->data ?? null);
    }
    public function __get($name)
    {
        return ($this->data->$name ?? null);
    }
    /**O método create tem por objetivo realizar inserção
     * dos dados no banco.
     */
    protected function create(string $query, string $params): ?int
    {
        try {
            $stmt = Connect::getInstance()->prepare($query);
            parse_str($params, $params);
            foreach ($params as $key => $value) {
                if (is_numeric($value) && !is_float($value + 0)) {
                    $type = \PDO::PARAM_INT; //Define o tipo como inteiro  
                } else {
                    $type = \PDO::PARAM_STR;
                }
                $stmt->bindValue("{$key}", $value, $type);
            }
            $stmt->execute();
            return Connect::getInstance()->lastInsertId();
        } catch (\PDOException $exception) { //captura qualquer exceção do PDO
            $this->fail = $exception; // Define a propriedade fail a exceção
            return null; //retorna null
        }
    }
    protected function update(string $query, string $params): ?bool
    {
        try {
            $stmt = Connect::getInstance()->prepare($query); // prepara a consulta/query
            parse_str($params, $params);
            foreach ($params as $key => $value) {
                if (is_numeric($value)) {
                    $type = \PDO::PARAM_INT;
                } else {
                    $type = \PDO::PARAM_STR;
                }
                $stmt->bindValue("{$key}", $value, $type);
            }
            $stmt->execute();
            return true;
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }
    protected function delete(string $query, string $params)
    {
        try {
            $stmt = Connect::getInstance()->prepare($query); // prepara a consulta/query
            parse_str($params, $params);
            foreach ($params as $key => $value) {
                if (is_numeric($value)) {
                    $type = \PDO::PARAM_INT;
                } else {
                    $type = \PDO::PARAM_STR;
                }
                $stmt->bindValue("{$key}", $value, $type);
            }
            $stmt->execute();
            return true;
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }
    protected function read(string $query, string $params = null): ?\PDOStatement
    {
        try {
            $stmt = Connect::getInstance()->prepare($query);
            if ($params) { // prepara a consulta/query
                parse_str($params, $params);
                foreach ($params as $key => $value) {
                    if (is_numeric($value)) {
                        $type = \PDO::PARAM_INT;
                    } else {
                        $type = \PDO::PARAM_STR;
                    }
                    $stmt->bindValue("{$key}", $value, $type);
                }
            }
            $stmt->execute();
            return $stmt;
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }
}
