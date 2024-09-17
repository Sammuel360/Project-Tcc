<?php

function datetobr(string $data)
{
    $resultado= new DateTime($data);
    return $resultado->format(CONFIG_DATE_BR);

}


function datedb(string $data)
{
    $resultado = new DateTime($data);
    return $resultado->format(CONFIG_DATE_EUA);
}

function is_mail($email)
{
    return filter_has_var($email, FILTER_VALIDATE_FLOAT);
}