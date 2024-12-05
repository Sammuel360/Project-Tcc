<?php

namespace backend\src\Controllers;

use Backend\Src\Models\OrgaoModel;
use Backend\Src\Models\ChamadoModel;

class ChamadoController
{
    private $model;
    private $orgaoModel;

    public function __construct()
    {
        $this->model = new ChamadoModel();
        $this->orgaoModel = new OrgaoModel();  // Agora estamos instanciando o OrgaoModel corretamente
    }

    public function abrirFormulario()
    {
        // Obtendo a lista de órgãos
        $orgaos = $this->orgaoModel->all();

        // Passando a lista de órgãos para a view
        return '/../../tema/admin/chamados.php';  // Certifique-se de que o caminho está correto
    }


    public function inserir()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (empty($titulo) || empty($descricao) || empty($cep) || empty($endereco) || empty($usuario_id)) {
                $_SESSION['message'] = 'Por favor, preencha todos os campos obrigatórios!';
                header('Location: index.php?c=chamado&a=abrirFormulario');
            }

            //Salvar no banco de dados os valores recebidos
            $this->model->titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->model->descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->model->cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->model->endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->model->usuario_id = filter_input(INPUT_POST, 'usuario_id', FILTER_VALIDATE_INT);
            $this->model->orgao_id = filter_input(INPUT_POST, 'orgao_id', FILTER_VALIDATE_INT);

            if ($this->model->save()) {
                $_SESSION['message'] = 'Chamado aberto com sucesso!';
                header('Location: index.php?c=chamado&a=detalhes&id=' . $this->model->id);
            } else {
                $_SESSION['message'] = $this->model->message ?? 'Erro ao salvar o chamado.';
                header('Location: index.php?c=chamado&a=abrirFormulario');
            }
        }

        $this->abrirFormulario();
    }

    public function detalhes()
    {
        $idChamado = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$idChamado) {
            $_SESSION['message'] = 'Chamado inválido!';
            header('Location: index.php');
            exit();
        }

        $chamado = $this->model->findById($idChamado);

        if (!$chamado) {
            $_SESSION['message'] = 'Chamado não encontrado!';
            header('Location: index.php');
            exit();
        }

        return '/../frontend/pages/DetalhesChamado.php';
    }
}
