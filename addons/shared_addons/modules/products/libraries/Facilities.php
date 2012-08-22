<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Facilities Class
 *
 * Facilities Library
 *
 * @package			CodeIgniter
 * @subpackage                  Libraries
 * @category                    Libraries
 * @author			Guillermo Dova
 * @license			
 * @link			
 */

class Facilities
{
  
    /**
        * Constructor - Sets loads and vars
        *
        */
    function __construct()
    {
        $this->_table = "products_spaces_facilities";   
        
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
     * @return array multidimensional
     */
    public function gen_dd_array()
    {
        $vec = array();
        if($result = $this->get() )
        {
            foreach($result as $reg)
            {                              
                $cat = $this->explode_id_cat($reg->category);
                $vec_name = $this->explode_name_lang($reg->name);
                //multidimensional array
                $vec[$cat[CURRENT_LANGUAGE]][$reg->id] =  array_key_exists(CURRENT_LANGUAGE,$vec_name) ? $vec_name[CURRENT_LANGUAGE] : $vec_name['en'];
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
    
    
    /**
     * Devuelve array
     * @param type $string 
     * return array id + languages
     */
    public function explode_id_cat($string)
    {
        $cat = array();
        $vec = explode(';',$string);       
        foreach($vec as $reg)
        {
            $reg = explode(':',$reg);
            if(!empty($reg[0]))
            { 
                $cat[$reg[0]] = $reg[1];                   
            }
        }      
        return $cat;       
    }    
    
} 