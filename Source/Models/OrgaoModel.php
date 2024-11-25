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

        // Atualização
        if (!empty($this->data->id)) {
            $query = "UPDATE {$this->table} SET
                nome = :nome,
                endereco = :endereco,
                telefone = :telefone
                WHERE id = :id";
            $params = [
                'nome' => $this->data->nome,
                'endereco' => $this->data->endereco,
                'telefone' => $this->data->telefone,
                'id' => $this->data->id
            ];

            return $this->update($query, $params);
        }

        // Inserção
        $query = "INSERT INTO {$this->table}
            (nome, endereco, telefone)
            VALUES (:nome, :endereco, :telefone)";
        $params = [
            'nome' => $this->data->nome,
            'endereco' => $this->data->endereco,
            'telefone' => $this->data->telefone
        ];

        $id = $this->create($query, $params);
        if (!$id) {
            $this->message = "Ooops, não foi possível cadastrar o órgão!";
            return null;
        } else {
            $this->data->id = $id;
            $this->message = "Órgão cadastrado com sucesso!";
            return true;
        }
    }

    private function required(): bool
    {
        if (empty($this->data->nome)) {
            $this->message = "Verifique o preenchimento dos campos obrigatórios!";
            return false;
        }
        return true;
    }

    public function listAll(): ?array
    {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->read($query);
        return $stmt ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : null;
    }

    public function findById(int $id): ?OrgaoModel
    {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $params = ['id' => $id];
        $stmt = $this->read($query, $params);
        return $stmt && $stmt->rowCount() ? $stmt->fetchObject(__CLASS__) : null;
    }

    public function deleteById(int $id): bool
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $params = ['id' => $id];
        return $this->delete($query, $params);
    }
}
