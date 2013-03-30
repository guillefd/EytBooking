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
        $this->t_accounts = "accounts";
        $this->t_spaces = "products_spaces";           
            
    }        
    
// LOCATIONS ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 
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


// SPACES :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    /**
     * get
     * return array
     */
    public function get_space_by_id($id)
    {
        return ci()->db->select('*')
                    ->where(array('space_id' => $id))
                    ->get($this->t_spaces)
                    ->row();
    }



// ACCOUNTS ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::


    /**
        * Returns unique account by ID
        * @param type $id
        * @return boolean 
        */
    public function get_account($id, $active = 1)
    {
        return ci()->db->select('*')
                    ->where(array('account_id' => $id, 'active'=>$active))
                    ->get($this->t_accounts)
                    ->row();       
    } 


    public function get_account_by_spaceid($space_id)
    {
        return ci()->db->select($this->t_accounts.'.*')
                    ->join($this->t_locations, $this->t_accounts.'.account_id = '.$this->t_locations.'.account_id')
                    ->join($this->t_spaces, $this->t_spaces.'.location_id = '.$this->t_locations.'.id')
                    ->where(array($this->t_spaces.'.space_id' => $space_id))
                    ->get($this->t_accounts)
                    ->row();                            
    }

    
}

/* End of file XXX.php */