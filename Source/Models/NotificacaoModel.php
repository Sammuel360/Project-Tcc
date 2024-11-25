<?php

namespace Source\Models;

use Source\Core\Model;

class NotificacaoModel extends Model
{
    protected $table = 'notificacoes'; // Nome da tabela

    public function save(array $data): ?bool
    {
        $this->data = (object) $data;

        if (!$this->required()) {
            return null;
        }

        // Inserção
        $query = "INSERT INTO {$this->table}
            (usuario_id, mensagem, data_criacao)
            VALUES (:usuario_id, :mensagem, :data_criacao)";
        $params = http_build_query([
            'usuario_id' => $this->data->usuario_id,
            'mensagem' => $this->data->mensagem,
            'data_criacao' => $this->data->data_criacao
        ]);

        $id = $this->create($query, $params);
        if (!$id) {
            $this->message = "Ooops, não foi possível cadastrar a notificação!";
            return null;
        } else {
            $this->data->id = $id;
            $this->message = "Notificação cadastrada com sucesso!";
            return true;
        }
    }

    private function required(): bool
    {
        if (empty($this->data->usuario_id) || empty($this->data->mensagem)) {
            $this->message = "Verifique o preenchimento dos campos obrigatórios!";
            return false;
        }
        return true;
    }

    public function listByUsuarioId(int $usuarioId): ?array
    {
        $query = "SELECT * FROM {$this->table} WHERE usuario_id = :usuario_id";
        $params = "usuario_id={$usuarioId}";
        $stmt = $this->read($query, $params);
        return $stmt ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : null;
    }

    public function deleteById(int $id): bool
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $params = "id={$id}";
        return $this->delete($query, $params);
    }
}
