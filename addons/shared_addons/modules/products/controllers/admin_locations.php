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
                        'field' => 'account_id',
                        'label' => 'lang:location:account_label',
                        'rules' => 'trim|required|callback__check_validAccountId',
                ),
		array(
                        'field' => 'account',
                        'label' => 'lang:location:account_label',
                        'rules' => 'trim',
                ),            
                array(
			'field' => 'name',
			'label' => 'lang:location:name_label',
			'rules' => 'trim|required|max_length[40]|callback__check_name'
		),
		array(
			'field' => 'slug',
			'label' => 'lang:location:slug_label',
			'rules' => 'trim|required|max_length[40]||callback__check_slug'
		),            
		array(
			'field' => 'intro',
			'label' => 'lang:location:intro_label',
			'rules' => 'trim|required'
		),            
		array(
			'field' => 'description',
			'label' => 'lang:location:description_label',
			'rules' => 'trim'
		),            
		array(
			'field' => 'address_l1',
			'label' => 'lang:location:address_label',
			'rules' => 'trim'
		),  
		array(
			'field' => 'address_l2',
			'label' => 'lang:location:address_label',
			'rules' => 'trim'
		),            
		array(
			'field' => 'City',
			'label' => 'lang:location:city_label',
			'rules' => 'trim'
		),                    
		array(
			'field' => 'CityID',
			'label' => 'lang:location:city_label',
			'rules' => 'trim|required|numeric'
		), 
		array(
			'field' => 'area',
			'label' => 'lang:location:area_label',
			'rules' => 'trim'
		),    
		array(
			'field' => 'zipcode',
			'label' => 'lang:location:zipcode_label',
			'rules' => 'trim'
		),             
		array(
			'field' => 'Latitude',
			'label' => 'lang:location:latitude_label',
			'rules' => 'trim'
                    ),
		array(
			'field' => 'Longitude',
			'label' => 'lang:location:longitude_label',
			'rules' => 'trim'
                    ),
		array(
			'field' => 'latlng_precision',
			'label' => 'lang:location:latlng_precision_label',
			'rules' => 'trim'
                    ),            
		array(
			'field' => 'phone_area_code',
			'label' => 'lang:location:phonearea_label',
			'rules' => 'trim'
		),              
		array(
			'field' => 'phone',
			'label' => 'lang:location:phone_label',
			'rules' => 'trim'
		),  
		array(
			'field' => 'fax',
			'label' => 'lang:location:fax_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'mobile',
			'label' => 'lang:location:mobile_label',
			'rules' => 'trim'
		),            
		array(
			'field' => 'email',
			'label' => 'lang:location:email_label',
			'rules' => 'trim'
		),             
		array(
			'field' => 'chatSocial_accounts',
			'label' => 'lang:location:chatSocial_label',
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
                $this->load->helper(array('date'));
		$this->lang->load(array('products','categories','locations','features'));		
		// Loads libraries
		$this->load->library(array('form_validation','accounts','social','geoworldmap'));
                //Gen dropdown list for social
                $this->data->social = $this->social->get_list();                
                // template addons
                $this->template->append_css('module::locations.css') 
                               ->prepend_metadata('<script>var IMG_PATH = "'.BASE_URL.SHARED_ADDONPATH.'modules/'.$this->module.'/img/"; </script>');                
                
                
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
			->title($this->module_details['name'], lang('location:list_title'))
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
            // Set the validation rules from the array above
            $this->form_validation->set_rules($this->validation_rules);           
            // Validate the data
            if ($this->form_validation->run())
            {
                $this->load->helper('text');
                $data = array('account_id'=>$this->input->post('account_id'),
                              'name' =>$this->input->post('name'),
                              'slug'=>$this->input->post('slug'), 
                              'intro' => $this->input->post('intro'),
                              'description' => $this->input->post('description'),                    
                              'address_l1' => $this->input->post('address_l1'),
                              'address_l2' => $this->input->post('address_l2'), 
                              'area' => $this->input->post('area'), 
                              'CityID'=>$this->input->post('CityID'),
                              'zipcode' => $this->input->post('zipcode'), 
                              'Latitude' => $this->input->post('Latitude'), 
                              'Longitude' => $this->input->post('Longitude'), 
                              'latlng_precision' => $this->input->post('latlng_precision'), 
                              'phone_area_code' => $this->input->post('phone_area_code'), 
                              'phone' => $this->input->post('phone'), 
                              'fax' => $this->input->post('fax'), 
                              'mobile' => $this->input->post('mobile'),                     
                              'email' => $this->input->post('email'),                    
                              'chatSocial_accounts'=>$this->_cleanString_socialAccounts($this->input->post('chatSocial_accounts')),  
                              'type' => $this->input->post('type'),
                              'author_id' => $this->current_user->id,
                              'created_on' => now() 
                              );
                if($this->products_locations_m->insert($data))
		{
                    // All good...
                    $this->session->set_flashdata('success', lang('location:add_success'));
                    redirect('admin/products/locations');
		}
		// Something went wrong. Show them an error
		else
                    {
			$this->session->set_flashdata('error', lang('location:add_error'));
                    	redirect('admin/products/locations/create');
                    }
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
	            ->append_js('module::ws_autocomplete.js')                      
	            ->append_js('module::locations_form.js')
                    ->append_js('module::model.js')
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
            if($id==0)
            {
                $this->session->set_flashdata('error', lang('location:error_id_empty'));
		redirect('admin/products/locations/index');
            }
            else
            {                    
                //consulta SQL
                $location = $this->products_locations_m->get($id); 
                if($location == FALSE)
                {
                    $this->session->set_flashdata('error', lang('location:error_id_empty'));
                    redirect('admin/products/locations/index');
                }                
            }

            //CONVERT ID TO TEXT
            //Use Geoworldmap library  to query city name
            $city = $this->geoworldmap->getCityByID($location->CityID);
            $location->City = $city->City;
            $account = $this->accounts->get_account($location->account_id);
            $location->account = $account->name;

            // Set the validation rules from the array above
            $this->form_validation->set_rules($this->validation_rules);            
            
            // Validate the results
            if ($this->form_validation->run())
            {		
                $this->load->helper('text');
                $data = array('account_id'=>$this->input->post('account_id'),
                              'name' =>$this->input->post('name'),
                              'slug'=>$this->input->post('slug'), 
                              'intro' => $this->input->post('intro'),
                              'description' => $this->input->post('description'),                    
                              'address_l1' => $this->input->post('address_l1'),
                              'address_l2' => $this->input->post('address_l2'), 
                              'area' => $this->input->post('area'), 
                              'CityID'=>$this->input->post('CityID'),
                              'zipcode' => $this->input->post('zipcode'), 
                              'Latitude' => $this->input->post('Latitude'), 
                              'Longitude' => $this->input->post('Longitude'), 
                              'latlng_precision' => $this->input->post('latlng_precision'), 
                              'phone_area_code' => $this->input->post('phone_area_code'), 
                              'phone' => $this->input->post('phone'), 
                              'fax' => $this->input->post('fax'), 
                              'mobile' => $this->input->post('mobile'),                     
                              'email' => $this->input->post('email'),                    
                              'chatSocial_accounts'=>$this->_cleanString_socialAccounts($this->input->post('chatSocial_accounts')), 
                              'type' => $this->input->post('type'),
                              //'author_id' => $this->current_user->id,
                              'updated_on' => now() 
                              );                    
                if($this->products_locations_m->update($id, $data))
                {        
                    // All good...
                    $this->session->set_flashdata('success', lang('location:edit_success'));
                    redirect('admin/products/locations/index');
                }
                else
                    {
                            $this->session->set_flashdata('error', lang('location:edit_error'));
                            redirect('admin/products/location/edit/'.$id);
                    }
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
                    ->title($this->module_details['name'], sprintf(lang('cat_edit_title'), $location->name))
                    ->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE)) 
                    ->append_js('module::jquery/jquery.tagsinput.min.js')                                    
	            ->append_js('module::ws_autocomplete.js')                      
	            ->append_js('module::locations_form.js')
                    ->append_js('module::model.js')
                    ->append_css('module::jquery/jquery.autocomplete.css') 
                    ->append_css('module::jquery/jquery.tagsinput.css')                                         
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

//::::: HELPERS ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::        
        
	/**
	 * Callback method that checks the title of the location
	 * @access public
	 * @param string title The title to check
	 * @return bool
	 */
	public function _check_name($name = '')
	{
            if ($reg = $this->products_locations_m->check_name($name))
            {
                   if($this->method == "edit")
                   {        
                       //Check name does not exist in DB and ID not equal to ID of current edited record
                       if($this->products_locations_m->check_name_edited($name,$this->uri->segment(5)))
                       {    
                            $this->form_validation->set_message('_check_name', sprintf(lang('location:already_exist_error'), $name));
                            return FALSE;                           
                       }
                       else
                           {
                                return TRUE;
                           }
                   }
                   else
                        {
                            $this->form_validation->set_message('_check_name', sprintf(lang('location:already_exist_error'), $name));
                            return FALSE;
                        }
            }
            return TRUE;
	}
        
	/**
	 * Callback method that checks the slug of the location
	 * @access public
	 * @param string title The title to check
	 * @return bool
	 */
	public function _check_slug($slug = '')
	{
            if ($reg = $this->products_locations_m->check_slug($slug))
            {
                if($this->method == "edit")
                {        
                       //Check name does not exist in DB and ID not equal to ID of current edited record
                       if($this->products_locations_m->check_slug_edited($slug,$this->uri->segment(5)))
                       {    
                            $this->form_validation->set_message('_check_slug', sprintf(lang('location:slug_already_exist_error'), $slug));
                            return FALSE;                           
                       }
                       else
                           {
                                return TRUE;
                           }
                }
                else
                    {			
                        $this->form_validation->set_message('_check_slug', sprintf(lang('location:slug_already_exist_error'), $slug));
                        return FALSE;
                    }    
            }
            return TRUE;
	}        
        
	/**
	 * Callback method that checks the account id
	 * @access public
	 * @param string reg The id to check
	 * @return bool
	 */        
        public function _check_validAccountId($id)
        {
            if(!$this->accounts->get_account($id))
            {
                $this->form_validation->set_message('_check_validAccountId', sprintf(lang('location:account_id_not_valid')));
                return FALSE;
            }else
                {
                    return TRUE;
                }
        }
        
        /**
        * Quita valores residuales del string de dias/horarios de pago a proveedores 
        * @param type string $string 
        * return type string
        */
        function _cleanString_socialAccounts($string)
        {
            return str_replace('EMPTY;','',$string);    
        }        

//:::::::::: AJAX :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        
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
				$message = sprintf( lang('location:add_success'), $this->input->post('title'));
			}
			else
			{
				$message = lang('location:add_error');
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