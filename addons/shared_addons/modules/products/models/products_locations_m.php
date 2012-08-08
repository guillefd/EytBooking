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

	/**
	 * Update an existing category
	 * @access public
	 * @param int $id The ID of the category
	 * @param array $input The data to update
	 * @return bool
	 */
	public function update($id, $input)
	{
		return parent::update($id, array(
			'title'	=> $input['title'],
			'description'=>$input['description'],                      
		        'slug'	=> url_title(strtolower(convert_accented_characters($input['title'])))
		));
	}

	/**
	 * Callback method for validating the title
	 * @access public
	 * @param string $title The title to validate
	 * @return mixed
	 */
	public function check_name($name = '')
	{
		return parent::count_by('name', $name) > 0;
	}
        
	/**
	 * Callback method for validating the slug
	 * @access public
	 * @param string $title The title to validate
	 * @return mixed
	 */
	public function check_slug($slug = '')
	{
		return parent::count_by('slug', $slug) > 0;
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
}