<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Location Class
 *
 * Info of location
 *
 * @package			CodeIgniter
 * @subpackage                  Libraries
 * @category                    Libraries
 * @author			Guillermo Dova
 * @license			
 * @link			
 */

class Products
{
  
    /**
        * Constructor - Sets loads and vars
        *
        */
    function __construct()
    {
        //global object    
        $this->t_locations = 'products_locations'; 
            
    }        
    

    /**
        * Returns unique location by ID
        * @param type $id
        * @return boolean 
        */
    public function get_location($id, $active = 1)
    {
        $q = ci()->db->get_where($this->t_locations, array('id' => $id,'active'=>$active));      
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

/* End of file XXX.php */