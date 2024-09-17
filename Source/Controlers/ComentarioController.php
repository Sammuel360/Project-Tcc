<?php

namespace Source\Controllers;

use Source\Models\ComentarioModel;

class ComentarioController
{
    private $comentarioModel;

    public function __construct()
    {
        $this->comentarioModel = new ComentarioModel();
    }

    public function all()
    {
        return $this->comentarioModel->all();
    }

    public function inserir($chamado_id, $usuario_id, $conteudo)
    {
        $this->comentarioModel->chamado_id = $chamado_id;
        $this->comentarioModel->usuario_id = $usuario_id;
        $this->comentarioModel->conteudo = $conteudo;

        $this->comentarioModel->save();

        if ($this->comentarioModel->getMessage()) {
            header("Location: index.php?m={$this->comentarioModel->getMessage()}");
            exit;
        }
    }

    public function deletar($id)
    {
        $this->comentarioModel->id = $id;
        $this->comentarioModel->destroy();
    }
}