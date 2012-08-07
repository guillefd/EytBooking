<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Categories model
 *
 * @package		PyroCMS
 * @subpackage	Categories Module
 * @category	Modules
 * @author		Phil Sturgeon - PyroCMS Dev Team
 */
class Geo_cities_m extends MY_Model
{
        
	/**
	 * The constructor
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();	
		$this->t_countries = 'geo_countries';
		$this->t_regions = 'geo_regions';                
                $this->t_cities = 'geo_cities';
	}
            
	protected $_table = 'geo_cities';
                   
        /**
         * cuenta total items paises
         */
        function count_all()
        {
            return $this->db->count_all($this->t_cities);    
        }        

        /**
         * get count all cities filtered
         * @return type 
         */        
	function count_by($params = array())
	{          
                //country filter    
		if (!empty($params['country']))
		{
                    $this->db->where('geo_cities.CountryID', $params['country']);
		}

		// Is region set?
		if (!empty($params['region']))
		{
                    // Otherwise, show only the specific status
                    $this->db->where('geo_cities.RegionID', $params['region']);
		}

		return $this->db->count_all_results();
	}        
    
        /**
         * get all cities filtered
         * @param type $params
         * @return type 
         */
	function get_many_by($params = array())
	{
            
		$this->db->select($this->t_cities.'.*, '.$this->t_regions.'.Region AS region, '.$this->t_countries.'.Country AS country')
			 ->join($this->t_regions, $this->t_cities.'.RegionID = '.$this->t_regions.'.RegionID', 'left')
			 ->join($this->t_countries, $this->t_cities.'.CountryID = '.$this->t_countries.'.CountryID', 'left');                                       

                if (!empty($params['country']))
		{
			$this->db->where('geo_cities.CountryID', $params['country']);
		}
                
		// Is region set?
		if (!empty($params['region']))
		{
                    // Otherwise, show only the specific region
                    $this->db->where('geo_cities.RegionID', $params['region']);
		}

		// Limit the results based on 1 number or 2 (2nd is offset)
		if (isset($params['limit']) && is_array($params['limit']))
			$this->db->limit($params['limit'][0], $params['limit'][1]);
		elseif (isset($params['limit']))
			$this->db->limit($params['limit']);
                //ordena por nombre de ciudad
                
                $this->db->order_by("City", "ASC");                 
		return $this->db->get($this->t_cities)->result();               
	}
                      
	/**
	 * Searches cities posts based on supplied data array
	 * @param $data array
	 * @return array
	 */
	function search($mode,$data = array())
	{
		$this->db->select($this->t_cities.'.*, '.$this->t_regions.'.Region AS region, '.$this->t_countries.'.Country AS country')
			 ->join($this->t_regions, $this->t_cities.'.RegionID = '.$this->t_regions.'.RegionID', 'left')
			 ->join($this->t_countries, $this->t_cities.'.CountryID = '.$this->t_countries.'.CountryID', 'left');                  
		if (array_key_exists('region', $data) && $data['region']!=0)
		{
			$this->db->where('geo_cities.RegionID', $data['region']);
		}

		if (array_key_exists('country', $data) && $data['country']!=0)
		{
			$this->db->where('geo_cities.CountryID', $data['country']);
		}

		if (array_key_exists('keywords', $data))
		{
                    $this->db->like('geo_cities.City', $data['keywords']);
		}

		// Limit the results based on 1 number or 2 (2nd is offset)
		if (isset($params['limit']) && is_array($params['limit']))
			$this->db->limit($params['limit'][0], $params['limit'][1]);
		elseif (isset($params['limit']))
			$this->db->limit($params['limit']);
                
                $this->db->order_by("City", "ASC"); 
		$q = $this->db->get($this->t_cities);
                
                if($mode =='counts')
                {                
                    return $q->num_rows;
                }
                else
                    {
                        return $q->result();
                    }
	}
        
        /**
         * Get all cities by countryID
         * @param integer $countryid
         * @return boolean 
         */
        function get_ajax_like($pattern,$limit)
        {
		$this->db->select($this->t_cities.'.*, '.$this->t_regions.'.Region AS region, '.$this->t_countries.'.Country AS country,'.$this->t_countries.'.PhoneCode AS countryphonecode')
			 ->join($this->t_regions, $this->t_cities.'.RegionID = '.$this->t_regions.'.RegionID', 'left')
			 ->join($this->t_countries, $this->t_cities.'.CountryID = '.$this->t_countries.'.CountryID', 'left');                
                $this->db->like('City', $pattern, 'after');
                $this->db->limit($limit);
                //ordena por nombre de region
                $this->db->order_by("City", "ASC"); 
		$q = $this->db->get($this->t_cities);
                if ($q->num_rows() > 0)
                {
                    return $q->result();
                }else
                    {
                        return FALSE;
                    }            
        }        

        /**
         * Get City data by cityID
         * @param type $id
         * @return boolean 
         */
        function get_by($id)
        {
            if(is_numeric($id))
            {        
		$this->db->select($this->t_cities.'.*, '.$this->t_regions.'.Region AS region, '.$this->t_countries.'.Country AS country')
			 ->join($this->t_regions, $this->t_cities.'.RegionID = '.$this->t_regions.'.RegionID', 'left')
			 ->join($this->t_countries, $this->t_cities.'.CountryID = '.$this->t_countries.'.CountryID', 'left');                 
                $q = $this->db->get_where($this->t_cities,array('CityId'=>$id));
                if($q->num_rows()>0)
                {
                    return $data = $q->row();
                }
            }else
                {
                    return FALSE;
                }
        }
        
        function update($id,$data)
        {
            $this->db->where('CityId', $id);
            return $this->db->update($this->t_cities, $data); 
        }
        
}       
        