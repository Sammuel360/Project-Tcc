<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Core\Connect;

require_once __DIR__ . '/../Core/Model.php';

class ChamadoModel extends Model
{
    protected $table = 'chamados'; // Nome da tabela

    /**
     * Salva ou atualiza um chamado no banco de dados
     */
    public function save(array $data): ?bool
    {
        $this->data = (object) $data;

        // Valida os campos obrigatórios
        if (!$this->required()) {
            return false; // Retorna falso se a validação falhar
        }

        if (!empty($this->data->id)) {
            // Atualização de chamado
            return $this->updateChamado();
        } else {
            // Inserção de novo chamado
            return $this->insertChamado();
        }
    }

    /**
     * Atualiza os dados de um chamado
     */
    private function updateChamado(): bool
    {
        $query = "UPDATE {$this->table} SET
            titulo = :titulo,
            descricao = :descricao,
            cep = :cep,
            endereco = :endereco,
            data_hora = :data_hora,
            status = :status,
            usuario_id = :usuario_id,
            orgao_id = :orgao_id
        WHERE id = :id";

        $params = [
            'titulo' => $this->data->titulo,
            'descricao' => $this->data->descricao,
            'cep' => $this->data->cep,
            'endereco' => $this->data->endereco,
            'data_hora' => $this->data->data_hora ?? date("Y-m-d H:i:s"),
            'status' => $this->data->status ?? 'pendente',
            'usuario_id' => $this->data->usuario_id,
            'orgao_id' => $this->data->orgao_id,
            'id' => $this->data->id
        ];

        // Chama o método update do modelo pai, caso exista
        if (method_exists($this, 'update')) {
            return $this->update($query, $params);
        }
        return false; // Caso o método não exista no modelo pai
    }

    /**
     * Insere um novo chamado no banco de dados
     */
    private function insertChamado(): bool
    {
        $query = "INSERT INTO {$this->table} (titulo, descricao, cep, endereco, data_hora, status, usuario_id, orgao_id)
        VALUES (:titulo, :descricao, :cep, :endereco, :data_hora, :status, :usuario_id, :orgao_id)";

        $params = [
            'titulo' => $this->data->titulo,
            'descricao' => $this->data->descricao,
            'cep' => $this->data->cep,
            'endereco' => $this->data->endereco,
            'data_hora' => $this->data->data_hora ?? date("Y-m-d H:i:s"),
            'status' => $this->data->status ?? 'pendente',
            'usuario_id' => $this->data->usuario_id,
            'orgao_id' => $this->data->orgao_id
        ];

        // Chama o método create do modelo pai, caso exista
        if (method_exists($this, 'create')) {
            if ($this->create($query, $params)) {
                $this->data->id = $this->getLastInsertId();
                $this->message = "Chamado cadastrado com sucesso!";
                return true;
            }
        }
        $this->message = "Erro ao cadastrar o chamado!";
        return false;
    }

    /**
     * Valida campos obrigatórios
     */
    private function required(): bool
    {
        if (empty($this->data->titulo) || empty($this->data->descricao) || empty($this->data->cep) || empty($this->data->endereco)) {
            $this->message = "Campos obrigatórios estão faltando!";
            return false;
        }
        return true;
    }

    /**
     * Lista todos os chamados com limite e offset
     */
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

    /**
     * Encontra um chamado pelo ID
     */
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

    /**
     * Exclui um chamado pelo ID
     */
    public function deleteById(int $id): bool
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $params = ['id' => $id];
        return $this->delete($query, $params);
    }

    /**
     * Retorna o último ID inserido
     */
    public function getLastInsertId()
    {
        $pdo = Connect::getInstance();
        if (!$pdo) {
            $this->message = "Erro na conexão com o banco!";
            return null;
        }
        return $pdo->lastInsertId();
    }
}