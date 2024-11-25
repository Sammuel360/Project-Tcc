<?php

namespace Source\Controllers;

use Source\Models\ChamadoModel;
use Source\Models\OrgaoModel;

require_once __DIR__ . '/../Models/OrgaoModel.php'; // Inclui OrgaoModel.php corretamente

class ChamadoController
{
    private $model;

    public function __construct()
    {
        $this->model = new ChamadoModel();
    }

    /**
     * Método para exibir o formulário de abertura de chamados
     */
    public function abrirFormulario()
    {
        // Obter todos os órgãos cadastrados no banco
        $orgaos = $this->model->getAllOrgaos();

        // Inclui a view e passa os dados necessários
        require 'tema/admin/Chamados.php';
    }

    /**
     * Método para processar a inserção de um novo chamado
     */
    public function inserir()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Captura e sanitiza os dados enviados pelo formulário
            $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $usuario_id = filter_input(INPUT_POST, 'usuario_id', FILTER_VALIDATE_INT);
            $orgao_id = filter_input(INPUT_POST, 'orgao_id', FILTER_VALIDATE_INT) ?: null;

            // Validação dos campos obrigatórios
            if (empty($titulo) || empty($descricao) || empty($cep) || empty($endereco) || empty($usuario_id)) {
                $_SESSION['message'] = 'Por favor, preencha todos os campos obrigatórios!';
                header('Location: index.php?c=chamado&a=abrirFormulario');
                exit();
            }

            // Dados a serem salvos no banco
            $data = [
                'titulo' => $titulo,
                'descricao' => $descricao,
                'cep' => $cep,
                'endereco' => $endereco,
                'usuario_id' => $usuario_id,
                'orgao_id' => $orgao_id,
                'status' => 'pendente', // Status inicial do chamado
            ];

            // Tentativa de salvar o chamado
            if ($this->model->save($data)) {
                $idChamado = $this->model->getLastInsertId();
                header('Location: index.php?c=chamado&a=detalhes&id=' . $idChamado);
                exit();
            } else {
                $_SESSION['message'] = $this->model->message ?? 'Erro ao salvar o chamado.';
                header('Location: index.php?c=chamado&a=abrirFormulario');
                exit();
            }
        } else {
            // Caso não seja uma requisição POST, redireciona para o formulário
            $this->abrirFormulario();
        }
    }

    /**
     * Método para exibir os detalhes de um chamado específico
     */
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

        // Inclui a view com os detalhes do chamado
        require 'tema/admin/DetalhesChamado.php';
    }
}
