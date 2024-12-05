<?php

namespace Source\Controllers;

use Source\Models\ChamadoModel;
use Source\Models\OrgaoModel;

class ChamadoController
{
    private $model;
    private $orgaoModel;

    public function __construct()
    {
        $this->model = new ChamadoModel();
        $this->orgaoModel = new OrgaoModel();  // Agora estamos instanciando o OrgaoModel corretamente
    }

    public function abrirFormulario(): void
    {
        try {
            // Obtém os órgãos do banco
            $orgaos = $this->orgaoModel->listarTodos();

            // Armazena os órgãos na sessão para a view
            $_SESSION['orgaos'] = $orgaos;

            // Inclui a view com os dados dos órgãos
            require_once __DIR__ . '/../../tema/admin/chamados.php';
        } catch (\Exception $e) {
            // Exibe uma mensagem de erro genérica (substituir por logging em produção)
            echo "Erro ao carregar formulário: " . $e->getMessage();
        }
    }

    public function inserir()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitização dos dados de entrada
            $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $orgao_id = filter_input(INPUT_POST, 'orgao_id', FILTER_VALIDATE_INT);

            // Verificar se o usuário está logado
            if (!isset($_SESSION['usuario_id'])) {
                $_SESSION['message'] = 'Você precisa estar logado para abrir um chamado!';
                header('Location: index.php?c=login');
                exit();
            }

            $usuario_id = $_SESSION['usuario_id'];

            // Validar os campos obrigatórios
            if (empty($titulo) || empty($descricao) || empty($cep) || empty($endereco) || empty($orgao_id)) {
                $_SESSION['message'] = 'Por favor, preencha todos os campos obrigatórios!';
                header('Location: index.php?c=chamado&a=abrirFormulario');
                exit();
            }

            // Validar se o órgão selecionado existe
            $orgao = $this->orgaoModel->findById($orgao_id);
            if (!$orgao) {
                $_SESSION['message'] = 'Órgão inválido!';
                header('Location: index.php?c=chamado&a=abrirFormulario');
                exit();
            }

            // Preparar os dados para salvar
            $data = [
                'titulo' => $titulo,
                'descricao' => $descricao,
                'cep' => $cep,
                'endereco' => $endereco,
                'usuario_id' => $usuario_id,
                'orgao_id' => $orgao_id,
                'status' => 'pendente',
                'data_hora' => date('Y-m-d H:i:s')
            ];

            // Atribui os dados ao objeto do modelo
            // Atribui os dados ao objeto do modelo
            $this->model->data = (object)$data;

            // Verifica se o método 'insertChamado' existe e chama
            if (method_exists($this->model, 'insertChamado') && $this->model->insertChamado()) {
                // Sucesso
                $_SESSION['message'] = 'Chamado aberto com sucesso!';
                header('Location: index.php?c=chamado&a=detalhes&id=' . $this->model->data->id);
            } else {
                // Falha
                $_SESSION['message'] = $this->model->message ?? 'Erro ao abrir o chamado!';
                header('Location: index.php?c=chamado&a=abrirFormulario');
            }
        }
    }






    public function detalhes()
    {
        $idChamado = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$idChamado) {
            $_SESSION['message'] = 'Chamado inválido!';
            header('Location: index.php');
            exit();
        }

        // Busca o chamado pelo ID
        $chamado = $this->model->findById($idChamado);

        if (!$chamado) {
            $_SESSION['message'] = 'Chamado não encontrado!';
            header('Location: index.php');
            exit();
        }

        // Exibe os detalhes do chamado
        require __DIR__ . '/../../tema/admin/DetalhesChamado.php';
    }
}