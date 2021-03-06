<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package  	PyroCMS
 * @subpackage  Categories
 * @category  	Module
 * @author  	PyroCMS Dev Team
 */
class Admin_Categories extends Admin_Controller {

	/**
	 * The current active section
	 * @access protected
	 * @var int
	 */
	protected $section = 'categories';
	
	/**
	 * Array that contains the validation rules
	 * @access protected
	 * @var array
	 */
	protected $validation_rules = array(
		array(
			'field' => 'type_id',
			'label' => 'lang:cat_type_label',
			'rules' => 'trim|required'
		),            
		array(
			'field' => 'title',
			'label' => 'lang:cat_title_label',
			'rules' => 'trim|required|callback__check_title'
		),
		array(
			'field' => 'description',
			'label' => 'lang:cat_description_label',
			'rules' => 'trim|required'
		),            
	);
	
	/**
	 * The constructor
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('products_categories_m');
                $this->load->helper(array('strings'));
		$this->lang->load(array('products','categories','locations','features','spaces'));
		
		// Load the validation library along with the rules
		$this->load->library(array('form_validation','product_type'));
		$this->form_validation->set_rules($this->validation_rules);
                $this->template->append_css('module::products.css');                 
	}
        
        public function _gen_dropdown_list()
        {
            $this->data->type_array = $this->product_type->gen_dd_array();
        }
	
	/**
	 * Index method, lists all categories
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->pyrocache->delete_all('modules_m');
		$this->_gen_dropdown_list();
		// Create pagination links
		$total_rows = $this->products_categories_m->count_all();
		$pagination = create_pagination('admin/products/categories/index', $total_rows, NULL, 5);
			
		// Using this data, get the relevant results
		$result = $this->products_categories_m->order_by('title')->limit($pagination['limit'])->get_all();
                $categories = translate_current_language($result);

		$this->template
			->title($this->module_details['name'], lang('cat_list_title'))
			->set('categories', $categories)
			->set('pagination', $pagination)
			->build('admin/categories/index', $this->data);
	}
	
	/**
	 * Create method, creates a new category
	 * @access public
	 * @return void
	 */
	public function create()
	{
		// Validate the data
		if ($this->form_validation->run())
		{
			$this->products_categories_m->insert($_POST)
				? $this->session->set_flashdata('success', sprintf( lang('cat_add_success'), $this->input->post('title')) )
				: $this->session->set_flashdata('error', lang('cat_add_error'));

			redirect('admin/products/categories');
		}
		
		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$category->{$rule['field']} = set_value($rule['field']);
		}
		$this->_gen_dropdown_list();
		$this->template
			->title($this->module_details['name'], lang('cat_create_title'))
			->set('category', $category)
			->build('admin/categories/form',$this->data);	
	}
	
	/**
	 * Edit method, edits an existing category
	 * @access public
	 * @param int id The ID of the category to edit
	 * @return void
	 */
	public function edit($id = 0)
	{	
		// Get the category
		$category = $this->products_categories_m->get($id);
		
		// ID specified?
		$category or redirect('admin/products/categories/index');
		
		// Validate the results
		if ($this->form_validation->run())
		{		
			$this->products_categories_m->update($id, $_POST)
				? $this->session->set_flashdata('success', sprintf( lang('cat_edit_success'), $this->input->post('title')) )
				: $this->session->set_flashdata('error', lang('cat_edit_error'));
			
			redirect('admin/products/categories/index');
		}
		
		// Loop through each rule
		foreach ($this->validation_rules as $rule)
		{
			if ($this->input->post($rule['field']) !== FALSE)
			{
				$category->{$rule['field']} = $this->input->post($rule['field']);
			}
		}
                $this->_gen_dropdown_list();
		$this->template
			->title($this->module_details['name'], sprintf(lang('cat_edit_title'), $category->title))
			->set('category', $category)
			->build('admin/categories/form',$this->data);
	}	

	/**
	 * Delete method, deletes an existing category (obvious isn't it?)
	 * @access public
	 * @param int id The ID of the category to edit
	 * @return void
	 */
	public function delete($id = 0)
	{	
		$id_array = (!empty($id)) ? array($id) : $this->input->post('action_to');
		
		// Delete multiple
		if (!empty($id_array))
		{
			$deleted = 0;
			$to_delete = 0;
			foreach ($id_array as $id)
			{
				if ($this->products_categories_m->delete($id))
				{
					$deleted++;
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('cat_mass_delete_error'), $id));
				}
				$to_delete++;
			}
			
			if ( $deleted > 0 )
			{
				$this->session->set_flashdata('success', sprintf(lang('cat_mass_delete_success'), $deleted, $to_delete));
			}
		}		
		else
		{
			$this->session->set_flashdata('error', lang('cat_no_select_error'));
		}
		
		redirect('admin/products/categories/index');
	}
		
	/**
	 * Callback method that checks the title of the category
	 * @access public
	 * @param string title The title to check
	 * @return bool
	 */
	public function _check_title($title = '')
	{
		if ($this->products_categories_m->check_title($title))
		{
			$this->form_validation->set_message('_check_title', sprintf(lang('cat_already_exist_error'), $title));
			return FALSE;
		}

		return TRUE;
	}
	
	/**
	 * Create method, creates a new category via ajax
	 * @access public
	 * @return void
	 */
	public function create_ajax()
	{
		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$category->{$rule['field']} = set_value($rule['field']);
		}
		
		$this->data->method = 'create';
		$this->data->category =& $category;
		
		if ($this->form_validation->run())
		{
			$id = $this->products_categories_m->insert_ajax($_POST);
			
			if ($id > 0)
			{
				$message = sprintf( lang('cat_add_success'), $this->input->post('title'));
			}
			else
			{
				$message = lang('cat_add_error');
			}

			return $this->template->build_json(array(
				'message'		=> $message,
				'title'			=> $this->input->post('title'),
				'category_id'	=> $id,
				'status'		=> 'ok'
			));
		}	
		else
		{
			// Render the view
			$form = $this->load->view('admin/categories/form', $this->data, TRUE);

			if ($errors = validation_errors())
			{
				return $this->template->build_json(array(
					'message'	=> $errors,
					'status'	=> 'error',
					'form'		=> $form
				));
			}

			echo $form;
		}
	}
}