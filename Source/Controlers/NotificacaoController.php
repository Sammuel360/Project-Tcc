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
        return $this->notificacaoModel->all();
    }

    public function inserir($usuario_id, $chamado_id, $mensagem)
    {
        $this->notificacaoModel->usuario_id = $usuario_id;
        $this->notificacaoModel->chamado_id = $chamado_id;
        $this->notificacaoModel->mensagem = $mensagem;

        $this->notificacaoModel->save();

        if ($this->notificacaoModel->getMessage()) {
            header("Location: index.php?m={$this->notificacaoModel->getMessage()}");
            exit;
        }
    }

    public function deletar($id)
    {
        $this->notificacaoModel->id = $id;
        $this->notificacaoModel->destroy();
    }
}