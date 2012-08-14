<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Categories model
 *
 * @package		PyroCMS
 * @subpackage	Categories Module
 * @category	Modules
 * @author		Phil Sturgeon - PyroCMS Dev Team
 */
class Products_locations_m extends MY_Model
{

	public function __construct()
	{		
		parent::__construct();
		
		$this->_table = 'products_locations';
	}
    
        /**
         * Update
         * @param type $id
         * @param type $data
         * @return type 
         */
        function update($id,$data)
        {
            $this->db->where('id', $id);
            return $this->db->update($this->_table, $data); 
        }

	/**
	 * Callback method for validating the title
	 * @access public
	 * @param string $title The title to validate
	 * @return mixed
	 */
	public function check_name($name = '')
	{
            $q = $this->db->get_where($this->_table, array('name'=>$name));  		
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
	 * Callback method for validating the title
	 * @access public
	 * @param string $title The title to validate
	 * @return mixed
	 */
	public function check_name_edited($name = '',$id = 0)
	{
            $q = $this->db->get_where($this->_table, array('name'=>$name,'id !='=>$id));  		
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
	 * Callback method for validating the slug
	 * @access public
	 * @param string $title The title to validate
	 * @return mixed
	 */
	public function check_slug($slug = '')
	{
            $q = $this->db->get_where($this->_table, array('slug'=>$slug));  		
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
	 * Callback method for validating the slug
	 * @access public
	 * @param string $title The title to validate
	 * @return mixed
	 */
	public function check_slug_edited($slug = '',$id = 0)
	{
            $q = $this->db->get_where($this->_table, array('slug'=>$slug,'id !='=>$id));  		
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
	 * Insert a new category into the database via ajax
	 * @access public
	 * @param array $input The data to insert
	 * @return int
	 */
	public function insert_ajax($input = array())
	{
		$this->load->helper('text');
		return parent::insert(array(
			'title'=>$input['title'],
			'description'=>$input['description'],                      
			//is something wrong with convert_accented_characters?
			//'slug'=>url_title(strtolower(convert_accented_characters($input['title'])))
			'slug' => url_title(strtolower($input['title']))
		));
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
         * INACTIVE - Poner una cuenta inactiva
         * @param type $id
         * @param type $data
         * @return type 
         */
        function inactive($id)
        {            
            $data = array(
               'active' => 0
            );
            $this->db->where('id', $id);
            return $this->db->update($this->_table, $data); 
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