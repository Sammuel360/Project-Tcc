<?php

namespace Source\Controllers;

use Source\Models\StatusModel;

class StatusController
{
    private $statusModel;

    public function __construct()
    {
        $this->statusModel = new StatusModel();
    }

    /**
     * Lista o histórico de status de um chamado específico.
     * 
     * @param int $chamadoId
     */
    public function listarPorChamado(int $chamadoId)
    {
        try {
            $statusList = $this->statusModel->listByChamadoId($chamadoId);

            if ($statusList) {
                // Envia os dados para a tela de detalhes do chamado
                require __DIR__ . "/../../tema/admin/detalhesChamados.php";
            } else {
                header("Location: detalhesChamados.php?error=Nenhum histórico encontrado para este chamado.");
                exit;
            }
        } catch (\Exception $e) {
            header("Location: detalhesChamados.php?error=Erro ao buscar histórico de status.");
            exit;
        }
    }

    /**
     * Insere um novo status para um chamado.
     * 
     * @param array $data
     */
    public function inserir(array $data)
    {
        try {
            // Sanitiza os dados recebidos
            $chamadoId = filter_var($data['chamado_id'], FILTER_SANITIZE_NUMBER_INT);
            $status = filter_var($data['status'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $observacao = filter_var($data['observacao'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Verifica se os dados são válidos
            if (empty($chamadoId) || empty($status)) {
                header("Location: detalhesChamados.php?error=Campos obrigatórios não preenchidos.");
                exit;
            }

            // Salva o novo status no banco
            $result = $this->statusModel->save([
                'chamado_id' => $chamadoId,
                'status' => $status,
                'observacao' => $observacao
            ]);

            if ($result) {
                header("Location: detalhesChamados.php?message=Status atualizado com sucesso.");
                exit;
            } else {
                header("Location: detalhesChamados.php?error=Erro ao salvar o status.");
                exit;
            }
        } catch (\Exception $e) {
            header("Location: detalhesChamados.php?error=Erro ao salvar o status. Tente novamente.");
            exit;
        }
    }

    /**
     * Exclui um status pelo ID.
     * 
     * @param int $id
     */
    public function deletar(int $id)
    {
        try {
            $result = $this->statusModel->deleteById($id);

            if ($result) {
                header("Location: detalhesChamados.php?message=Status removido com sucesso.");
                exit;
            } else {
                header("Location: detalhesChamados.php?error=Erro ao remover o status.");
                exit;
            }
        } catch (\Exception $e) {
            header("Location: detalhesChamados.php?error=Erro ao excluir o status.");
            exit;
        }
    }
}