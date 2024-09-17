<?php

namespace Source\Controllers;

use Source\Models\ChamadoModel;

class ChamadoController
{
    private $chamadoModel;

    public function __construct()
    {
        $this->chamadoModel = new ChamadoModel();
    }

    public function all()
    {
        return $this->chamadoModel->all();
    }

    public function inserir($usuario_id, $descricao)
    {
        $this->chamadoModel->usuario_id = $usuario_id;
        $this->chamadoModel->descricao = $descricao;

        $this->chamadoModel->save();

        if ($this->chamadoModel->getMessage()) {
            header("Location: index.php?m={$this->chamadoModel->getMessage()}");
            exit;
        }
    }

    public function deletar($id)
    {
        $this->chamadoModel->id = $id;
        $this->chamadoModel->destroy();
    }
}
