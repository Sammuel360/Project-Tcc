<?php

namespace Backend\Src\Models;

use Backend\Src\Core\DataBase;

/**
 * A classe ChamadoModel é responsável por representar um chamado no sistema
 * 
 * @version ${1:0.0.0
 * @author Antonio César <antonio.magalhaes@ba.estudante.senai.br>
 */
class ChamadoModel extends DataBase
{
    /**
     * A variável foi criada com o objetivo de armazenar o nome da tabela do banco, 
     * para assim, facilitar a construção e replicação do código.
     * 
     * @var string
     */
    private static $entity = "chamado";
    /**
     * A variável foi criada com o objetivo de armazenar o nome do campo id do banco, para assim, facilitar a construção e replicação do código.
     * 
     * @var string
     */
    private static $id = "id";

    /**
     * Insere ou atualiza um registro no banco de dados.
     * 
     * @return ChamadoModel|null Um objeto ChamadoModel, ou null caso tenha uma falha na criação ou atualização do registro.
     */
    public function save(): ?ChamadoModel
    {
        // Verifica se os campos obrigatórios estão preenchidos
        if (!$this->required()) {
            return null;
        }

        $status = $this->data->status ?? "pendente";

        // Atualiza se o registro já existe no banco de dados (identificado pelo id)
        if (!empty($this->data->id)) {
            // Prepara a query de atualização do registro
            $query = "UPDATE " . self::$entity . " SET
                titulo = :titulo,
                descricao = :descricao,
                cep = :cep,
                endereco = :endereco,
                data_hora = :data_hora,
                status = :status,
                usuario_id = :usuario_id,
                orgao_id = :orgao_id
            WHERE " . self::$id . " = " . self::$id;

            // Define os parâmetros da query
            $params = ":"
                . "titulo ={$this->data->titulo}&:"
                . "descricao={$this->data->descricao}&:"
                . "cep={$this->data->cep}&:"
                . "endereco={$this->data->endereco}&:"
                . "data_hora=". date('Y-m-d H:i:s') . "&:"
                . "status={$status}&:"
                . "usuario_id={$this->data->usuario_id}&:"
                . "orgao_id={$this->data->orgao_id}&:"
                . "id={$this->data->id}";

            // Executa a query de atualização do registro e armazena a mensagem . Retorna null caso tenha uma falha na criação ou atualização do registro.
            if ($this->update($query, $params)) {
                $this->message = "Atualizado com sucesso";
                $this->typeMessage = "sucess";
            } else {
                $this->message = "Ooops algo deu errado!";
                $this->typeMessage = "error";
                return null;
            }
        }
        // Insere se o registro ainda não existe no banco de dados
        if (empty($this->data->id)) {

            // Prepara a query de inserção do registro
            $query = "INSERT INTO " . self::$entity
                . "(titulo,
                descricao, cep,
                endereco,
                data_hora,
                status,
                usuario_id,
                orgao_id
                )
                VALUES
                (:titulo,
                :descricao,
                :cep,
                :endereco,
                :data_hora,
                :status,
                :usuario_id,
                :orgao_id
                )";

            // Define os parâmetros da query
            $params = ":"
                . "titulo ={$this->data->titulo}&:"
                . "descricao={$this->data->descricao}&:"
                . "cep={$this->data->cep}&:"
                . "endereco={$this->data->endereco}&:"
                . "data_hora=". date('Y-m-d H:i:s') . "&:"
                . "status={$status}&:"
                . "usuario_id={$this->data->usuario_id}&:"
                . "orgao_id={$this->data->orgao_id}";

            // Executa a query de inserção do registro e armazena o ultimo id inserido 
            //Se a inserção foi realizada com sucesso, o id é salvo na classe genérica e é armazenada a mensagem,
            //caso falhe armazenna a mensagem e retorna null.
            if ($this->create($query, $params)) {
                $this->message = "Dados inseridos com sucesso!";
                $this->typeMessage = "sucess";
            } else {
                $this->message = "Ooops algo deu errado!";
                $this->typeMessage = "error";
                return null;
            }
        }
        return $this;
    }
    /**
     * Deleta um registro no banco de dados.
     *
     * @return bool|null true se a exclusão foi realizada com sucesso, ou null caso contrário.
     */
    public function destroy(): ?bool
    {
        // Prepara a query de exclusão do registro
        $sql = "DELETE FROM " . self::$entity . " where " . self::$id . "=:" . self::$id;

        // Define os parâmetros da query
        $params = ":" . self::$id . "={$this->data->id}";

        // Executa a query de exclusão do registro e armazena a mensagem,
        // caso falhe armazena uma mensagem de erro e retorna null. 
        if ($this->delete($sql, $params)) {
            $this->data = null;
            $this->message = "chamado deletado com sucesso!";
            $this->typeMessage = "sucess";
        } else {
            $this->message = "Ooops algo deu errado!";
            $this->typeMessage = "error";
            return null;
        }
        return true;
    }
    /**
     * Retorna todos os registros da tabela.
     *
     * @return array|null Um array de objetos ChamadoModel, ou null caso não haja registros na tabela.
     */
    public function all(): ?array
    {
        // Prepara a query de seleção de todos os registros
        $sql = "SELECT * FROM " . self::$entity;

        // Executa a query de seleção de todos os registros
        $stmt = $this->read($sql);

        // Se houver falhas ou não tiver registros na tabela, retorna null.
        if ($this->getFail()) {
            $this->typeMessage = "error";
            $this->message = "Ooops algo deu errado!";
            return null;
        }
        if (!$stmt->rowCount()) {
            $this->typeMessage = "warning";
            $this->message = "Nenhum chamado foi encontrado!";
            return null;
        }
        // Retorna os registros da tabela
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    /**
     * Retorna todos os registros que tem o id inserido.
     * 
     * @param int $id O id a ser encontrado
     * @return ChamadoModel|null Um array de objetos ChamadoModel, ou null caso não haja registros na tabela.
     */
    public function findById(int $id): ?ChamadoModel
    {
        // Prepara a query de seleção de todos os registros com aquele
        $sql = "SELECT * FROM " . self::$entity . " WHERE " . self::$id . "=:" . self::$id;

        // Define os parâmetros da query
        $params = ":" . self::$id . "={$id}";

        // Executa a query de seleção de todos os registros
        $findById = $this->read($sql, $params);

        // Se houver falhas ou não tiver registros na tabela, retorna null.
        if ($this->getFail()) {
            $this->typeMessage = "error";
            $this->message = "Ooops algo deu errado!";
            return null;
        }
        if (!$findById->rowCount()) {
            $this->typeMessage = "warning";
            $this->message = "Nenhum chamado foi encontrado!";
            return null;
        }
        $this->typeMessage = "sucess";
        $this->message = "A consulta foi feita com sucesso!";
        // Retorna os registros da tabela
        return $findById->fetchObject(__CLASS__);
    }
    /**
     * Verifica se os campos foram preenchidos corretamentes
     *
     * @return bool|null true se os campos obrigatórios estão preenchidos, false caso contrário.
     */
    private function required(): ?bool
    {
        // Verifica se os campos obrigatórios estão preenchidos, caso não esteja retorna null 
        if (empty($this->data->titulo) || empty($this->data->descricao) || empty($this->data->cep) || empty($this->data->endereco)) {
            $this->message = "Verifique se os campos estão preechidos";
            $this->typeMessage = "warning";
            return false;
        }
        // Verifica a quantidade de caracteres dos campos
        if (
            strlen($this->data->titulo) > 255 || strlen($this->data->cep) > 10 || strlen($this->data->endereco) > 255
        ) {
            $this->typeMessage = "warning";
            $this->message = "Verifique se os campos foram preenchidos corretamente!";
            return false;
        }
        return true;
    }

    /**
     * Retorna todos os nomes de chamado da tabela.
     *
     * @return array|null Um array de objetos ChamadoModel, ou null caso não haja registros na tabela.
     */
    public function nameCalled(): ?array
    {
        // Prepara a query de seleção de todos os registros
        $sql = "SELECT DISTINCT nome as nome_chamado , id FROM " . self::$entity;

        // Executa a query de seleção de todos os registros
        $stmt = $this->read($sql);

        // Se houver falhas ou não tiver registros na tabela, retorna null.
        if ($this->getFail()) {
            $this->typeMessage = "error";
            $this->message = "Ooops algo deu errado!";
            return null;
        }
        if (!$stmt->rowCount()) {
            $this->typeMessage = "warning";
            $this->message = "Nenhum chamado foi encontrado!";
            return null;
        }

        // Retorna os registros da tabela
        $this->message = "A consulta foi feita com sucesso!";
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
}
