<?php

namespace Source\Models;

use Source\Core\Model;

class AnexoModel extends Model
{
    /**
     * Salva ou atualiza um anexo no banco de dados
     */
    public function save(): ?AnexoModel
    {
        // Validação dos campos obrigatórios
        if (!$this->required()) {
            return null;
        }

        // Atualização
        if (!empty($this->data->idanexo)) {
            $query = "UPDATE anexo SET 
                        id_chamado = :id_chamado, 
                        arquivo = :arquivo, 
                        descricao = :descricao
                      WHERE idanexo = :idanexo";
            $params = "id_chamado={$this->data->id_chamado}&arquivo={$this->data->arquivo}&descricao={$this->data->descricao}&idanexo={$this->data->idanexo}";

            if ($this->update($query, $params)) {
                $this->message = "Anexo atualizado com sucesso!";
            } else {
                $this->message = "Ooops, algo deu errado ao atualizar o anexo!";
            }
            return $this;
        }

        // Inserção
        if (empty($this->data->idanexo)) {
            // Verifica se o arquivo já está cadastrado
            if ($this->findByArquivo($this->data->arquivo)) {
                $this->message = "Anexo já cadastrado!";
                return null;
            }

            $query = "INSERT INTO anexo (id_chamado, arquivo, descricao) 
                      VALUES (:id_chamado, :arquivo, :descricao)";
            $params = "id_chamado={$this->data->id_chamado}&arquivo={$this->data->arquivo}&descricao={$this->data->descricao}";

            $idanexo = $this->create($query, $params);

            if (!$idanexo) {
                $this->message = "Ooops, não foi possível cadastrar o anexo!";
            } else {
                $this->data->idanexo = $idanexo;
                $this->message = "Anexo cadastrado com sucesso!";
            }
        }

        return $this;
    }

    /**
     * Pesquisa um anexo pelo arquivo
     */
    public function findByArquivo(string $arquivo): ?AnexoModel
    {
        $query  = "SELECT * FROM anexo WHERE arquivo = :arquivo";
        $params = "arquivo={$arquivo}";
        $stmt   = $this->read($query, $params);

        if ($this->getFail() || !$stmt->rowCount()) {
            return null;
        }

        return $stmt->fetchObject(__CLASS__);
    }

    /**
     * Lista todos os anexos
     */
    public function all(): ?array
    {
        $query = "SELECT * FROM anexo";
        $stmt  = $this->read($query);

        if ($this->getFail() || !$stmt->rowCount()) {
            $this->message = "Banco de dados vazio!";
            return null;
        }

        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * Deleta um anexo
     */
    public function destroy(): bool
    {
        $query  = "DELETE FROM anexo WHERE idanexo = :idanexo";
        $params = "idanexo={$this->data->idanexo}";

        if ($this->delete($query, $params)) {
            $this->message = "Anexo deletado com sucesso!";
            $this->data = null;
            return true;
        }

        $this->message = "Ooops, algo deu errado ao deletar o anexo!";
        return false;
    }

    /**
     * Valida campos obrigatórios
     */
    private function required(): bool
    {
        if (empty($this->data->id_chamado) || empty($this->data->arquivo)) {
            $this->message = "Verifique o correto preenchimento dos campos obrigatórios!";
            return false;
        }
        return true;
    }
}
