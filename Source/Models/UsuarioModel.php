<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * A classe UsuarioModel é responsável por representar um usuario no sistema
 * 
 * @version ${1:0.0.0
 * @author Antonio César <antonio.magalhaes@ba.estudante.senai.br>
 */
class UsuarioModel extends Model
{
    /**
     * A variável foi criada com o objetivo de armazenar o nome da tabela do banco, 
     * para assim, facilitar a construção e replicação do código.
     * 
     * @var string
     */
    private static $entity = "usuarios";
    /**
     * A variável foi criada com o objetivo de armazenar o nome do campo id do banco, para assim, facilitar a construção e replicação do código.
     * 
     * @var string
     */
    private static $id = "id";
    /**
     * A variável foi criada com o objetivo de armazenar o nome do campo email do banco, para assim, facilitar a construção e replicação do código.
     * 
     * @var string
     */
    private static $Email = "email";

    /**
     * Insere ou atualiza um registro no banco de dados.
     * 
     * @return UsuarioModel|null Um objeto UsuarioModel, ou null caso tenha uma falha na criação ou atualização do registro.
     */
    public function save(): ?UsuarioModel
    {
        // Verifica se os campos obrigatórios estão preenchidos
        if (!$this->required()) {
            return null;
        }

        // Atualiza se o registro já existe no banco de dados (identificado pelo id)
        if (!empty($this->data->id)) {

            // Verifica se o Email está sendo usado por outro usuário
            if (!$this->VerifyByEmail($this->data->email, $this->data->id)) {
                return null;
            }

            // Prepara a query de atualização do registro
            $query = "UPDATE " . self::$entity . " SET "
                . "nome=:nome,"
                . "email=:email,"
                . "senha=:senha,"
                . "telefone=:telefone,"
                . "endereco=:endereco,"
                . "cidade=:cidade,"
                . "estado=:estado,"
                . "cep=:cep,"
                . "data_cadastro=:data_cadastro"
                . " WHERE "
                . self::$id . "=:" . self::$id;

            // Define os parâmetros da query
            $params = ":nome={$this->data->nome}&:"
                . "email={$this->data->email}&:"
                . "senha={$this->data->senha}&:"
                . "telefone={$this->data->telefone}&:"
                . "endereco={$this->data->endereco}&:"
                . "cidade={$this->data->cidade}&:"
                . "estado={$this->data->estado}&:"
                . "cep={$this->data->cep}&:"
                . "data_cadastro=" . date('Y-m-d H:i:s') . "&:"
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

            // Verifica se o Email está sendo usado por outro usuário
            if (!$this->VerifyByEmail($this->data->email)) {
                return null;
            }

            // Prepara a query de atualização do registro
            $query = "INSERT INTO " . self::$entity . " ("
                . "nome,"
                . "email,"
                . "senha,"
                . "telefone,"
                . "endereco,"
                . "cidade,"
                . "estado,"
                . "cep,"
                . "data_cadastro"
                . ") VALUES (:"
                . "nome ,:"
                . "email ,:"
                . "senha ,:"
                . "telefone ,:"
                . "endereco ,:"
                . "cidade ,:"
                . "estado ,:"
                . "cep ,:"
                . "data_cadastro"
                . ")";

            // Define os parâmetros da query
            $params = ":nome={$this->data->nome}&:"
                . "email={$this->data->email}&:"
                . "senha={$this->data->senha}&:"
                . "telefone={$this->data->telefone}&:"
                . "endereco={$this->data->endereco}&:"
                . "cidade={$this->data->cidade}&:"
                . "estado={$this->data->estado}&:"
                . "cep={$this->data->cep}&:"
                . "data_cadastro=" . date('Y-m-d H:i:s');


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
            $this->message = "usuario deletado com sucesso!";
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
     * @return array|null Um array de objetos UsuarioModel, ou null caso não haja registros na tabela.
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
            $this->message = "Nenhum usuario foi encontrado!";
            return null;
        }
        // Retorna os registros da tabela
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    /**
     * Retorna todos os registros que tem o id inserido.
     * 
     * @param int $id O id a ser encontrado
     * @return UsuarioModel|null Um array de objetos UsuarioModel, ou null caso não haja registros na tabela.
     */
    public function findById(int $id): ?UsuarioModel
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
            $this->message = "Nenhum usuario foi encontrado!";
            return null;
        }
        $this->typeMessage = "sucess";
        $this->message = "A consulta foi feita com sucesso!";
        // Retorna os registros da tabela
        return $findById->fetchObject(__CLASS__);
    }
    /**
     * Retorna todos os registros que tem o Email inserido.
     * 
     * @param int $email_param O email a ser encontrado
     * @return UsuarioModel|null Um array de objetos UsuarioModel, ou null caso não haja registros na tabela.
     */
    public function findByEmail(string $email_param): ?UsuarioModel
    {
        // Prepara a query de seleção de todos os registros com aquele
        $sql = "SELECT * FROM " . self::$entity . " WHERE " . self::$Email . "=:" . self::$Email;

        // Define os parâmetros da query
        $params = ":" . self::$Email . "={$email_param}";

        // Executa a query de seleção de todos os registros
        $findByEmail = $this->read($sql, $params);

        // Se houver falhas ou não tiver registros na tabela, retorna null.
        if ($this->getFail()) {
            $this->typeMessage = "error";
            $this->message = "Ooops algo deu errado!";
            return null;
        }
        if (!$findByEmail->rowCount()) {
            $this->typeMessage = "warning";
            $this->message = "Nenhuma Usuario foi encontrado!";
            return null;
        }
        $this->typeMessage = "sucess";
        $this->message = "A consulta foi feita com sucesso!";
        // Retorna os registros da tabela
        return $findByEmail->fetchObject(__CLASS__);
    }
    /**
     * Verifica se os campos foram preenchidos corretamentes
     *
     * @return bool|null true se os campos obrigatórios estão preenchidos, false caso contrário.
     */
    private function required(): ?bool
    {
        // Verifica se os campos obrigatórios estão preenchidos, caso não esteja retorna null 
        if (empty($this->data->nome) || empty($this->data->email) || empty($this->data->senha)) {
            $this->message = "Verifique se os campos estão preechidos";
            $this->typeMessage = "warning";
            return false;
        }
        // Verifica a quantidade de caracteres dos campos
        if (
            strlen($this->data->nome) > 255 || strlen($this->data->email) > 255 ||
            strlen($this->data->senha) > 255 || strlen($this->data->telefone) > 20 ||
            strlen($this->data->endereco) > 255 || strlen($this->data->cidade) > 100 ||
            strlen($this->data->estado) > 2 || strlen($this->data->cep) > 10
        ) {
            $this->typeMessage = "warning";
            $this->message = "Verifique se os campos foram preenchidos corretamente!";
            return false;
        }
        return true;
    }
    /**
     * Verifica se o Email inserido já é utilizado por outra Usuario 
     * 
     * @param int $email_param O Email a ser encontrado
     * @param int $id        O id a ser encontrado
     * @return bool Um array de objetos UsuarioModel, ou null caso não haja registros na tabela.
     */
    private function VerifyByEmail($email_param, int $id = null): bool
    {

        //Verifica se o $id está vazio, caso não esteja, ele faz uma consulta para verificar se o Email está sendo usada por outra Usuario.
        if (!empty($id)) {

            // Prepara a query de seleção de todos os registros com aquele Email e id fornecido
            $sql = "SELECT * FROM " . self::$entity . " WHERE "
                . self::$Email . "=:" . self::$Email
                . " AND " . self::$id . " !=:" . self::$id;

            // Define os parâmetros da query
            $params = ":" . self::$Email . "={$email_param}&:"
                . self::$id . "={$id}";

            // Executa a query de seleção de todos os registros
            $VerifyEmail = $this->read($sql, $params);

            // Se houver uma falha nos registros retorna null
            if ($this->getFail()) {
                $this->typeMessage = "error";
                $this->message = "Ooops algo deu errado!";
                return false;
            }
            // Se encontrar algum registro , retorna null
            if ($VerifyEmail->rowCount()) {
                $this->typeMessage = "warning";
                $this->message = "Já tem um Usuário cadastrado com esse Email!!";
                return false;
            }
        }

        //Verifica se o $id está vazio, caso esteja, ele faz uma consulta buscando pelo Email com o Email inserido.
        if (empty($id)) {

            // Prepara a query de seleção de todos os registros com aquele Email fornecido
            $sql = "SELECT * FROM " . self::$entity . " WHERE " . self::$Email . "=:" . self::$Email;

            // Define os parâmetros da query
            $params = ":" . self::$Email . "={$email_param}";

            // Executa a query de seleção de todos os registros
            $VerifyEmail = $this->read($sql, $params);

            // Se houver uma falha nos registros retorna null
            if ($this->getFail()) {
                $this->typeMessage = "error";
                $this->message = "Ooops algo deu errado!";
                return false;
            }

            // Se encontrar algum registro , retorna null
            if ($VerifyEmail->rowCount()) {
                $this->typeMessage = "warning";
                $this->message = "Já tem um Usuário cadastrado com esse Email!!";
                return false;
            }
        }

        // Retorna os registros da tabela
        return true;
    }

    /**
     * Retorna todos os nomes de usuario da tabela.
     *
     * @return array|null Um array de objetos UsuarioModel, ou null caso não haja registros na tabela.
     */
    public function nameUsers(): ?array
    {
        // Prepara a query de seleção de todos os registros
        $sql = "SELECT DISTINCT nome as nome_usuario , id FROM " . self::$entity;

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
            $this->message = "Nenhum usuario foi encontrado!";
            return null;
        }

        // Retorna os registros da tabela
        $this->message = "A consulta foi feita com sucesso!";
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
}
