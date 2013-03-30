<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product Categories Class
 *
 * Categpries Library
 *
 * @package			CodeIgniter
 * @subpackage                  Libraries
 * @category                    Libraries
 * @author			Guillermo Dova
 * @license			
 * @link			
 */

class Categories
{
  
    /**
        * Constructor - Sets loads and vars
        *
        */
    function __construct()
    {
        $this->_cat_table = "products_categories";
        $this->_type_table = "products_type";        
    }
            

    /**
     * get
     * Get category
     * return array
     */
    public function get_by_id($id)
    {
        return ci()->db->select('*')
                    ->where(array('id' => $id))
                    ->get($this->_cat_table)
                    ->row();
    }

    /**
     * get
     * Get list of categories
     * return array
     */
    public function get_categories()
    {
        $q = ci()->db->get($this->_cat_table);      
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
     * get
     * Get list of types
     * return array
     */
    public function get_types()
    {
        $q = ci()->db->get($this->_type_table);      
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
    public function gen_dd_multiarray()
    {
        $vec_categories = array();
        if($categories = $this->get_categories() )
        {
            $types = $this->get_types();
            $vec_types = array();
            foreach($types as $reg)
            {
                $type = $this->explode_string_to_array($reg->title);
                $vec_types[$reg->id] = $type;
            } 
            foreach($categories as $reg)
            {                              
                $category = $this->explode_string_to_array($reg->title);
                //multidimensional array for select dropdown grouping
                $typeTitle = $vec_types[$reg->type_id][CURRENT_LANGUAGE];
                $vec_categories[$typeTitle][$reg->id] =  array_key_exists(CURRENT_LANGUAGE,$category) ? $category[CURRENT_LANGUAGE] : $category['en'];
            }
        }
        return $vec_categories;
    }
    
    /**
     * genera array para dropdowns form
     * @param type $result
     * @return array 
     */
    public function gen_dd_array()
    {
        $vec = array();
        if($result = $this->get_categories() )
        {
            foreach($result as $reg)
            {              
                $vec_name = $this->explode_string_to_array($reg->title);
                $vec[$reg->id] = $this->extract_value_by_language($vec_name);
            }
        }
        return $vec;
    }    
    
    
    public function extract_value_by_language($array)
    {
        return array_key_exists(CURRENT_LANGUAGE,$array) ? $array[CURRENT_LANGUAGE] : $array['en'];
    }
    
    /**
     * Devuelve array
     * @param type $string 
     * return array id + languages
     */
    public function explode_string_to_array($string)
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