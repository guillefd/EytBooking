<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Accounts Class
 *
 * Info of Countrys, regions, cities, locations + webservices
 *
 * @package			CodeIgniter
 * @subpackage                  Libraries
 * @category                    Libraries
 * @author			Guillermo Dova
 * @license			
 * @link			
 */

class Accounts
{
  
    /**
        * Constructor - Sets loads and vars
        *
        */
    function __construct()
    {
        //global object    
        $this->t_accounts = 'accounts'; 
        $this->t_contacts = 'contacts';
            
    }        
    

    /**
        * Returns unique account by ID
        * @param type $id
        * @return boolean 
        */
    public function get_account($id)
    {
        $q = ci()->db->get_where($this->t_accounts, array('account_id' => $id));      
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
/* Location: ./application/controllers/XXX.php */
