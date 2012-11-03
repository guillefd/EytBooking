<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a Accounts module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Accounts Module
 */
class Accounts_m extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		
		$this->_table = 'accounts';
	}
	

	//make sure the slug is valid
	public function _check_slug($slug)
	{
		$slug = strtolower($slug);
		$slug = preg_replace('/\s+/', '-', $slug);

		return $slug;
	}
        
        /**
         * Returns unique account by ID
         * @param type $id
         * @return boolean 
         */
        public function get($id)
        {
            $q = $this->db->get_where($this->_table, array('account_id' => $id,'active'=>1));      
            if($q->num_rows()>0)
            {
                return $data = $q->row();
            }
            else
            {
                return FALSE;
            }        
        }                 
        
        
	/**
	 * Searches accounts posts based on supplied data array
	 * @param $data array
	 * @return array
	 */
	function search($mode,$data = array())
	{
	    $query = "SELECT * FROM (`default_".$this->_table."`)";
            // Solo cuentas activas
            if (array_key_exists('active', $data))
            {
                $query.= ' WHERE `active` = '.$data['active'];
                
            }
            if (array_key_exists('account_type', $data) && $data['account_type']!=0)
            {
                $query.= ' AND (`account_type` = 3 OR `account_type` = '.$data['account_type'].') ';
            }

            if (array_key_exists('keywords', $data))
            {
                $query.= " AND (`name` LIKE '%".$data['keywords']."%' OR `razon_social` LIKE '%".$data['keywords']."%' OR `cuit` LIKE '%".$data['keywords']."%')";
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
        
        /**
         * Update account
         * @param type $id
         * @param type $data
         * @return type 
         */
        function update($id,$data)
        {
            $this->db->where('account_id', $id);
            return $this->db->update($this->_table, $data); 
        }        
        
        /**
         * DELETE - Poner una cuenta inactiva
         * @param type $id
         * @param type $data
         * @return type 
         */
        function inactive($id)
        {            
            $data = array(
               'active' => 0
            );
            $this->db->where('account_id', $id);
            return $this->db->update($this->_table, $data); 
        }
        
       
}
