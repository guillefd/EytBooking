<?php

/**
 * Funciones para convertir ID´s a texto
 */


/**
 * Devuelve texto del indice buscado
 * @param type $array vector de valores del Tipo de Cuenta
 * @param type $id valor del ID
 * @return string 
 */
function accountTypeID_to_text($array,$id)
{
    if(array_key_exists($id,$array))
    {
        return $array[$id];
    }else
        {
            return '';
        }
}

/**
 *Devuelve texto del tipo de IVA
 * @param type $array
 * @param type $id
 * @return string 
 */
function accountIvaID_to_text($array,$id)
{
    if(array_key_exists($id,$array))
    {
        return $array[$id];
    }else
        {
            return '';
        }
}

/**
 * Quita valores residuales del string de dias/horarios de pago a proveedores 
 * @param type string $string 
 * return type string
 */
function cleanString_DiasHorarios($string)
{
    return str_replace('EMPTY;','',$string);    
}


function StringToHtml_DiasHorarios($string)
{
    $week = ci()->config->item('dd_week_days');
    $html = '';
    $vec = explode(';', $string, 3);
    foreach($vec as $subString)
    {
        $reg = explode(',',$subString);
        $diaN = @$reg[0];
        $desde = @$reg[1];
        $hasta = @$reg[2];
        if(!empty($diaN))$html.= @$week[$diaN].' ('.$desde.' - '.$hasta.')<br>'; 
    }
    return $html;
    
}
