<?php

/**
* Devuelve array
* @param type $string format "[2 digit lang code]:text;" 
* return array id + languages
*/
function explode_lang_string_to_array($string)
{
    $cat = array();
    $vec = explode(';',$string,-1);       
    if(!empty($vec))
    {    
        foreach($vec as $reg)
        {
            $reg = explode(':',$reg);
            if(!empty($reg[0]))
            { 
                $cat[$reg[0]] = $reg[1];                   
            }
        }      
    }   
    return $cat;       
} 

/**
 * Extracts current language text form fields.
 * If no exist, drops generic text.
 * @param type $result
 * @return array 
 */
function translate_current_language($result)
{
    $gen_result = array();
    foreach($result as $reg)
    {
        $gen_reg = '';
        foreach($reg as $key => $field)
        {
            $vec = explode_lang_string_to_array($field);
            if(!empty($vec) && array_key_exists(CURRENT_LANGUAGE,$vec)) $field = $vec[CURRENT_LANGUAGE];
            $gen_reg->{$key} = $field;
        }
        array_push($gen_result, $gen_reg);         
    }
    return $gen_result;
}
