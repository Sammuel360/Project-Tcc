<?php

namespace Source\Controllers;

use Source\Models\AnexoModel;

class AnexoController
{
    private $anexoModel;

    public function __construct()
    {
        $this->anexoModel = new AnexoModel();
    }

    public function all()
    {
        return $this->anexoModel->all();
    }

    public function inserir($chamado_id, $caminho)
    {
        $this->anexoModel->chamado_id = $chamado_id;
        $this->anexoModel->caminho = $caminho;

        $this->anexoModel->save();

        if ($this->anexoModel->getMessage()) {
            header("Location: index.php?m={$this->anexoModel->getMessage()}");
            exit;
        }
    }

    public function deletar($id)
    {
        $this->anexoModel->id = $id;
        $this->anexoModel->destroy();
    }
}