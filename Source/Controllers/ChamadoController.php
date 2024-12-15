<?php

namespace Source\Controllers;

use Source\Models\ChamadoModel;
use Source\Models\OrgaoModel;
use Source\Models\StatusModel;  // Incluindo o StatusModel

class ChamadoController
{
    private $chamadoModel;
    private $orgaoModel;
    private $statusModel; // Adicionando a propriedade para StatusModel
    private $statusController;  // Adicionando a propriedade para StatusController

    public function __construct(ChamadoModel $chamadoModel, OrgaoModel $orgaoModel, StatusModel $statusModel, StatusController $statusController)
    {
        // Injeção de dependência dos modelos
        $this->chamadoModel = $chamadoModel;
        $this->orgaoModel = $orgaoModel;
        $this->statusModel = $statusModel; // Injeção do StatusModel
        $this->statusController = $statusController;  // Injeção do StatusController
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
    /**
     * Insere um novo chamado no banco de dados.
     *
     * @return void
     */
    public function inserir()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Validação dos dados recebidos
                $dadosChamado = $this->validarDadosChamado();

                // Log para depuração
                error_log("Dados recebidos para o chamado: " . print_r($dadosChamado, true));

                if (!$dadosChamado) {
                    $_SESSION['mensagem_erro'] = "Dados inválidos. Por favor, tente novamente.";
                    header('Location: index.php?c=chamado&a=abrirFormulario');
                    exit;
                }

                // Insere o chamado e obtém o ID gerado
                $novoChamadoId = $this->chamadoModel->inserirChamado($dadosChamado);

                if (!$novoChamadoId) {
                    $_SESSION['mensagem_erro'] = "Erro ao criar o chamado.";
                    header('Location: index.php?c=chamado&a=abrirFormulario');
                    exit;
                }

                // Log para verificar o ID do novo chamado
                error_log("ID do chamado inserido: " . $novoChamadoId);

                // Obtem o ID do usuário logado
                $usuarioId = $_SESSION['usuario']->id ?? null;
                if (!$usuarioId) {
                    $_SESSION['mensagem_erro'] = "Usuário não autenticado. Faça login novamente.";
                    header('Location: index.php?c=auth&a=login');
                    exit;
                }

                // Tenta inserir o status inicial na tabela de histórico
                $orgaoId = $dadosChamado['orgao_id'] ?? null;
                $statusInserido = $this->statusModel->inserirStatusInicial($novoChamadoId, $usuarioId, $orgaoId);

                if ($statusInserido) {
                    $_SESSION['mensagem_sucesso'] = "Chamado criado com sucesso!";
                    header('Location: index.php?c=chamado&a=detalhes&id=' . $novoChamadoId);
                    exit;
                } else {
                    $_SESSION['mensagem_erro'] = "Chamado criado, mas houve um erro ao registrar o status inicial.";
                    header('Location: index.php?c=chamado&a=detalhes&id=' . $novoChamadoId);
                    exit;
                }
            } catch (\Exception $e) {
                // Log do erro e mensagem para o usuário
                error_log("Erro ao criar chamado: " . $e->getMessage());
                $_SESSION['mensagem_erro'] = "Erro inesperado ao criar o chamado. Por favor, tente novamente.";
                header('Location: index.php?c=chamado&a=abrirFormulario');
                exit;
            }
        } else {
            $_SESSION['mensagem_erro'] = "Método não permitido.";
            header('Location: index.php?c=chamado&a=abrirFormulario');
            exit;
        }
    }

    /**
     * Exibe os detalhes de um chamado específico.
     *
     * @param int $id ID do chamado a ser exibido
     * @return void
     */
    /**
     * Exibe os detalhes de um chamado, incluindo o histórico de status.
     *
     * @param int $id O ID do chamado a ser exibido.
     * @return void
     */
    /**
     * Exibe os detalhes de um chamado, incluindo o histórico de status.
     *
     * @param int $id O ID do chamado a ser exibido.
     * @return void
     */
    public function detalhes(): void
    {
        try {
            // Pega o ID do chamado pela query string (?id=)
            $chamadoId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

            // Verifica se o ID é válido (número inteiro e maior que 0)
            if (!$chamadoId || $chamadoId <= 0) {
                $_SESSION['mensagem_erro'] = "ID do chamado inválido.";
                header('Location: index.php?c=chamado&a=abrirFormulario');
                exit;
            }

            // Busca os detalhes do chamado pelo ID
            $chamado = $this->chamadoModel->findById($chamadoId);
            if (!$chamado) {
                $_SESSION['mensagem_erro'] = "Chamado não encontrado.";
                header('Location: index.php?c=chamado&a=abrirFormulario');
                exit;
            }

            // Chama o método detalhes do StatusController para obter o histórico de status
            $historicoStatus = $this->statusController->detalhes($chamadoId);

            if (!$historicoStatus) {
                $_SESSION['mensagem_erro'] = "Erro ao carregar histórico de status.";
                header('Location: index.php?c=chamado&a=abrirFormulario');
                exit;
            }

            // Renderiza a view de detalhes, passando os dados do chamado e do histórico de status
            require_once __DIR__ . '/../../tema/admin/pages/detalhesChamado.php';
        } catch (\Exception $e) {
            // Log do erro e mensagem para o usuário
            error_log("Erro ao exibir detalhes do chamado: " . $e->getMessage());
            $_SESSION['mensagem_erro'] = "Erro inesperado ao carregar os detalhes do chamado.";
            header('Location: index.php?c=chamado&a=abrirFormulario');
            exit;
        }
    }








    /**
     * Valida os dados do chamado recebidos do formulário.
     *
     * @return array|false Dados válidos ou false em caso de erro
     */
    private function validarDadosChamado()
    {
        $usuario = $_SESSION['usuario']; // Certifique-se de que $_SESSION['usuario'] existe e contém os dados esperados.

        $dadosChamado = [
            'titulo' => filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'descricao' => filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'cep' => filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_NUMBER_INT),
            'endereco' => filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'usuario_id' => $usuario->id, // Pega o ID do usuário da sessão
            'orgao_id' => filter_input(INPUT_POST, 'orgao_id', FILTER_VALIDATE_INT), // Captura o orgao_id enviado pelo formulário
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