<?php

$senha = NULL;
var_dump($senha);
$senha_crypt = password_hash($senha, PASSWORD_DEFAULT);
var_dump($senha_crypt);

// Verificando se a senha está correta
if (password_verify($senha, $senha_crypt)) {
    echo "Senha válida!";
} else {
    echo "Senha inválida!";
}