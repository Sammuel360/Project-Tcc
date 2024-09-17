<?php
use Source\Models\FuncionarioModel;

require "../../core/Connect.php";
require "../../core/Model.php";
require "../../Models/FuncionarioModel.php";


$teste = new FuncionarioModel();

$teste->idfuncionario = 1;
$teste->destroy();
 