<?php

namespace Source\Models;

use Source\Core\Model;

class CategoriaModel extends Model
{
    protected $table = 'categoria';

    /**
     * Adiciona uma nova categoria.
     * 
     * @param string $nome Nome da categoria.
     * @return int|null O ID da nova categoria ou null em caso de falha.
     */
    public function addCategoria(string $nome): ?int
    {
        $query = "INSERT INTO {$this->table} (nome, created_at, updated_at)
                  VALUES (:nome, NOW(), NOW())";
        $params = "nome={$nome}";

        $id = $this->create($query, $params);
        if ($id) {
            $this->message = "Categoria adicionada com sucesso!";
            return $id;
        } else {
            $this->message = "Ooops, algo deu errado ao adicionar a categoria!";
            return null;
        }
    }

    /**
     * Obtém todas as categorias.
     * 
     * @return array|null Array de categorias ou null em caso de falha.
     */
    public function getAllCategorias(): ?array
    {
        $query = "SELECT * FROM {$this->table} ORDER BY nome ASC";
        $stmt = $this->read($query);

        if ($stmt && $stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        $this->message = "Nenhuma categoria encontrada!";
        return null;
    }

    /**
     * Obtém uma categoria pelo seu ID.
     * 
     * @param int $id O ID da categoria.
     * @return array|null Os dados da categoria ou null em caso de falha.
     */
    public function getCategoriaById(int $id): ?array
    {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $params = "id={$id}";
        $stmt = $this->read($query, $params);

        if ($stmt && $stmt->rowCount() > 0) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        $this->message = "Categoria não encontrada!";
        return null;
    }

    /**
     * Atualiza o nome de uma categoria.
     * 
     * @param int $id O ID da categoria.
     * @param string $novo_nome O novo nome da categoria.
     * @return bool|null Retorna true em caso de sucesso, false em caso de falha, ou null em caso de erro.
     */
    public function updateCategoria(int $id, string $novo_nome): ?bool
    {
        $query = "UPDATE {$this->table} SET nome = :novo_nome, updated_at = NOW() WHERE id = :id";
        $params = "id={$id}&novo_nome={$novo_nome}";

        if ($this->update($query, $params)) {
            $this->message = "Categoria atualizada com sucesso!";
            return true;
        } else {
            $this->message = "Ooops, algo deu errado ao atualizar a categoria!";
            return null;
        }
    }

    /**
     * Exclui uma categoria pelo seu ID.
     * 
     * @param int $id O ID da categoria.
     * @return bool|null Retorna true em caso de sucesso, false em caso de falha, ou null em caso de erro.
     */
    public function deleteCategoria(int $id): ?bool
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $params = "id={$id}";

        if ($this->delete($query, $params)) {
            $this->message = "Categoria excluída com sucesso!";
            return true;
        } else {
            $this->message = "Ooops, algo deu errado ao excluir a categoria!";
            return null;
        }
    }
}
