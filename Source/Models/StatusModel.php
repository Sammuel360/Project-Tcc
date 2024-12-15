<?php

namespace Source\Models;

use Source\Core\Model;

class StatusModel extends Model
{
    private static $entity = "historico_status";
    private static $id = "id";
    private static $idCalled = "chamado_id";
    private static $status = "status"; // Campo que armazena o status no histórico

    /**
     * Retorna todos os registros que têm o chamado_id inserido.
     * 
     * @param int $chamadoId O id do chamado a ser encontrado
     * @return StatusModel[]|null Um array de objetos StatusModel, ou null caso não haja registros na tabela.
     */
    public function listByChamadoId(int $chamadoId): ?array
    {
        // Prepara a query de seleção dos registros associados ao chamado
        $sql = "SELECT * FROM " . self::$entity . " WHERE " . self::$idCalled . " = :chamado_id ORDER BY data_alteracao DESC";

        // Define os parâmetros da query como uma string no formato "chamado_id=value"
        $params = "chamado_id=" . $chamadoId;

        // Executa a query
        $stmt = $this->read($sql, $params); // Passa os parâmetros como string

        // Verifica se ocorreu algum erro ou não há registros
        if ($this->getFail()) {
            $this->typeMessage = "error";
            $this->message = "Erro ao buscar histórico de status.";
            return null;
        }

        if (!$stmt->rowCount()) {
            $this->typeMessage = "warning";
            $this->message = "Nenhum status encontrado para este chamado.";
            return null;
        }

        // Retorna os registros encontrados como um array de objetos StatusModel
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * Insere o status inicial no histórico de status do chamado.
     * 
     * @param int $chamadoId O id do chamado
     * @param int $usuarioId O id do usuário que está registrando o chamado
     * @param int|null $orgaoId O id do órgão, se disponível
     * @return bool Retorna true se a inserção for bem-sucedida, ou false em caso de falha.
     */
    public function inserirStatusInicial(int $chamadoId, int $usuarioId, ?int $orgaoId = null): bool
    {
        $statusInicial = 'pendente';
        $observacao = 'Chamado criado e aguardando análise.';

        // Query condicional caso $orgaoId seja opcional
        $sql = "INSERT INTO " . self::$entity . " (" . self::$idCalled . ", " . self::$status . ", data_alteracao, observacao, usuario_id" . ($orgaoId !== null ? ", orgao_id" : "") . ") VALUES (:chamado_id, :status, NOW(), :observacao, :usuario_id" . ($orgaoId !== null ? ", :orgao_id" : "") . ")";

        // Parâmetros obrigatórios
        $params = [
            ":chamado_id" => $chamadoId,
            ":status" => $statusInicial,
            ":observacao" => $observacao,
            ":usuario_id" => $usuarioId
        ];

        if ($orgaoId !== null) {
            $params[":orgao_id"] = $orgaoId;
        }

        try {
            // Log dos parâmetros antes de executar a query
            error_log("Parâmetros SQL: " . print_r($params, true));

            // Executa a query e retorna o ID do registro
            $lastInsertId = $this->create($sql, $params);

            if ($lastInsertId === null) {
                error_log("Erro: Nenhum ID retornado após inserção.");
                $this->typeMessage = "error";
                $this->message = "Erro ao inserir status inicial no histórico.";
                return false;
            }

            // Log para confirmar a inserção
            error_log("Status inicial inserido com sucesso para o chamado ID: " . $chamadoId);

            return true;
        } catch (\Exception $e) {
            // Logar detalhes do erro
            error_log("Erro ao inserir status inicial: " . $e->getMessage());
            $this->typeMessage = "error";
            $this->message = "Erro inesperado ao inserir status inicial.";
            return false;
        }
    }

    /**
     * Atualiza o status do chamado.
     * 
     * @param int $chamadoId O id do chamado
     * @param string $novoStatus O novo status a ser inserido
     * @return bool Retorna true se a inserção for bem-sucedida, ou false em caso de falha.
     */
    public function atualizarStatus(int $chamadoId, string $novoStatus): void
    {
        try {
            $resultado = $this->statusModel->atualizarStatus($chamadoId, $novoStatus);

            if ($resultado) {
                $_SESSION['message'] = 'Status atualizado com sucesso!';
            } else {
                $_SESSION['error'] = 'Erro ao atualizar status.';
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Erro ao atualizar status. Tente novamente.';
            error_log("Erro ao atualizar status: " . $e->getMessage());
        } finally {
            header("Location: detalhesChamado.php?id=" . $chamadoId);
            exit;
        }
    }
}