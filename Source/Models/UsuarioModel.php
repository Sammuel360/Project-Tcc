<?php

namespace Source\Models;

use Source\Core\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios'; // Nome da tabela

    /**
     * Salva ou atualiza um usuário no banco de dados.
     * @return UsuarioModel|null
     */
    public function save(): ?UsuarioModel
    {
        if (!$this->required()) {
            return null;
        }

        // Update
        if (!empty($this->data->id)) {
            $query = "UPDATE {$this->table} SET
                nome = :nome, 
                email = :email, 
                telefone = :telefone,
                endereco = :endereco, 
                cidade = :cidade, 
                estado = :estado,
                cep = :cep, 
                senha = :senha
                WHERE id = :id";
            $params = http_build_query([
                'nome' => $this->data->nome,
                'email' => $this->data->email,
                'telefone' => $this->data->telefone,
                'endereco' => $this->data->endereco,
                'cidade' => $this->data->cidade,
                'estado' => $this->data->estado,
                'cep' => $this->data->cep,
                'senha' => $this->data->senha,
                'id' => $this->data->id
            ]);

            if ($this->update($query, $params)) {
                $this->message = "Usuário atualizado com sucesso!";
            } else {
                $this->message = "Ooops, algo deu errado ao atualizar o usuário!";
            }
        } else {
            // Insert
            if ($this->findByEmail($this->data->email)) {
                $this->message = "Atenção: e-mail indisponível para cadastro!";
                return null;
            }
            $query = "INSERT INTO {$this->table}
                (nome, email, telefone, endereco, cidade, estado, cep, senha)
                VALUES (:nome, :email, :telefone, :endereco, :cidade, :estado, :cep, :senha)";
            $params = http_build_query([
                'nome' => $this->data->nome,
                'email' => $this->data->email,
                'telefone' => $this->data->telefone,
                'endereco' => $this->data->endereco,
                'cidade' => $this->data->cidade,
                'estado' => $this->data->estado,
                'cep' => $this->data->cep,
                'senha' => $this->data->senha
            ]);

            $id = $this->create($query, $params);
            if (!$id) {
                $this->message = "Ooops, não foi possível cadastrar o usuário!";
            } else {
                $this->data->id = $id;
                $this->message = "Usuário cadastrado com sucesso!";
            }
        }

        return $this;
    }

    /**
     * Verifica se os campos obrigatórios estão preenchidos.
     * @return bool
     */
    private function required(): bool
    {
        if (empty($this->data->nome) || empty($this->data->email) || empty($this->data->senha)) {
            $this->message = "Verifique o preenchimento dos campos obrigatórios!";
            return false;
        }
        return true;
    }

    /**
     * Verifica se já existe um usuário com o e-mail fornecido.
     * @param string $email
     * @return bool
     */
    private function findByEmail(string $email): bool
    {
        $query = "SELECT id FROM {$this->table} WHERE email = :email";
        $params = http_build_query(['email' => $email]);
        $stmt = $this->read($query, $params);
        return $stmt && $stmt->rowCount() > 0;
    }
}
