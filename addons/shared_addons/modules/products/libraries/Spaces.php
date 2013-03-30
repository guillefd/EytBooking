<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product Spaces Class
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

class Spaces
{
  
    /**
        * Constructor - Sets loads and vars
        *
        */
    function __construct()
    {
        $this->t_accounts = "accounts";
        $this->t_locations = "products_locations";
        $this->t_spaces = "products_spaces";                
    }
            

    /**
     * get
     * return array
     */
    public function get_by_id($id)
    {
        return ci()->db->select('*')
                    ->where(array('space_id' => $id))
                    ->get($this->t_spaces)
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