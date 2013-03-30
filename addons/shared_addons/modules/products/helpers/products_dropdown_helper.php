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


function gen_dd_yes_no()
{
	return array(''=>'','0'=>lang('products_no_label'),'1'=>lang('products_yes_label'));
}

function gen_dd_yes_no_filter()
{
    return array('0'=>lang('products_no_label'),'1'=>lang('products_yes_label'));
}

function gen_dd_status()
{
    return array(''=>lang('products_all_label'),'1'=>lang('products_active'),'0'=>lang('products_inactive'));
}