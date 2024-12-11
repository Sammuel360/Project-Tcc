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

        // Verifica se o usuário está logado na sessão
        if (isset($_SESSION['usuario']) && method_exists($_SESSION['usuario'], 'getId')) {
            // Aqui, obtemos apenas o ID do usuário logado
            $this->data->usuario_id = $_SESSION['usuario']->getId();
        } else {
            $this->message = "Usuário não está logado ou método getId() não existe.";
            return null;
        }

        // Verifica se os campos obrigatórios estão preenchidos
        if (!$this->required()) {
            return null;
        }

        // Prepara a query de inserção
        $query = "INSERT INTO " . self::$entity . " (titulo, descricao, cep, endereco, usuario_id, orgao_id) 
              VALUES (:titulo, :descricao, :cep, :endereco, :usuario_id, :orgao_id)";

        // Parametriza os valores para a query
        $params = [
            'titulo' => $this->data->titulo,
            'descricao' => $this->data->descricao,
            'cep' => $this->data->cep,
            'endereco' => $this->data->endereco,
            'usuario_id' => $this->data->usuario_id,  // Passando apenas o ID do usuário
            'orgao_id' => $this->data->orgao_id,

        ];

        // Executa a query de inserção no banco
        if ($this->create($query, $params)) {
            return $this;
        } else {
            var_dump($this->message);  // Exibe a mensagem de erro detalhada
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