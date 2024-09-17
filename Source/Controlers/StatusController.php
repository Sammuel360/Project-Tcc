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

    public function all()
    {
        return $this->statusModel->all();
    }

    public function inserir($chamado_id, $status_anterior, $status_atual)
    {
        $this->statusModel->chamado_id = $chamado_id;
        $this->statusModel->status_anterior = $status_anterior;
        $this->statusModel->status_atual = $status_atual;

        $this->statusModel->save();

        if ($this->statusModel->getMessage()) {
            header("Location: index.php?m={$this->statusModel->getMessage()}");
            exit;
        }
    }

    public function deletar($id)
    {
        $this->statusModel->id = $id;
        $this->statusModel->destroy();
    }
}