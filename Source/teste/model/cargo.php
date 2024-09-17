<?php
use Source\Models\Cargo;

require "../../core/Connect.php";
require "../../core/Model.php";
require "../../Models/Cargo.php";

//pra testar é preciso instanciar a classe Model
$cargo = new Cargo();

//$lista = $cargo->all(); //criamos uma variavel para armazenar o resultado do método "All"
//var_dump($lista);

$cargo->idcargo = 15; //antes de chamar o método destroy, é nescessário carregar o objeto com o id do cargo
$cargo->destroy(); //somento será deletado o id informado ou o id carregado
echo $cargo->getMessage(); //quando o cargo é deletado ele mostr a mensagem" carregado com sucesso!"

//$lista[1]->destroy();
//echo $lista[1]->getMessage();








