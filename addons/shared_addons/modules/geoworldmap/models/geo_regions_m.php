<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Categories model
 *
 * @package		PyroCMS
 * @subpackage	Categories Module
 * @category	Modules
 * @author		Phil Sturgeon - PyroCMS Dev Team
 */
class Geo_regions_m extends MY_Model
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

	protected $_table = 'geo_regions';    
        
        /**
         * Get all regions by countryID
         * @param integer $countryid
         * @return boolean 
         */
        function get_many_by($countryid)
        {
		$this->db->select('*');                
                $this->db->where('geo_regions.CountryID', $countryid);
                //ordena por nombre de region
                $this->db->order_by("Region", "ASC"); 
		$q = $this->db->get($this->t_regions);
                if ($q->num_rows() > 0)
                {
                    return $q->result();
                }else
                    {
                        return FALSE;
                    }            
        }

                /**
         * Get regions by regionID
         * @param integer $regionid
         * @return boolean 
         */
        function get_by($regionid)
        { 
                $this->db->where('geo_regions.RegionID', $regionid);
		$q = $this->db->get($this->t_regions);
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
            $this->db->where('RegionID', $id);
            return $this->db->update($this->t_regions, $data); 
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