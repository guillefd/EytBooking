<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Usage Units Class
 *
 * Usage units Library
 *
 * @package			CodeIgniter
 * @subpackage                  Libraries
 * @category                    Libraries
 * @author			Guillermo Dova
 * @license			
 * @link			
 */

class Shapes
{
  
    /**
        * Constructor - Sets loads and vars
        *
        */
    function __construct()
    {
        $this->_table = "products_spaces_shapes";   
        
    }
            

    /**
     * get
     * Get list of features categories
     * return array
     */
    public function get()
    {
        $q = ci()->db->get($this->_table);      
        if($q->num_rows()>0)
        {
            return $data = $q->result();
        }
        else
        {
            return FALSE;
        }  
    }
    
    /**
     * genera array para dropdowns form
     * @param type $result
     * @return array 
     */
    public function gen_dd_array()
    {
        $vec = array();
        if($result = $this->get() )
        {
            foreach($result as $reg)
            {              
                $vec_name = $this->explode_name_lang($reg->name);
                $vec[$reg->id] =  array_key_exists(CURRENT_LANGUAGE,$vec_name) ? $vec_name[CURRENT_LANGUAGE] : $vec_name['en'];
            }
        }
        return $vec;
    }

    /**
     * Devuelve array de nombres por idiomas
     * @param type $string 
     */
    public function explode_name_lang($string)
    {
        $names = array();
        $vec = explode(';',$string);       
        foreach($vec as $reg)
        {
            $name = explode(':',$reg);
            if(!empty($name[0]))
            { 
                $names[$name[0]] = $name[1];                 
            }
        }      
        return $names;       
    }
    
} 