<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Geoworldmap Class
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

class Geoworldmap
{
  
    /**
        * Constructor - Sets loads and vars
        *
        */
    function __construct()
    {
        //global object    
        $this->t_countries = 'geo_countries'; 
        $this->t_cities = 'geo_cities';
            
    }    
    
    /**
     * Devuelve array de paises
     * @return type array 
     */
    public function all_countries()
    {
        $countries = array();
        ci()->db->order_by('Country', 'ASC');
        if ($result = ci()->db->get($this->t_countries)->result())
        {
                foreach ($result as $country)
                {
                        $countries[$country->CountryId] = $country->Country;
                }
        }        
        return $countries;        
    }
    

    /**
     * Devuelve objeto Ciudad (datos completos)
     * @param type integer $id 
     * @return type object
     */    
    public function getCityByID($id)
    {
        $q = ci()->db->get_where($this->t_cities, array('CityID' => $id));      
        if($q->num_rows()>0)
        {
            $data = $q->row();
        }
        else
        {
            $data->City = "";
        }        
        return $data;
    }    
    
}

/* End of file XXX.php */
/* Location: ./application/controllers/XXX.php */
