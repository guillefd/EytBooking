<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Accounts Class
 *
 * Info of Social Nets
 *
 * @package			CodeIgniter
 * @subpackage                  Libraries
 * @category                    Libraries
 * @author			Guillermo Dova
 * @license			
 * @link			
 */

class Social
{
  
    /**
        * Constructor - Sets loads and vars
        *
        */
    function __construct()
    {
        //global object    
        $this->social = array(''=>'','Skype'=>'Skype','Gtalk'=>'Gtalk','MSN'=>'MSN','Facebook'=>'Facebook','Google+'=>'Google+','Twitter'=>'Twitter','Linkedin'=>'Linkedin');
    }
            

    /**
     * get_list
     * Get list of communication and social networks 
     * return object ->comm, ->social
     */
    public function get_list()
    {
        return $this->social;
    }        
    
    
} 
