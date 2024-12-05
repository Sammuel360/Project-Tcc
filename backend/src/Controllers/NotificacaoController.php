<?php

namespace Source\Controllers;

use Source\Models\NotificacaoModel;

class NotificacaoController
{
    private $notificacaoModel;

    public function __construct()
    {
        $this->notificacaoModel = new NotificacaoModel();
    }

    public function all()
    {
        $notificacoes = $this->notificacaoModel->listAll();
        require 'tema/admin/notificacoes.php'; // Página que lista as notificações
    }

    public function enviar(int $usuario_id, int $chamado_id, string $mensagem)
    {
        if ($this->notificacaoModel->save([
            'usuario_id' => $usuario_id,
            'chamado_id' => $chamado_id,
            'mensagem' => $mensagem
        ])) {
            header("Location: index.php?message=Notificação enviada com sucesso!");
        } else {
            header("Location: index.php?error=Erro ao enviar notificação.");
        }
    }

    public function deletar(int $id)
    {
        if ($this->notificacaoModel->deleteById($id)) {
            header("Location: index.php?message=Notificação deletada com sucesso!");
        } else {
            header("Location: index.php?error=Erro ao deletar notificação.");
        }
    }
}
