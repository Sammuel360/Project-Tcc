<?php

namespace Source\Controllers;

use Source\Models\ChamadoModel;
use Source\Models\OrgaoModel;

class ChamadoController
{
    private $chamadoModel;
    private $orgaoModel;


    public function __construct(ChamadoModel $chamadoModel, OrgaoModel $orgaoModel)
    {

        // Injeção de dependência dos modelos
        $this->chamadoModel = $chamadoModel;
        $this->orgaoModel = $orgaoModel;
    }

    /**
     * Exibe o formulário para abrir um novo chamado, passando os órgãos disponíveis.
     *
     * @return void
     */
    public function abrirFormulario(): void
    {
        try {


            // Obtém os órgãos do banco
            $orgaos = $this->orgaoModel->listarOrgao();


            // Armazena os órgãos na sessão para a view
            $_SESSION['orgaos'] = $orgaos;

            // Inclui a view com os dados dos órgãos
            require_once __DIR__ . '/../../tema/admin/pages/chamados.php';
        } catch (\Exception $e) {
            // Exibe uma mensagem de erro genérica (substituir por logging em produção)
            echo "Erro ao carregar formulário: " . $e->getMessage();
        }
    }

    /**
     * Insere um novo chamado no banco de dados.
     *
     * @return void
     */
    public function inserir()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validação dos dados recebidos
            $dadosChamado = $this->validarDadosChamado();

            // Se algum dado for inválido, redireciona para o formulário
            if (!$dadosChamado) {
                header('Location: index.php?c=chamado&a=abrirFormulario');
                exit();
            }

            // Chama o método de inserção no modelo
            $novoChamado = $this->chamadoModel->inserirChamado($dadosChamado);

            // Verifica o sucesso da inserção
            if ($novoChamado) {
                $_SESSION['message'] = 'Chamado aberto com sucesso!';
                header('Location: index.php?c=chamado&a=detalhes&id=' . $novoChamado->id);
            } else {
                $_SESSION['message'] = $this->chamadoModel->getMessage() ?? 'Erro ao salvar o chamado.';
                header('Location: index.php?c=chamado&a=abrirFormulario');
            }
            exit();
        }

        // Redireciona de volta ao formulário caso o método não seja POST
        header('Location: index.php?c=chamado&a=abrirFormulario');
        exit();
    }

    /**
     * Exibe os detalhes de um chamado específico.
     *
     * @return string Caminho da view de detalhes do chamado.
     */
    public function detalhes()
    {
        $idChamado = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$idChamado) {
            $_SESSION['message'] = 'Chamado inválido!';
            header('Location: index.php');
            exit();
        }

        $chamado = $this->chamadoModel->findById($idChamado);

        if (!$chamado) {
            $_SESSION['message'] = 'Chamado não encontrado!';
            header('Location: index.php');
            exit();
        }

        $_SESSION['chamado'] = $chamado; // Passa os detalhes do chamado para a sessão
        return "tema/admin/pages/DetalhesChamado.php";
    }

    /**
     * Valida os dados do chamado recebidos do formulário.
     *
     * @return array|false Dados válidos ou false em caso de erro
     */
    private function validarDadosChamado()
    {
        $dadosChamado = [
            'titulo' => filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'descricao' => filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'cep' => filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_NUMBER_INT),
            'endereco' => filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'usuario_id' => $_SESSION['usuario_id'] ?? null, // Pega o ID do usuário da sessão
            'orgao_id' => filter_input(INPUT_POST, 'orgao_id', FILTER_VALIDATE_INT),
        ];

        // Verifica se há campos obrigatórios vazios
        foreach ($dadosChamado as $campo => $valor) {
            if (empty($valor)) {
                $_SESSION['message'] = "O campo '$campo' é obrigatório.";
                return false; // Retorna falso caso algum campo esteja vazio
            }
        }

        return $dadosChamado;
    }
}
