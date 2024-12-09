<?php

namespace Source\Controllers;

use Source\Models\OrgaoModel;

class OrgaoController
{
    private $model;

    /**
     * Construtor do controller, responsável por instanciar o modelo.
     */
    public function __construct()
    {
        $this->model = new OrgaoModel();
    }

    /**
     * Lista todos os órgãos.
     *
     * @return array|false Retorna um array de órgãos ou false em caso de falha.
     */
    public function list(): array|false
    {
        return $this->model->listarOrgao(); // Chama o método all() do modelo para listar todos os órgãos
    }

    /**
     * Exibe um órgão específico baseado no ID.
     *
     * @param int $id O ID do órgão a ser exibido.
     * @return OrgaoModel|false Retorna um objeto OrgaoModel ou false caso não encontre o órgão.
     */
    public function show(int $id): OrgaoModel|false
    {
        return $this->model->findById($id); // Chama o método findById() do modelo para encontrar o órgão pelo ID
    }

    /**
     * Cria ou atualiza um órgão.
     *
     * @param array $data Dados do órgão a ser salvo.
     * @return OrgaoModel|null Retorna um objeto OrgaoModel ou null em caso de erro.
     */
    public function store(array $data): ?OrgaoModel
    {
        // Atribui os dados recebidos ao objeto de modelo
        $this->model->data = (object) $data;

        return $this->model->save(); // Chama o método save() do modelo para criar ou atualizar
    }

    /**
     * Deleta um órgão baseado no ID.
     *
     * @param int $id O ID do órgão a ser deletado.
     * @return bool Retorna true se a exclusão for bem-sucedida, ou false em caso de erro.
     */
    public function destroy(int $id): bool
    {
        // Define o ID do órgão a ser excluído
        $this->model->data = (object) ['id' => $id];

        return $this->model->destroy(); // Chama o método destroy() do modelo para deletar o órgão
    }
}
