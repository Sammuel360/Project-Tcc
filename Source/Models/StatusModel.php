<?php

namespace Source\Models;

use Source\Core\Model;

require_once __DIR__ . '/../Core/Model.php';
class StatusModel extends Model
{
    protected $table = 'historico_status'; // Nome da tabela

    public function save(array $data): ?bool
    {
        $this->data = (object) $data;

        if (!$this->required()) {
            return null;
        }

        // Inserção
        $query = "INSERT INTO {$this->table}
            (chamado_id, status, observacao)
            VALUES (:chamado_id, :status, :observacao)";
        $params = [
            'chamado_id' => $this->data->chamado_id,
            'status' => $this->data->status,
            'observacao' => $this->data->observacao
        ];

        $id = $this->create($query, $params);
        if (!$id) {
            $this->message = "Ooops, não foi possível cadastrar o histórico de status!";
            return null;
        } else {
            $this->data->id = $id;
            $this->message = "Histórico de status cadastrado com sucesso!";
            return true;
        }
    }

    private function required(): bool
    {
        if (empty($this->data->chamado_id) || empty($this->data->status)) {
            $this->message = "Verifique o preenchimento dos campos obrigatórios!";
            return false;
        }
        return true;
    }

    public function listByChamadoId(int $chamadoId): ?array
    {
        $query = "SELECT * FROM {$this->table} WHERE chamado_id = :chamado_id";
        $params = ['chamado_id' => $chamadoId];
        $stmt = $this->read($query, $params);
        return $stmt ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : null;
    }

    public function deleteById(int $id): bool
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $params = ['id' => $id];
        return $this->delete($query, $params);
    }
}
