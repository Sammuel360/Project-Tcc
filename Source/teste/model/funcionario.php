<?php
use Source\Models\FuncionarioModel;



$teste = new UsuarioModel();
$teste->nome = "Test";
$teste->email = "Test";
$teste->endereco = "Test";
$teste->telefone = "Test";
$teste->senha = "Test";
$teste->cep = "Test";
$teste->estado = "Test";
$teste->cidade = "Test";

$teste->save();
 