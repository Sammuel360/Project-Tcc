<?php

namespace Source\Core;

abstract class Model
{
    /** @var \stdClass */
    protected $data;

    /** @var \PDOException */
    protected $fail;

    /** @var string */
    protected $message;

    public function __set($name, $value)
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
    protected function create(string $query, array $params): ?int
    {
        try {
            $stmt = Connect::getInstance()->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue(":{$key}", $value, is_numeric($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
            }
            $stmt->execute();
            return Connect::getInstance()->lastInsertId();
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }



    protected function update(string $query, array $params): ?bool
    {
        try {
            $stmt = Connect::getInstance()->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue(":{$key}", $value, is_numeric($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
            }
            $stmt->execute();
            return true;
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    protected function delete(string $query, array $params): ?bool
    {
        try {
            $stmt = Connect::getInstance()->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue(":{$key}", $value, is_numeric($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
            }
            $stmt->execute();
            return true;
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    protected function read(string $query, array $params = []): ?\PDOStatement
    {
        $pdo = Connect::getInstance();
        if ($pdo === null) {
            $this->fail = new \PDOException('Falha ao obter instância PDO');
            return null;
        }
        try {
            $stmt = $pdo->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue(":{$key}", $value, is_numeric($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
            }
            $stmt->execute();
            return $stmt;
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }
}