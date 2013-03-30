<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product Locations Class
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

class Locations
{
  
    /**
        * Constructor - Sets loads and vars
        *
        */
    function __construct()
    {
        $this->_locations_table = "products_locations";
    }
            

    /**
     * get
     * return array
     */
    public function get_by_id($id)
    {
        return ci()->db->select('*')
                    ->where(array('id' => $id))
                    ->get($this->_locations_table)
                    ->row();
    }
  
} 