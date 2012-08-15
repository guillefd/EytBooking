<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Features Categories Class
 *
 * Features categories Library
 *
 * @package			CodeIgniter
 * @subpackage                  Libraries
 * @category                    Libraries
 * @author			Guillermo Dova
 * @license			
 * @link			
 */

class Cat_features
{
  
    /**
        * Constructor - Sets loads and vars
        *
        */
    function __construct()
    {
        $this->_table = "products_features_categories";   
        
    }
            

    /**
     * get
     * Get list of features categories
     * return array
     */
    public function get()
    {
        $q = $this->db->get($this->_table);      
        if($q->num_rows()>0)
        {
            return $data = $q->row();
        }
        else
        {
            return FALSE;
        }  
    }        
    
    
} 