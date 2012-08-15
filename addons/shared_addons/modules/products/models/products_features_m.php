<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Categories model
 *
 * @package		PyroCMS
 * @subpackage	Categories Module
 * @category	Modules
 * @author		Phil Sturgeon - PyroCMS Dev Team
 */
class Products_features_m extends MY_Model
{
    
	public function __construct()
	{		
		parent::__construct();
		
		$this->_table = 'products_features_defaults';
	}
        
        
    	/**
	 * Searches items based on supplied data array
	 * @param $mode var to select return type: counts or results
         * @param $data array
	 * @return array
	 */
	function search($mode,$data = array())
	{
	    $query = "SELECT * FROM (`default_".$this->_table."`)";
            if (array_key_exists('account_id', $data) && $data['account_id']!=0)
            {
                $query.= ' AND `account_id` = '.$data['account_id'];
            }
            if (array_key_exists('CityID', $data) && $data['CityID']!=0)
            {
                $query.= ' AND `CityID` = '.$data['CityID'];
            }            
            if (array_key_exists('keywords', $data))
            {
                $query.= " AND (`name` LIKE '%".$data['keywords']."%')";
            }
            //Ordenar alfabeticamente
            $query.= " ORDER BY `name` ASC";            
            // Limit the results based on 1 number or 2 (2nd is offset)
            if (isset($data['pagination']['limit']) && is_array($data['pagination']['limit']))
            {
                    $query.= " LIMIT ".$data['pagination']['limit'][1].", ".$data['pagination']['limit'][0];
            }        
            elseif (isset($data['pagination']['limit']))
            {    
                    $query.= " LIMIT ".$data['pagination']['limit'];
            }        
            //fire query
            $q = $this->db->query($query);         
            if($mode =='counts')
            {                
                return $q->num_rows;
            }
            else
                {
                    return $q->result();
                }
	} 

    
    
}