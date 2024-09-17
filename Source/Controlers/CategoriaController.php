<?php

namespace Source\Controllers;

use Source\Models\CategoriaModel;

class CategoriaController
{
    private $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
    }

    public function all()
    {
        return $this->categoriaModel->all();
    }

    public function inserir($nome, $descricao)
    {
        $this->categoriaModel->nome = $nome;
        $this->categoriaModel->descricao = $descricao;

        $this->categoriaModel->save();

        if ($this->categoriaModel->getMessage()) {
            header("Location: index.php?m={$this->categoriaModel->getMessage()}");
            exit;
        }
    }

    public function deletar($id)
    {
        $this->categoriaModel->id = $id;
        $this->categoriaModel->destroy();
    }
}