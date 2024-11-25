<?php

namespace Source\Controllers;

use Source\Models\OrgaoModel;

class OrgaoController
{
    private $model;

    public function __construct()
    {
        $this->model = new OrgaoModel();
    }

    /**
     * Lista todos os órgãos.
     */
    public function listar()
    {
        $orgaos = $this->model->listAll();
        include 'views/OrgaosList.php'; // Exemplo de view para exibir os órgãos
    }

    /**
     * Insere um novo órgão.
     */
    public function inserir()
    {
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);

        if (!$nome) {
            $_SESSION['message'] = 'O nome do órgão é obrigatório.';
            header('Location: Orgaos.php');
            exit();
        }

        if ($this->model->save(['nome' => $nome])) {
            $_SESSION['message'] = 'Órgão cadastrado com sucesso!';
        } else {
            $_SESSION['message'] = 'Erro ao cadastrar o órgão.';
        }

        header('Location: Orgaos.php');
        exit();
    }

    /**
     * Exclui um órgão.
     */
    public function excluir()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id || !$this->model->deleteById($id)) {
            $_SESSION['message'] = 'Erro ao excluir o órgão.';
        } else {
            $_SESSION['message'] = 'Órgão excluído com sucesso!';
        }

        header('Location: Orgaos.php');
        exit();
    }
}