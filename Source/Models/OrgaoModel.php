<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * A classe OrgaoModel é responsável por representar um orgao no sistema
 * 
 * @version ${1:0.0.0
 * @author Antonio César <antonio.magalhaes@ba.estudante.senai.br>
 */
class OrgaoModel extends Model
{
    /**
     * A variável foi criada com o objetivo de armazenar o nome da tabela do banco, 
     * para assim, facilitar a construção e replicação do código.
     * 
     * @var string
     */
    private static $entity = "orgaos";
    /**
     * A variável foi criada com o objetivo de armazenar o nome do campo id do banco, para assim, facilitar a construção e replicação do código.
     * 
     * @var string
     */
    private static $id = "id";

    /**
     * Insere ou atualiza um registro no banco de dados.
     * 
     * @return OrgaoModel|null Um objeto OrgaoModel, ou null caso tenha uma falha na criação ou atualização do registro.
     */
    public function save(): ?OrgaoModel
    {
        // Verifica se os campos obrigatórios estão preenchidos
        if (!$this->required()) {
            return null;
        }

        // Atualiza se o registro já existe no banco de dados (identificado pelo id)
        if (!empty($this->data->id)) {

            // Prepara a query de atualização do registro
            $query = "UPDATE " . self::$entity . " SET "
                . "nome=:nome"
                . " WHERE "
                . self::$id . "=:" . self::$id;

            // Define os parâmetros da query
            $params = ":nome={$this->data->nome}&:"
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
                . "nome"
                . ") VALUES (:"
                . "nome"
                . ")";

            // Define os parâmetros da query
            $params = ":nome={$this->data->nome}";


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
            $this->message = "orgao deletado com sucesso!";
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
     * @return array|null Um array de objetos OrgaoModel, ou null caso não haja registros na tabela.
     */
    public function listarOrgao(): array
    {
        $query = "SELECT * FROM " . self::$entity;
        $stmt = $this->read($query);

        if ($stmt && $stmt->rowCount()) {
            $orgaos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $orgaos;
        } else {
            $this->message = "Nenhum órgão encontrado.";
            error_log("Nenhum órgão encontrado.");
            return [];
        }
    }




    /**
     * Retorna todos os registros que tem o id inserido.
     * 
     * @param int $id O id a ser encontrado
     * @return OrgaoModel|null Um array de objetos OrgaoModel, ou null caso não haja registros na tabela.
     */
    public function findById(int $id): ?OrgaoModel
    {
        // Prepara a query de seleção de todos os registros com aquele id
        $sql = "SELECT * FROM " . self::$entity . " WHERE " . self::$id . "=:" . self::$id;

        // Define os parâmetros da query como um array associativo
        $params = [":" . self::$id => $id];

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
            $this->message = "Nenhum orgão foi encontrado!";
            return null;
        }
        $this->typeMessage = "success";
        $this->message = "A consulta foi feita com sucesso!";

        // Retorna o registro encontrado na tabela como um objeto da classe OrgaoModel
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
        if (empty($this->data->nome)) {
            $this->message = "Verifique se os campos estão preechidos";
            $this->typeMessage = "warning";
            return false;
        }
        // Verifica a quantidade de caracteres dos campos
        if (strlen($this->data->nome) > 255) {
            $this->typeMessage = "warning";
            $this->message = "Verifique se os campos foram preenchidos corretamente!";
            return false;
        }
        return true;
    }

    /**
     * Retorna todos os nomes de orgao da tabela.
     *
     * @return array|null Um array de objetos OrgaoModel, ou null caso não haja registros na tabela.
     */
    public function nameOrgaos(): ?array
    {
        // Prepara a query para selecionar todos os órgãos
        $sql = "SELECT DISTINCT nome as nome_orgao, id FROM " . self::$entity;

        // Executa a query de seleção
        $stmt = $this->read($sql);

        // Se houver falhas ou não encontrar registros, retorna null
        if ($this->getFail()) {
            $this->typeMessage = "error";
            $this->message = "Ooops algo deu errado!";
            return null;
        }
        if (!$stmt->rowCount()) {
            $this->typeMessage = "warning";
            $this->message = "Nenhum órgão foi encontrado!";
            return null;
        }

        // Retorna os registros encontrados
        $this->message = "A consulta foi feita com sucesso!";
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
}