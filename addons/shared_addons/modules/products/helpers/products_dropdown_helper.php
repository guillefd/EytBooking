<?php

/**
 * FUNCIONES PARA GENERAR DROPDOWN LIST
 */

/**
 * Returns array with cat products
 * @param type $result
 * @return type 
 */
function gen_dd_cat_products($result)
{
    $vec = array();
    if(!empty($result))
    {    
        foreach($result as $reg)
        {
            $vec[$reg->id] = $reg->title;
        }
    }    
    return $vec;
}


