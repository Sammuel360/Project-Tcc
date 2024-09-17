<?php

namespace Source\Models;

use Source\Core\Model;

class StatusModel extends Model
{
    protected $table = 'historico_status'; // Nome da tabela

    /**
     * Salva ou atualiza o histórico de status.
     * @return StatusModel|null
     */
    public function save(): ?StatusModel
    {
        if (!$this->required()) {
            return null;
        }

        // Se o ID estiver presente, faz um update
        if (!empty($this->data->id)) {
            $query = "UPDATE {$this->table} SET
                chamado_id = :chamado_id, 
                status_anterior = :status_anterior,
                status_atual = :status_atual, 
                data_hora = NOW()
                WHERE id = :id";
            $params = http_build_query([
                'chamado_id' => $this->data->chamado_id,
                'status_anterior' => $this->data->status_anterior,
                'status_atual' => $this->data->status_atual,
                'id' => $this->data->id
            ]);

            if ($this->update($query, $params)) {
                $this->message = "Status atualizado com sucesso!";
            } else {
                $this->message = "Ooops, algo deu errado ao atualizar o status!";
            }
        } else {
            // Se o ID estiver vazio, faz um insert
            $query = "INSERT INTO {$this->table}
                (chamado_id, status_anterior, status_atual, data_hora)
                VALUES (:chamado_id, :status_anterior, :status_atual, NOW())";
            $params = http_build_query([
                'chamado_id' => $this->data->chamado_id,
                'status_anterior' => $this->data->status_anterior,
                'status_atual' => $this->data->status_atual
            ]);

            $id = $this->create($query, $params);
            if ($id) {
                $this->data->id = $id;
                $this->message = "Status salvo com sucesso!";
            } else {
                $this->message = "Ooops, algo deu errado ao salvar o status!";
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
        if (empty($this->data->chamado_id) || empty($this->data->status_anterior) || empty($this->data->status_atual)) {
            $this->message = "Verifique o preenchimento dos campos obrigatórios!";
            return false;
        }
        return true;
    }
}
