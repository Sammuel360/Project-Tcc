<?php

namespace Source\Controllers;

use Source\Models\StatusModel;

class StatusController
{
    private $statusModel;

    public function __construct(StatusModel $statusModel)
    {
        $this->statusModel = $statusModel;
    }

    /**
     * Lista o histórico de status de um chamado específico.
     * 
     * @param int $chamadoId
     * @return void
     */
    public function listarPorChamado(int $chamadoId): void
    {
        try {
            // Validação do ID do chamado
            if (!$chamadoId || $chamadoId <= 0) {
                throw new \InvalidArgumentException("ID do chamado inválido.");
            }

            // Recupera o histórico de status do chamado
            $statusList = $this->statusModel->listByChamadoId($chamadoId);

            // Armazena o resultado na sessão ou define uma mensagem de aviso
            if ($statusList) {
                $_SESSION['statusList'] = $statusList;
            } else {
                $_SESSION['warning'] = 'Nenhum histórico encontrado para este chamado.';
            }

            // Redireciona para a tela de detalhes do chamado
            header("Location: index.php?c=chamado&a=detalhes&id=" . $chamadoId);
            exit;
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Erro ao buscar histórico de status. Tente novamente.';
            error_log($e->getMessage());
            header("Location: index.php?c=chamado&a=detalhes&id=" . $chamadoId);
            exit;
        }
    }






    /**
     * Atualiza o status de um chamado no histórico.
     *
     * @param int $chamadoId
     * @param string $novoStatus
     * @return void
     */
    public function atualizarStatus(int $chamadoId, string $novoStatus): void
    {
        try {
            // Validação dos parâmetros
            if (!$chamadoId || $chamadoId <= 0) {
                throw new \InvalidArgumentException("ID do chamado inválido.");
            }

            if (empty($novoStatus)) {
                throw new \InvalidArgumentException("Status não pode ser vazio.");
            }

            // Atualiza o status do chamado no modelo
            $resultado = $this->statusModel->atualizarStatus($chamadoId, $novoStatus);

            // Define mensagens de feedback
            if ($resultado) {
                $_SESSION['message'] = 'Status atualizado com sucesso!';
            } else {
                $_SESSION['error'] = 'Erro ao atualizar o status do chamado.';
            }

            // Redireciona para a página de detalhes do chamado
            header("Location: index.php?c=chamado&a=detalhes&id=" . $chamadoId);
            exit;
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Erro ao atualizar o status. Tente novamente.';
            error_log($e->getMessage());
            header("Location: index.php?c=chamado&a=detalhes&id=" . $chamadoId);
            exit;
        }
    }

    /**
     * Insere o status inicial de um chamado, usado durante a criação de um novo chamado.
     * 
     * @param int $chamadoId
     * @param int $usuarioId
     * @param int|null $orgaoId
     * @return bool
     */
    public function inserirStatusInicial(int $chamadoId, int $usuarioId, ?int $orgaoId = null): bool
    {
        try {
            // Validação dos IDs
            if ($chamadoId <= 0 || $usuarioId <= 0) {
                throw new \InvalidArgumentException("IDs de chamado ou usuário inválidos.");
            }

            // Chama o método do modelo para inserir o status inicial
            return $this->statusModel->inserirStatusInicial($chamadoId, $usuarioId, $orgaoId);
        } catch (\Exception $e) {
            error_log("Erro ao inserir status inicial: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Detalha o histórico de status de um chamado específico.
     *
     * @param int $chamadoId
     * @return array|null
     */
    public function detalhes(int $chamadoId): ?array
    {
        try {
            // Valida o ID do chamado
            if ($chamadoId <= 0) {
                throw new \InvalidArgumentException("ID do chamado inválido.");
            }

            // Busca o histórico de status do chamado
            return $this->statusModel->listByChamadoId($chamadoId);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }
}
