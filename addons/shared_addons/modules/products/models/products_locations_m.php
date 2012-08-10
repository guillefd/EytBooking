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
}