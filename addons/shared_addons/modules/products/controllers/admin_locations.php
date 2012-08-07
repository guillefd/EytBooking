<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package  	PyroCMS
 * @subpackage  locations
 * @category  	Module
 * @author  	PyroCMS Dev Team
 */
class Admin_Locations extends Admin_Controller {

	/**
	 * The current active section
	 * @access protected
	 * @var int
	 */
	protected $section = 'locations';
	
	/**
	 * Array that contains the validation rules
	 * @access protected
	 * @var array
	 */
	protected $validation_rules = array(
		array(
			'field' => 'name',
			'label' => 'lang:location_title_label',
			'rules' => 'trim|required|max_length[20]|callback__check_title'
		),
		array(
			'field' => 'intro',
			'label' => 'lang:location_intro_label',
			'rules' => 'trim|required'
		),            
		array(
			'field' => 'description',
			'label' => 'lang:location_description_label',
			'rules' => 'trim'
		),            
		array(
			'field' => 'address_l1',
			'label' => 'lang:location_address_label',
			'rules' => 'trim'
		),  
		array(
			'field' => 'address_l2',
			'label' => 'lang:location_address_label',
			'rules' => 'trim'
		),            
		array(
			'field' => 'City',
			'label' => 'lang:location_city_label',
			'rules' => 'trim'
		),                    
		array(
			'field' => 'CityID',
			'label' => 'lang:location_city_label',
			'rules' => 'trim|required|numeric'
		), 
		array(
			'field' => 'area',
			'label' => 'lang:location_area_label',
			'rules' => 'trim'
		),    
		array(
			'field' => 'zipcode',
			'label' => 'lang:location_zipcode_label',
			'rules' => 'trim'
		),             
		array(
			'field' => 'Latitude',
			'label' => 'lang:location_latitude_label',
			'rules' => 'trim'
                    ),
		array(
			'field' => 'Longitude',
			'label' => 'lang:location_longitude_label',
			'rules' => 'trim'
                    ),
		array(
			'field' => 'latlng_precision',
			'label' => 'lang:location_latlng_precision_label',
			'rules' => 'trim'
                    ),            
		array(
			'field' => 'phone_area_code',
			'label' => 'lang:location_phonearea_label',
			'rules' => 'trim'
		),              
		array(
			'field' => 'phone',
			'label' => 'lang:location_phone_label',
			'rules' => 'trim'
		),  
		array(
			'field' => 'fax',
			'label' => 'lang:location_fax_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'mobile',
			'label' => 'lang:location_mobile_label',
			'rules' => 'trim'
		),            
		array(
			'field' => 'chat_hotmail',
			'label' => 'lang:location_hotmail_label',
			'rules' => 'trim'
		),      
		array(
			'field' => 'chat_skype',
			'label' => 'lang:location_skype_label',
			'rules' => 'trim'
		),   
		array(
			'field' => 'chat_gmail',
			'label' => 'lang:location_gmail_label',
			'rules' => 'trim'
		),     
		array(
			'field' => 'social_twitter',
			'label' => 'lang:location_twitter_label',
			'rules' => 'trim'
		),               
		array(
			'field' => 'social_facebook',
			'label' => 'lang:location_facebook_label',
			'rules' => 'trim'
		),  
		array(
			'field' => 'social_google',
			'label' => 'lang:location_google_label',
			'rules' => 'trim'
		),              
		array(
			'field' => 'type',
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
		
		$this->load->model('products_locations_m');
		$this->lang->load(array('products','categories','locations','features'));
		
		// Load the validation library along with the rules
		$this->load->library('form_validation');
//		ci()->load->library('geoworldmap');                
		$this->form_validation->set_rules($this->validation_rules);
	}
	
	/**
	 * Index method, lists all locations
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->pyrocache->delete_all('modules_m');
		
		// Create pagination links
		$total_rows = $this->products_locations_m->count_all();
		$pagination = create_pagination('admin/products/locations/index', $total_rows, NULL, 5);
			
		// Using this data, get the relevant results
		$locations = $this->products_locations_m->order_by('name')->limit($pagination['limit'])->get_all();

		$this->template
			->title($this->module_details['name'], lang('location_list_title'))
			->set('locations', $locations)
			->set('pagination', $pagination)
			->build('admin/locations/index', $this->data);
	}
	
	/**
	 * Create method, creates a new location
	 * @access public
	 * @return void
	 */
	public function create()
	{
            // Validate the data
            if ($this->form_validation->run())
            {
                    $this->products_locations_m->insert($_POST)
                            ? $this->session->set_flashdata('success', sprintf( lang('location_add_success'), $this->input->post('title')) )
                            : $this->session->set_flashdata('error', lang('location_add_error'));

                    redirect('admin/products/locations');
                        
            }           

            // Loop through each validation rule
            foreach ($this->validation_rules as $rule)
            {
                    $location->{$rule['field']} = set_value($rule['field']);                  
            }

            // if it's a fresh new article lets show them the advanced editor
            if ($location->type == '') $location->type = 'wysiwyg-advanced';               

            $this->template
                    ->title($this->module_details['name'], lang('cat_create_title'))
                    ->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE)) 
                    ->append_js('module::jquery/jquery.tagsinput.min.js')                    
	            ->append_js('module::load_geo.js')                            
	            ->append_js('module::ws_autocomplete.js')                      
	            ->append_js('module::locations_form.js')                    
                    ->append_css('module::jquery/jquery.autocomplete.css') 
                    ->append_css('module::jquery/jquery.tagsinput.css')                                         
                    ->set('location', $location)
                    ->build('admin/locations/form');	
	}
	
	/**
	 * Edit method, edits an existing location
	 * @access public
	 * @param int id The ID of the location to edit
	 * @return void
	 */
	public function edit($id = 0)
	{	
		// Get the location
		$location = $this->products_locations_m->get($id);
		
		// ID specified?
		$location or redirect('admin/products/locations/index');
		
		// Validate the results
		if ($this->form_validation->run())
		{		
			$this->products_locations_m->update($id, $_POST)
				? $this->session->set_flashdata('success', sprintf( lang('cat_edit_success'), $this->input->post('title')) )
				: $this->session->set_flashdata('error', lang('cat_edit_error'));
			
			redirect('admin/products/locations/index');
		}
		
		// Loop through each rule
		foreach ($this->validation_rules as $rule)
		{
			if ($this->input->post($rule['field']) !== FALSE)
			{
				$location->{$rule['field']} = $this->input->post($rule['field']);
			}
		}

		$this->template
			->title($this->module_details['name'], sprintf(lang('cat_edit_title'), $location->title))
			->set('location', $location)
			->build('admin/locations/form');
	}	

	/**
	 * Delete method, deletes an existing location (obvious isn't it?)
	 * @access public
	 * @param int id The ID of the location to edit
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
				if ($this->products_locations_m->delete($id))
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
		
		redirect('admin/products/locations/index');
	}
		
	/**
	 * Callback method that checks the title of the location
	 * @access public
	 * @param string title The title to check
	 * @return bool
	 */
	public function _check_title($title = '')
	{
		if ($this->products_locations_m->check_title($title))
		{
			$this->form_validation->set_message('_check_title', sprintf(lang('location_already_exist_error'), $title));
			return FALSE;
		}

		return TRUE;
	}
	
	/**
	 * Create method, creates a new location via ajax
	 * @access public
	 * @return void
	 */
	public function create_ajax()
	{
		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$location->{$rule['field']} = set_value($rule['field']);
		}
		
		$this->data->method = 'create';
		$this->data->location =& $location;
		
		if ($this->form_validation->run())
		{
			$id = $this->products_locations_m->insert_ajax($_POST);
			
			if ($id > 0)
			{
				$message = sprintf( lang('location_add_success'), $this->input->post('title'));
			}
			else
			{
				$message = lang('location_add_error');
			}

			return $this->template->build_json(array(
				'message'		=> $message,
				'title'			=> $this->input->post('title'),
				'location_id'	=> $id,
				'status'		=> 'ok'
			));
		}	
		else
		{
			// Render the view
			$form = $this->load->view('admin/locations/form', $this->data, TRUE);

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