<?php

namespace Source\Models;

use Source\Core\Model;

class ChamadoModel extends Model
{
    protected static $entity = 'chamados'; // Nome da tabela
    protected static $primaryKey = 'id'; // Chave primária

    /**
     * Método para inserir um novo chamado no banco de dados
     */
    public function inserirChamado(array $data): ?ChamadoModel
    {
        $this->data = (object) $data;
        // Obtenha o ID do usuário logado (exemplo usando sessão)
        if (isset($_SESSION['usuario'])) {
            $this->data->usuario_id = $_SESSION['usuario'];
        } else {
            $this->message = "Usuário não está logado.";
            return null;
        }
        // Verifica se os campos obrigatórios estão preenchidos
        if (!$this->required()) {
            return null;
        }

        // Prepara a query de inserção
        $query = "INSERT INTO " . self::$entity . " (titulo, descricao, cep, endereco, usuario_id, orgao_id, data_abertura) VALUES (:titulo, :descricao, :cep, :endereco, :usuario_id, :orgao_id, :data_abertura)";
        $params = http_build_query([
            'titulo' => $this->data->titulo,
            'descricao' => $this->data->descricao,
            'cep' => $this->data->cep,
            'endereco' => $this->data->endereco,
            'usuario_id' => $this->data->usuario_id,
            'orgao_id' => $this->data->orgao_id,
            'data_abertura' => date('Y-m-d H:i:s')
        ]);

        // Executa a query de inserção
        if ($this->create($query, $params)) {
            return $this;
        } else {
            $this->message = "Erro ao inserir chamado.";
            return null;
        }
    }

    /**
     * Método para buscar um chamado por ID
     */
    public function findById(int $id): ?ChamadoModel
    {
        // Prepara a consulta para buscar um chamado pela chave primária
        $query = "SELECT * FROM " . self::$entity . " WHERE " . self::$primaryKey . " = :id";

        // Define os parâmetros como um array associativo
        $params = [':id' => $id];

        // Executa a consulta e obtém o resultado
        $stmt = $this->read($query, $params);

        // Verifica se a consulta retornou resultados
        if ($stmt && $stmt->rowCount()) {
            return $stmt->fetchObject(__CLASS__);
        } else {
            // Caso não encontre o chamado, define a mensagem e retorna null
            $this->message = "Chamado não encontrado.";
            return null;
        }
    }


    // Outros métodos...

    /**
     * Método para verificar campos obrigatórios
     */
    private function required(): bool
    {
        // Verifique seus campos obrigatórios aqui
        if (empty($this->data->titulo) || empty($this->data->descricao) || empty($this->data->usuario_id) || empty($this->data->orgao_id)) {
            $this->message = "Campos obrigatórios faltando!";
            return false;
        }
        return true;
    }
}
