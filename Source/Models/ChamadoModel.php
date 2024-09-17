<?php

namespace Source\Models;

use Source\Core\Model;

class ChamadoModel extends Model
{
    /**
     * Salva ou atualiza um chamado no banco de dados.
     */
    public function save(): ?ChamadoModel
    {
        if (!$this->required()) {
            return null;
        }

        // Update
        if (!empty($this->data->id)) {
            $query = "UPDATE chamados SET 
                    descricao = :descricao, 
                    localizacao = ST_GeomFromText(:localizacao), 
                    data_hora = :data_hora, 
                    status = :status,
                    usuario_id = :usuario_id
                WHERE id = :id";
            $params = http_build_query([
                'descricao' => $this->data->descricao,
                'localizacao' => $this->data->localizacao,
                'data_hora' => $this->data->data_hora,
                'status' => $this->data->status,
                'usuario_id' => $this->data->usuario_id,
                'id' => $this->data->id
            ]);

            if ($this->update($query, $params)) {
                $this->message = "Chamado atualizado com sucesso!";
            } else {
                $this->message = "Ooops, algo deu errado ao atualizar o chamado!";
            }
        }

        // Insert
        if (empty($this->data->id)) {
            $query = "INSERT INTO chamados 
            (descricao, localizacao, data_hora, status, usuario_id) 
            VALUES (:descricao, ST_GeomFromText(:localizacao), :data_hora, :status, :usuario_id)";
            $params = http_build_query([
                'descricao' => $this->data->descricao,
                'localizacao' => $this->data->localizacao,
                'data_hora' => $this->data->data_hora,
                'status' => $this->data->status,
                'usuario_id' => $this->data->usuario_id
            ]);

            $id = $this->create($query, $params);
            if (!$id) {
                $this->message = "Ooops, não foi possível cadastrar o chamado!";
            } else {
                $this->data->id = $id;
                $this->message = "Chamado cadastrado com sucesso!";
            }
        }

        return $this;
    }

    /**
     * Busca um chamado por ID.
     */
    public function find($id): ?ChamadoModel
    {
        $query = "SELECT * FROM chamados WHERE id = :id";
        $params = http_build_query(['id' => $id]);
        $stmt = $this->read($query, $params);

        if ($this->getFail() || !$stmt->rowCount()) {
            $this->message = "Chamado não encontrado!";
            return null;
        }
        return $stmt->fetchObject(__CLASS__);
    }

    /**
     * Retorna uma lista de todos os chamados cadastrados.
     */
    public function all(): ?array
    {
        $query = "SELECT * FROM chamados";
        $stmt = $this->read($query);

        if ($this->getFail() || !$stmt->rowCount()) {
            $this->message = "Banco de dados vazio!";
            return null;
        }
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * Deleta um chamado pelo ID.
     */
    public function destroy(): bool
    {
        $query = "DELETE FROM chamados WHERE id = :id";
        $params = http_build_query(['id' => $this->data->id]);

        if ($this->delete($query, $params)) {
            $this->message = "Chamado deletado com sucesso!";
            $this->data = null;
            return true;
        }

        $this->message = "Ooops, não foi possível deletar o chamado!";
        return false;
    }

    /**
     * Verifica se os campos obrigatórios estão preenchidos.
     */
    private function required(): bool
    {
        if (empty($this->data->descricao) || empty($this->data->localizacao) || empty($this->data->usuario_id)) {
            $this->message = "Verifique o correto preenchimento dos campos!";
            return false;
        }
        return true;
    }
}
