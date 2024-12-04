<?php

namespace Source\Models;

use Source\Core\Model;

require_once __DIR__ . '/../Core/Model.php';

class OrgaoModel extends Model
{
    protected $table = 'orgaos'; // Nome da tabela

    public function save(array $data): ?bool
    {
        $this->data = (object) $data;

        if (!$this->required()) {
            return null;
        }

        if (!empty($this->data->id)) {
            $query = "UPDATE {$this->table} SET
                nome = :nome
            WHERE id = :id";

            $params = [
                'nome' => $this->data->nome,
                'id' => $this->data->id
            ];

            return $this->update($query, $params);
        }

        $query = "INSERT INTO {$this->table}
            (nome)
            VALUES (:nome)";

        $params = [
            'nome' => $this->data->nome
        ];

        if ($this->create($query, $params)) {
            $this->data->id = $this->getLastInsertId();
            $this->message = "Órgão cadastrado com sucesso!";
            return true;
        }

        $this->message = "Erro ao cadastrar o órgão!";
        return null;
    }

    private function required(): bool
    {
        if (empty($this->data->nome)) {
            $this->message = "O campo 'nome' é obrigatório!";
            return false;
        }
        return true;
    }


    /**
     * Retorna todos os órgãos cadastrados no banco de dados.
     */
    // Método para listar todos os órgãos

    public function listarTodos(): ?array
    {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->read($query);
        return $stmt ? $stmt->fetchAll(\PDO::FETCH_OBJ) : null;
    }


    public function findById(int $id): ?OrgaoModel
    {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $params = ['id' => $id];
        $stmt = $this->read($query, $params);

        return $stmt && $stmt->rowCount() ? $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__) : null;
    }

    public function deleteById(int $id): bool
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $params = ['id' => $id];
        return $this->delete($query, $params);
    }

    private function getLastInsertId()
    {
        $pdo = \Source\Core\Connect::getInstance();
        return $pdo ? $pdo->lastInsertId() : null;
    }
}