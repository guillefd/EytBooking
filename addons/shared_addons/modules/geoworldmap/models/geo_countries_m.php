<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Categories model
 *
 * @package		PyroCMS
 * @subpackage	Categories Module
 * @category	Modules
 * @author		Phil Sturgeon - PyroCMS Dev Team
 */
class Geo_countries_m extends MY_Model
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
                $this->t_timezone = 'geo_timezone';                             
	}           

	protected $_table = 'geo_countries';  

        
        /**
         * cuenta total items paises
         */
        function count_all()
        {            
            $q = $this->db->get($this->t_countries);
            return $q->num_rows;
        }
        
        /**
         * get count all countries filtered
         * @return type 
         */        
	function count_by($params = array())
	{          
                //country filter    
		if (!empty($params['continent']))
		{
                    $this->db->where('geo_countries.MapReference', $params['continent']);
		}
		return $this->db->count_all_results();
	}

        /**
         * get all countries filtered
         * @param type $params
         * @return type 
         */
	function get_many_by($params = array())
	{
            
		$this->db->select('*');                                       
                if (!empty($params['continent']))
		{
			$this->db->where('geo_countries.MapReference', $params['continent']);
		}
		// Limit the results based on 1 number or 2 (2nd is offset)
		if (isset($params['limit']) && is_array($params['limit']))
			$this->db->limit($params['limit'][0], $params['limit'][1]);
		elseif (isset($params['limit']))
			$this->db->limit($params['limit']);
                //ordena por nombre de ciudad
                
                $this->db->order_by("Country", "ASC");                 
		return $this->db->get($this->t_countries)->result();               
	}
        
	/**
	 * Searches countries based on supplied data array
	 * @param $data array
	 * @return array
	 */
	function search($mode,$data = array())
	{
                $this->db->select('*');                  
		if (array_key_exists('continent', $data))
		{
			$this->db->where('geo_countries.MapReference', $data['continent']);
		}
		if (array_key_exists('keywords', $data))
		{
                    $this->db->like('geo_countries.Country', $data['keywords']);
		}

		// Limit the results based on 1 number or 2 (2nd is offset)
		if (isset($params['limit']) && is_array($params['limit']))
			$this->db->limit($params['limit'][0], $params['limit'][1]);
		elseif (isset($params['limit']))
			$this->db->limit($params['limit']);
                
                $this->db->order_by("Country", "ASC"); 
		$q = $this->db->get($this->t_countries);
                
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
         * get all countries
         * @return type 
         */
	function get_all()
	{
		$this->db->order_by('Country', 'ASC');
		return $this->db->get($this->t_countries)->result();
	}
        
        /**
         * get all countries
         * @return type 
         */
	function get_all_continents()
	{
                $this->db->distinct();            
                $this->db->select('MapReference');
                $this->db->order_by('MapReference', 'ASC');                
		return $this->db->get($this->t_countries)->result();
	}        

                /**
         * Get country by countryID
         * @param integer $countryid
         * @return boolean 
         */
        function get_by($countryid)
        {
                $this->db->where('geo_countries.CountryId', $countryid);
		$q = $this->db->get($this->t_countries);
                if ($q->num_rows() > 0)
                {
                    return $q->row();
                }else
                    {
                        return FALSE;
                    }            
        }
        
        /**
         *Update country
         * @param type $id
         * @param type $data
         * @return type 
         */
        function update($id,$data)
        {
            $this->db->where('CountryId', $id);
            return $this->db->update($this->t_countries, $data); 
        }        
        

        /**
         * get all countries
         * @return type 
         */
	function timezones_get_all()
	{		
                $this->db->select('*');
                $this->db->order_by('timeZoneId', 'ASC');
		return $this->db->get($this->t_timezone)->result();
	}
        
        /**
         * check timezone 
         */
       function check_timezone($tz)
       {
           $this->db->where('timeZoneId',$tz);
           return $this->db->get($this->t_timezone)->row();
       }
       
       /**
        * get timeZoneId by GMT
        * @param type $tz
        * @return type 
        */
       function check_gmt($gmt)
       {
           $this->db->where('GMT_offset',$gmt);
           return $this->db->get($this->t_timezone)->row();
       }
       
	/**
	 * Insert a new country into the database via ajax
	 * @access public
	 * @param array $input The data to insert
	 * @return int
	 */
	public function insert_ajax($input)
	{
		$this->load->helper('text');
		return parent::insert($input);
	}
       
}