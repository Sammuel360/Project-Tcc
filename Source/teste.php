
/*
<br>* [ a função date] setup | output
<br>* [date] https://php.net/manual/pt_BR/function.date.php
<br> * [ timezones ] https://php.net/manual/pt_BR/timezones.php
 <br>*/

<?php


//date_default_timezone_set("America/Sao_Paulo");
define("CONFIG_DATE_TIMEZONE","America/Sao_Paulo");
date_default_timezone_set (CONFIG_DATE_TIMEZONE);
define("CONFIG_DATE_BR", "d/m/y H:i:s A");




    
   
        
var_dump([
     date_default_timezone_get(),
date(CONFIG_DATE_BR), //formatamos para o padrão BR
 // aqui ele retorna o timezone do servidor
 //retorna a data do servidor no padrão europeu

]);
    


var_dump([
    "strtotime NOW" => strtotime("now"),
    "date DATE_BR" => date(CONFIG_DATE_BR),
    "date +10days" => date(CONFIG_DATE_BR, strtotime("+10days")),
    "date -10days" => date (CONFIG_DATE_BR, strtotime("-10days")),
    "date +1years" => date (CONFIG_DATE_BR, strtotime("+1years")),

]);

//var_dump([

//])

//$date = new DateTime("2020-04-03");


//var_dump([
  //  "Objeto datetime" => $date
// ]);