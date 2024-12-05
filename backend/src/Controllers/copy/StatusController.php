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

    public function index()
    {
        $statuses = $this->statusModel->listAll();
        require 'tema/admin/status.php'; // Página que lista os statuses
    }
}
