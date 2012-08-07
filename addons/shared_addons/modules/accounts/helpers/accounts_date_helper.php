<?php

/**
 * Funciones de asistencia a fechas, dias, horas, etc
 */


function gen_lista_horas()
{
    $hour_array = array('');
    for($i=9;$i<=20;$i++)
    { 
        $hour_array[$i.':00'] = $i.':00';         
    }
    return $hour_array;
}


