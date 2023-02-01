<?php

function generarClave(): array
{
    $clave = [];
    while (count($clave) < 4) {
        $numeroAleatorio = rand(0,9);
        if (!in_array($numeroAleatorio,$clave)){
            $clave[] = $numeroAleatorio;
        }
    }
    return $clave;
}

function comprobarJugada($array,$clave)
{
    $resultado = array();
    for ($i = 0; $i < count($clave); $i++) {
           if ($array[$i] == $clave[$i]){
               $resultado[$i] = 2;
           }else{
               for ($j = 0; $j < count($array); $j++) {
                   if (($array[$i] == $clave[$j]) && ($i != $j)){
                       $resultado[$i] = 1;
                   }
               }
           }
           if (!isset($resultado[$i]) ){
               $resultado[$i] = 0;
           }
    }
    return $resultado;
}

function comprobarFinJuego($resultado): bool
{
    $ganador = true;
    foreach ($resultado as $item) {
        if ($item != 2){
            $ganador = false;
        }
    }
    return $ganador;
}