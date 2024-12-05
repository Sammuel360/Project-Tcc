<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("vendor/autoload.php");

use Backend\Src\Models\UsuarioModel;

##########################################################
####                                                  ####
##########################################################

$objUsuMod = new UsuarioModel();

$objUsuMod->nome = 'teste';
$objUsuMod->email = 'teste12@gmail.com';
$objUsuMod->senha      = 'teste1';
$objUsuMod->telefone = '12211212';
$objUsuMod->endereco = 'rararara';
$objUsuMod->cidade      = 'cidade de Deus';
$objUsuMod->estado      = 'RJ';
$objUsuMod->cep      = '42424242';
$objUsuMod->data_cadastro      = '';


$objUsuMod->all();
var_dump( $objUsuMod->all());

echo $objUsuMod->getMessage();
echo $objUsuMod->getFail();

//var_dump($objUsuMod);
##########################################################
####                                                  ####
##########################################################