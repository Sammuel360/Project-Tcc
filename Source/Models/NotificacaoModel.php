<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * A classe NotificacaoModel é responsável por representar um notificacao no sistema
 * 
 * @version ${1:0.0.0
 * @author Antonio César <antonio.magalhaes@ba.estudante.senai.br>
 */
class NotificacaoModel extends Model
{
    /**
     * A variável foi criada com o objetivo de armazenar o nome da tabela do banco, 
     * para assim, facilitar a construção e replicação do código.
     * 
     * @var string
     */
    private static $entity = "notificacao";
    /**
     * A variável foi criada com o objetivo de armazenar o nome do campo id do banco, para assim, facilitar a construção e replicação do código.
     * 
     * @var string
     */
    private static $id = "id";
    /**
     * A variável foi criada com o objetivo de armazenar o nome do campo chamado_id do banco,
     *  para assim, facilitar a construção e replicação do código.
     * 
     * @var string
     */
    private static $idCalled = "chamado_id";
    /**
     * A variável foi criada com o objetivo de armazenar o nome do campo usuario_id do banco,
     *  para assim, facilitar a construção e replicação do código.
     * 
     * @var string
     */
    private static $idUser = "usuario_id";

    /**
     * Insere ou atualiza um registro no banco de dados.
     * 
     * @return NotificacaoModel|null Um objeto NotificacaoModel, ou null caso tenha uma falha na criação ou atualização do registro.
     */
    public function save(): ?NotificacaoModel
    {
        // Verifica se os campos obrigatórios estão preenchidos
        if (!$this->required()) {
            return null;
        }

        // Atualiza se o registro já existe no banco de dados (identificado pelo id)
        if (!empty($this->data->id)) {

            // Prepara a query de atualização do registro
            $query = "UPDATE " . self::$entity . " SET "
                . self::$idCalled . "=:" . self::$idCalled . ","
                . self::$idUser . "=:" . self::$idUser . ","
                . "mensagem=:mensagem,"
                . "lida=:lida,"
                . "data_envio=:data_envio,"
                . " WHERE "
                . self::$id . "=:" . self::$id;

            // Define os parâmetros da query
            $params = ":" . self::$idCalled . "{$this->data->chamado_id}&:"
                . self::$idUser . "{$this->data->idUser}&:"
                . "mensagem={$this->data->mensagem}&:"
                . "lida={$this->data->lida}&:"
                . "data_envio=" . date('Y-m-d H:i:s') . "&:"
                . self::$id . "={$this->data->id}";

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

            // Prepara a query de atualização do registro
            $query = "INSERT INTO " . self::$entity . " ("
                . self::$idCalled . ","
                . self::$idUser . ","
                . "mensagem,"
                . "lida,"
                . "data_envio"
                . ") VALUES (:"
                . self::$idCalled . ",:"
                . self::$idUser . ",:"
                . "mensagem ,:"
                . "lida ,:"
                . "data_envio"
                . ")";

            // Define os parâmetros da query
            $params = ":" . self::$idCalled . "{$this->data->chamado_id}&:"
                . self::$idUser . "{$this->data->idUser}&:"
                . "mensagem={$this->data->mensagem}&:"
                . "lida={$this->data->lida}&:"
                . "data_envio=" . date('Y-m-d H:i:s');

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
            $this->message = "notificacao deletado com sucesso!";
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
     * @return array|null Um array de objetos NotificacaoModel, ou null caso não haja registros na tabela.
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
            $this->message = "Nenhuma notificacao foi encontrada!";
            return null;
        }
        // Retorna os registros da tabela
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    /**
     * Retorna todos os registros que tem o id inserido.
     * 
     * @param int $id O id a ser encontrado
     * @return NotificacaoModel|null Um array de objetos NotificacaoModel, ou null caso não haja registros na tabela.
     */
    public function findById(int $id): ?NotificacaoModel
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
            $this->message = "Nenhuma notificacao foi encontrada!";
            return null;
        }
        $this->typeMessage = "sucess";
        $this->message = "A consulta foi feita com sucesso!";
        // Retorna os registros da tabela
        return $findById->fetchObject(__CLASS__);
    }
    /**
     * Retorna todos os registros que tem o usuario_id inserido.
     * 
     * @param int $id O usuario_id a ser encontrado
     * @return StatusModel|null Um array de objetos StatusModel, ou null caso não haja registros na tabela.
     */
    public function findByidUser(int $id): ?StatusModel
    {
        // Prepara a query de seleção de todos os registros com aquele
        $sql = "SELECT * FROM " . self::$entity . " WHERE " . self::$idUser . "=:" . self::$idUser;

        // Define os parâmetros da query
        $params = ":" . self::$idUser . "={$id}";

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
            $this->message = "Nenhum status foi encontrado relacionado a esse chamado!";
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
        if (empty($this->data->usuario_id) || empty($this->data->mensagem || empty($this->data->chamado_id))) {
            $this->message = "Verifique se os campos estão preechidos";
            $this->typeMessage = "warning";
            return false;
        }
        return true;
    }
}
