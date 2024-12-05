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
        // Atribuir os dados recebidos ao objeto
        $this->data = (object) $data;

        // Validar os campos obrigatórios
        if (!$this->required()) {
            $this->message = "Por favor, preencha todos os campos obrigatórios.";
            return false; // Retorna falso se a validação falhar
        }

        try {
            if (!empty($this->data->id)) {
                // Atualizar o chamado existente
                return $this->updateChamado();
            } else {
                // Inserir um novo chamado
                return $this->insertChamado();
            }
        } catch (\Exception $exception) {
            // Captura e armazena a falha
            $this->fail = $exception;
            $this->message = "Erro ao salvar o chamado: " . $exception->getMessage();
            return false;
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
    public function insertChamado(): bool
    {
        // Validação do formato da data_hora (caso seja fornecida)
        if (!empty($this->data->data_hora) && !preg_match("/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/", $this->data->data_hora)) {
            $this->message = "Formato de data e hora inválido!";
            return false;
        }

        // Definir data_hora para o valor atual se não for fornecido
        $this->data->data_hora = $this->data->data_hora ?? date("Y-m-d H:i:s");

        // Validação do formato do CEP (ex: 12345-678 ou 123456789)
        if (!preg_match("/^\d{5}-\d{3}$/", $this->data->cep) && !preg_match("/^\d{8}$/", $this->data->cep)) {
            $this->message = "CEP inválido!";
            return false;
        }

        // Prepara a query de inserção
        $query = "INSERT INTO {$this->table} (titulo, descricao, cep, endereco, data_hora, status, usuario_id, orgao_id)
                  VALUES (:titulo, :descricao, :cep, :endereco, :data_hora, :status, :usuario_id, :orgao_id)";

        // Define os parâmetros para a query
        $params = [
            'titulo' => $this->data->titulo,
            'descricao' => $this->data->descricao,
            'cep' => $this->data->cep,
            'endereco' => $this->data->endereco,
            'data_hora' => $this->data->data_hora,
            'status' => $this->data->status ?? 'pendente',
            'usuario_id' => $this->data->usuario_id,
            'orgao_id' => $this->data->orgao_id ?? null
        ];

        // Chama o método create do modelo pai, caso exista
        if (method_exists($this, 'create')) {
            $insertId = $this->create($query, $params);  // Chama o método 'create'
            if ($insertId) {
                // Define o ID do chamado inserido
                $this->data->id = $insertId;
                $this->message = "Chamado cadastrado com sucesso!";
                return true;
            }
        }

        // Mensagem de erro caso a inserção falhe
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