<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Core\Connect;

require_once __DIR__ . '/../Core/Model.php';


class ChamadoModel extends Model
{
    protected $table = 'chamados'; // Nome da tabela

    public function save(array $data): ?bool
    {
        $this->data = (object) $data;

        if (!$this->required()) {
            return null;
        }

        if (!empty($this->data->id)) {
            // Atualização
            $query = "UPDATE {$this->table} SET
                titulo = :titulo,
                descricao = :descricao,
                localizacao = ST_GeomFromText(:localizacao),
                data_hora = :data_hora,
                status = :status,
                usuario_id = :usuario_id,
                orgao_id = :orgao_id
            WHERE id = :id";

            $params = [
                'titulo' => $this->data->titulo,
                'descricao' => $this->data->descricao,
                'localizacao' => $this->data->localizacao,
                'data_hora' => $this->data->data_hora,
                'status' => $this->data->status,
                'usuario_id' => $this->data->usuario_id,
                'orgao_id' => $this->data->orgao_id,
                'id' => $this->data->id
            ];

            return $this->update($query, $params);
        } else {
            // Inserção
            $query = "INSERT INTO {$this->table}
                (titulo, descricao, localizacao, data_hora, status, usuario_id, orgao_id)
                VALUES (:titulo, :descricao, ST_GeomFromText(:localizacao), :data_hora, :status, :usuario_id, :orgao_id)";

            $params = [
                'titulo' => $this->data->titulo,
                'descricao' => $this->data->descricao,
                'localizacao' => $this->data->localizacao,
                'data_hora' => $this->data->data_hora ?? date("Y-m-d H:i:s"), // Timestamp atual
                'status' => $this->data->status ?? 'pendente',
                'usuario_id' => $this->data->usuario_id,
                'orgao_id' => $this->data->orgao_id
            ];

            if ($this->create($query, $params)) {
                $this->data->id = $this->getLastInsertId();
                $this->message = "Chamado cadastrado com sucesso!";
                return true;
            } else {
                $this->message = "Ooops, não foi possível cadastrar o chamado!";
                return null;
            }
        }
    }

    private function required(): bool
    {
        if (empty($this->data->titulo) || empty($this->data->descricao) || empty($this->data->localizacao)) {
            $this->message = "Campos obrigatórios estão faltando!";
            return false;
        }
        return true;
    }

    public function listAll(int $limit = 10, int $offset = 0): ?array
    {
        $query = "SELECT * FROM {$this->table} LIMIT :limit OFFSET :offset";
        $params = [
            'limit' => $limit,
            'offset' => $offset
        ];
        $stmt = $this->read($query, $params);
        return $stmt ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : null;
    }

    public function findById(int $id): ?ChamadoModel
    {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $params = ['id' => $id];
        $stmt = $this->read($query, $params);
        if ($stmt && $stmt->rowCount()) {
            return $stmt->fetchObject(__CLASS__);
        }
        return null;
    }

    public function deleteById(int $id): bool
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $params = ['id' => $id];
        return $this->delete($query, $params);
    }

    public function getLastInsertId()
    {
        $pdo = Connect::getInstance();
        if (!$pdo) {
            $this->message = "Erro na conexão com o banco!";
            return null;
        }
        return $pdo->lastInsertId();
    }

    // Novo método para obter os órgãos cadastrados
    public function getAllOrgaos(): ?array
    {
        $query = "SELECT * FROM orgaos";
        $stmt = $this->read($query);

        if (!$stmt) {
            error_log("Erro ao buscar órgãos: " . $this->pdo->errorInfo());
        }

        return $stmt ? $stmt->fetchAll(\PDO::FETCH_OBJ) : null;
    }
}
