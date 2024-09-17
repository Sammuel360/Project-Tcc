<?php

namespace Source\Core;

class NotificacaoModel extends Model
{
    protected $table = 'notificacoes';

    /**
     * Adiciona uma nova notificação para um usuário sobre um chamado.
     * 
     * @param int $usuario_id O ID do usuário.
     * @param int $chamado_id O ID do chamado.
     * @param string $mensagem A mensagem da notificação.
     * @return int|null O ID da nova notificação ou null em caso de falha.
     */
    public function addNotificacao(int $usuario_id, int $chamado_id, string $mensagem): ?int
    {
        $query = "INSERT INTO {$this->table} (usuario_id, chamado_id, mensagem, created_at, updated_at)
                  VALUES (:usuario_id, :chamado_id, :mensagem, NOW(), NOW())";
        $params = http_build_query([
            'usuario_id' => $usuario_id,
            'chamado_id' => $chamado_id,
            'mensagem' => $mensagem
        ]);
        $id = $this->create($query, $params);
        if (!$id) {
            $this->message = "Não foi possível adicionar a notificação.";
        }
        return $id;
    }

    /**
     * Obtém todas as notificações para um usuário específico.
     * 
     * @param int $usuario_id O ID do usuário.
     * @return array|null Array de notificações ou null em caso de falha.
     */
    public function getNotificacoesByUsuario(int $usuario_id): ?array
    {
        $query = "SELECT * FROM {$this->table} WHERE usuario_id = :usuario_id ORDER BY created_at DESC";
        $params = http_build_query(['usuario_id' => $usuario_id]);
        $stmt = $this->read($query, $params);

        if ($stmt && $stmt->rowCount()) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        $this->message = "Nenhuma notificação encontrada para o usuário.";
        return null;
    }

    /**
     * Obtém todas as notificações relacionadas a um chamado específico.
     * 
     * @param int $chamado_id O ID do chamado.
     * @return array|null Array de notificações ou null em caso de falha.
     */
    public function getNotificacoesByChamado(int $chamado_id): ?array
    {
        $query = "SELECT * FROM {$this->table} WHERE chamado_id = :chamado_id ORDER BY created_at DESC";
        $params = http_build_query(['chamado_id' => $chamado_id]);
        $stmt = $this->read($query, $params);

        if ($stmt && $stmt->rowCount()) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        $this->message = "Nenhuma notificação encontrada para o chamado.";
        return null;
    }
}
