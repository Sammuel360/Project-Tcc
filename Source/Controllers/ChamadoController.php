<?php

namespace Source\Controllers;

use Source\Models\ChamadoModel;
use Source\Models\OrgaoModel;

require_once __DIR__ . '/../Models/ChamadoModel.php';
require_once __DIR__ . '/../Models/OrgaoModel.php';

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
            // Obtém os dados do formulário
            $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $orgao_id = filter_input(INPUT_POST, 'orgao_id', FILTER_VALIDATE_INT);

            // Verifica se o usuário está logado
            if (!isset($_SESSION['usuario_id'])) {
                $_SESSION['message'] = 'Você precisa estar logado para abrir um chamado!';
                header('Location: index.php?c=login');
                exit();
            }

            // O ID do usuário logado será obtido da sessão
            $usuario_id = $_SESSION['usuario_id'];

            // Verifica se os campos obrigatórios foram preenchidos
            if (empty($titulo) || empty($descricao) || empty($cep) || empty($endereco) || empty($orgao_id)) {
                $_SESSION['message'] = 'Por favor, preencha todos os campos obrigatórios!';
                header('Location: index.php?c=chamado&a=abrirFormulario');
                exit();
            }

            // Verifica se o órgão existe
            $orgao = $this->orgaoModel->findById($orgao_id);
            if (!$orgao) {
                $_SESSION['message'] = 'Órgão inválido!';
                header('Location: index.php?c=chamado&a=abrirFormulario');
                exit();
            }

            // Dados para inserir no banco de dados
            $data = [
                'titulo' => $titulo,
                'descricao' => $descricao,
                'cep' => $cep,
                'endereco' => $endereco,
                'usuario_id' => $usuario_id, // O ID do usuário logado
                'orgao_id' => $orgao_id,
                'status' => 'pendente',  // O status padrão é 'pendente'
                'data_hora' => date('Y-m-d H:i:s')
            ];

            // Tenta salvar o chamado
            if ($this->model->save($data)) {
                $lastInsertId = $this->model->getLastInsertId(); // Pegando o ID do último chamado inserido
                $_SESSION['message'] = 'Chamado aberto com sucesso!';
                header("Location: index.php?c=chamado&a=detalhes&id=$lastInsertId");
                exit();
            } else {
                $_SESSION['message'] = 'Erro ao salvar o chamado. Tente novamente.';
                header('Location: index.php?c=chamado&a=abrirFormulario');
                exit();
            }
        }

        // Chama o formulário de abertura de chamados
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