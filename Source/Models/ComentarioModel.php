<?php

namespace Source\Models;

use Source\Core\Model;

class ComentarioModel extends Model
{
    private $table = 'comentarios'; // Nome da tabela

    /**
     * Salva ou atualiza um comentário no banco de dados.
     */
    public function save(): ?ComentarioModel
    {
        if (!$this->required()) {
            return null;
        }

        // Update
        if (!empty($this->data->id)) {
            $query = "UPDATE {$this->table} SET 
                    comentario = :comentario, 
                    chamado_id = :chamado_id, 
                    usuario_id = :usuario_id
                WHERE id = :id";
            $params = http_build_query([
                'comentario' => $this->data->comentario,
                'chamado_id' => $this->data->chamado_id,
                'usuario_id' => $this->data->usuario_id,
                'id' => $this->data->id
            ]);

            if ($this->update($query, $params)) {
                $this->message = "Comentário atualizado com sucesso!";
            } else {
                $this->message = "Ooops, algo deu errado ao atualizar o comentário!";
            }
        }

        // Insert
        if (empty($this->data->id)) {
            $query = "INSERT INTO {$this->table} 
            (comentario, chamado_id, usuario_id) 
            VALUES (:comentario, :chamado_id, :usuario_id)";
            $params = http_build_query([
                'comentario' => $this->data->comentario,
                'chamado_id' => $this->data->chamado_id,
                'usuario_id' => $this->data->usuario_id
            ]);

            $id = $this->create($query, $params);
            if (!$id) {
                $this->message = "Ooops, não foi possível cadastrar o comentário!";
            } else {
                $this->data->id = $id;
                $this->message = "Comentário cadastrado com sucesso!";
            }
        }

        return $this;
    }

    /**
     * Busca um comentário por ID.
     */
    public function find($id): ?ComentarioModel
    {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $params = http_build_query(['id' => $id]);
        $stmt = $this->read($query, $params);

        if ($this->getFail() || !$stmt->rowCount()) {
            $this->message = "Comentário não encontrado!";
            return null;
        }
        return $stmt->fetchObject(__CLASS__);
    }

    /**
     * Retorna uma lista de todos os comentários cadastrados.
     */
    public function all(): ?array
    {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->read($query);

        if ($this->getFail() || !$stmt->rowCount()) {
            $this->message = "Banco de dados vazio!";
            return null;
        }
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * Deleta um comentário pelo ID.
     */
    public function destroy(): bool
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $params = http_build_query(['id' => $this->data->id]);

        if ($this->delete($query, $params)) {
            $this->message = "Comentário deletado com sucesso!";
            $this->data = null;
            return true;
        }

        $this->message = "Ooops, não foi possível deletar o comentário!";
        return false;
    }

    /**
     * Verifica se os campos obrigatórios estão preenchidos.
     */
    private function required(): bool
    {
        if (empty($this->data->comentario) || empty($this->data->chamado_id) || empty($this->data->usuario_id)) {
            $this->message = "Verifique o correto preenchimento dos campos!";
            return false;
        }
        return true;
    }
}
