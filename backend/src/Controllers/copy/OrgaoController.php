<?php

namespace Source\Controllers;

use Source\Models\OrgaoModel;

require_once __DIR__ . '/../Models/OrgaoModel.php';

class OrgaoController
{
    private $model;

    public function __construct()
    {
        $this->model = new OrgaoModel();
    }

    /**
     * Lista todos os órgãos e exibe-os na tela
     */
    public function listar(): array
    {
        return $this->model->listAll(); // Retorna a lista de órgãos
    }
}
