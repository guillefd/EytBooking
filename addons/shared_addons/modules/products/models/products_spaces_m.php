<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Rooms model
 *
 * @package		PyroCMS
 * @subpackage          Products Module
 * @category            Modules
 * @author		Guillermo Dova - Rewrite
 */
class Products_spaces_m extends MY_Model
{

	public function __construct()
	{		
		parent::__construct();
		
		$this->_table = 'products_spaces';
	}

        /**
         * Returns unique location 
         * @param type $id
         * @return boolean 
         */
        public function get_where($data)
        {
            $q = $this->db->get_where($this->_table, $data);      
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
         * INACTIVE - Poner espacio inactivo
         * @param type $id
         * @param type $data
         * @return type 
         */
        function inactive($id)
        {            
            $data = array(
               'active' => 0
            );
            $this->db->where('space_id', $id);
            return $this->db->update($this->_table, $data); 
        }
        
        /**
         * Update
         * @param type $id
         * @param type $data
         * @return type 
         */
        function update($id,$data)
        {
            $this->db->where('space_id', $id);
            return $this->db->update($this->_table, $data); 
        }
        
        
	/**
	 * Searches rooms based on supplied data array
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
            if (array_key_exists('location_id', $data) && $data['location_id']!=0)
            {
                $query.= ' AND `location_id` = '.$data['location_id'];
            }
            if (array_key_exists('CityID', $data) && $data['CityID']!=0)
            {
                $query.= ' AND `CityID` = '.$data['CityID'];
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
