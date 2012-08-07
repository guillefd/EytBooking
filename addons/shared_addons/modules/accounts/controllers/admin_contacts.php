<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a Accounts module for PyroCMS
 *
 * @author 		Willy RW-DEV
 * @website		
 * @package             PyroCMS
 * @subpackage          Accounts Module - Contacts
 */
class Admin_contacts extends Admin_Controller
{
    
	protected $section = 'contacts';
        
	/**
	 * Array that contains the validation rules
	 *
	 * @var array
	 */
	protected $validation_rules = array(
			array(
				'field' => 'name',
				'label' => 'lang:accounts:name',
				'rules' => 'trim|max_length[100]|required'
			),
			array(
				'field' => 'surname',
				'label' => 'lang:accounts:surname',
				'rules' => 'trim|max_length[100]'
			),            
			array(
				'field' => 'account_id',
				'label' => 'lang:accounts:account_id',
				'rules' => 'trim|required|callback__check_validAccountId'
			),
			array(
				'field' => 'account',
				'label' => 'lang:accounts:account',
				'rules' => 'trim'
			),            
			array(
				'field' => 'section',
				'label' => 'lang:accounts:section',
				'rules' => 'trim|max_length[100]'
			),
			array(
				'field' => 'title',
				'label' => 'lang:accounts:title',
				'rules' => 'trim|max_length[100]'
			),
			array(
				'field' => 'position',
				'label' => 'lang:accounts:position',
				'rules' => 'trim|max_length[100]'
			),                              
			array(
				'field' => 'address_l1',
				'label' => 'lang:accounts:address_l1',
				'rules' => 'trim|max_length[100]'
			),                    
			array(
				'field' => 'address_l2',
				'label' => 'lang:accounts:address_l2',
				'rules' => 'trim|max_length[100]'
			),                    
			array(
				'field' => 'area',
				'label' => 'lang:accounts:accounts:area',
				'rules' => 'trim'
			),                    
			array(
				'field' => 'City',
				'label' => 'lang:accounts:city',
				'rules' => 'trim|required'
			),                      
			array(
				'field' => 'CityID',
				'label' => 'lang:accounts:cityid',
				'rules' => 'trim'
			),                    
			array(
				'field' => 'zipcode',
				'label' => 'lang:accounts:zipcode',
				'rules' => 'trim'
			),                    
			array(
				'field' => 'Latitude',
				'label' => 'lang:accounts:latitude',
				'rules' => 'trim'
			),                    
			array(
				'field' => 'Longitude',
				'label' => 'lang:accounts:longitude',
				'rules' => 'trim'
			),                    
			array(
				'field' => 'latlng_precision',
				'label' => 'lang:accounts:latlng_precision',
				'rules' => 'trim'
			),                    
			array(
				'field' => 'phone_area_code',
				'label' => 'lang:accounts:phonecode',
				'rules' => 'trim'
			),                    
			array(
				'field' => 'phone',
				'label' => 'lang:accounts:phone',
				'rules' => 'trim'
			),                                        
			array(
				'field' => 'fax',
				'label' => 'lang:accounts:fax',
				'rules' => 'trim'
			),                    
			array(
				'field' => 'email',
				'label' => 'lang:accounts:email',
				'rules' => 'trim'
			)
        );
        
	public function __construct()
	{
		parent::__construct();
		// Load all the required classes
		$this->load->model(array('contacts_m','accounts_m'));
                $this->load->helper(array('date'));
		$this->load->library(array('form_validation','geoworldmap'));
		$this->lang->load('accounts');
                // IMG path
                $this->template->prepend_metadata('<script>var IMG_PATH = "'.BASE_URL.SHARED_ADDONPATH.'modules/'.$this->module.'/img/"; </script>');
	}        

	/**
	 * List all items
	 */
	public function index()
	{
		// Create pagination links
		$total_rows = $this->contacts_m->search('counts');
                $pagination = create_pagination('admin/accounts/contacts/index', $total_rows, 10, 5);
                $post_data['pagination'] = $pagination;
                $post_data['active'] = 1; //only active accounts           
		// Using this data, get the relevant results
		$contacts = $this->contacts_m->search('results',$post_data);
                $contacts = $this->_convertIDtoText($contacts);        
		//do we need to unset the layout because the request is ajax?
		$this->input->is_ajax_request() ? $this->template->set_layout(FALSE) : '';                
		// Build the view with accounts/views/admin/items.php
		$this->data->contacts =& $contacts;             
		$this->template->title($this->module_details['name'])
                               ->set('pagination', $pagination)
                               ->append_js('module::contacts_index.js')                        
                               ->append_js('module::model.js')
                               ->append_css('module::jquery/jquery.autocomplete.css')                         
                               ->append_css('module::accounts.css');                         
                
		$this->input->is_ajax_request() ? $this->template->build('admin/contacts/partials/contacts', $this->data) : $this->template->build('admin/contacts/index', $this->data);           
        }        

                
	public function create()
	{
		// Set the validation rules from the array above
		$this->form_validation->set_rules($this->validation_rules);                                
                
		// check if the form validation passed
		if($this->form_validation->run())
		{
                        // See if the model can create the record
			if($this->contacts_m->insert(
                              array('name' => $this->input->post('name'),
                                    'surname'=> $this->input->post('surname'),
                                    'account_id' => $this->input->post('account_id'),
                                    'section'=>$this->input->post('section'),
                                    'title'=>$this->input->post('title'),
                                    'position'=>$this->input->post('position'),
                                    'address_l1' => $this->input->post('address_l1'),
                                    'address_l2' => $this->input->post('address_l2'),
                                    'area' => $this->input->post('area'),
                                    'CityID' => $this->input->post('CityID'),
                                    'zipcode' => $this->input->post('zipcode'),
                                    'Latitude' => $this->input->post('Latitude'),
                                    'Longitude' => $this->input->post('Longitude'),
                                    'latlng_precision' => $this->input->post('latlng_precision'),
                                    'phone_area_code' => $this->input->post('phone_area_code'),
                                    'phone' => $this->input->post('phone'),
                                    'fax' => $this->input->post('fax'),
                                    'email' => $this->input->post('email'),                                    
                                    'author_id' => $this->current_user->id,
                                    'created_on' => now() 
                                    )))
			{
				// All good...
				$this->session->set_flashdata('success', lang('accounts:success_contact'));
				redirect('admin/accounts/contacts');
			}
			// Something went wrong. Show them an error
			else
			{
				$this->session->set_flashdata('error', lang('accounts:error_contact'));
				redirect('admin/accounts/contacts/create');
			}
		}
		
		foreach ($this->validation_rules AS $rule)
		{
			$this->data->{$rule['field']} = $this->input->post($rule['field']);
		}

		// Build the view using accounts/views/admin/contacts/form.php
		$this->template->title(lang('accounts:contact'), lang('accounts:new_item'))
	        ->append_js('module::contacts_create.js')                        
	        ->append_js('module::ws_autocomplete.js')                         
                ->append_css('module::accounts.css')                            
                ->append_css('module::jquery/jquery.autocomplete.css')                        
                ->build('admin/contacts/form', $this->data);
	}

        
	public function edit($id = 0)
	{
            if($id==0)
            {
                $this->session->set_flashdata('error', lang('accounts:error_id_empty'));
		redirect('admin/accounts/contacts');
            }
            else
            {    
                //consulta SQL
                $this->data = $this->contacts_m->get($id); 
                if($this->data == FALSE)
                {
                    $this->session->set_flashdata('error', lang('accounts:error_id_empty'));
                    redirect('admin/accounts/contacts');
                }                
            }   
            // convierte IDs a Texto
            $this->data = $this->_convertIDtoText($this->data);
            //Use Geoworldmap library 
            $city = $this->geoworldmap->getCityByID($this->data->CityID);
            $this->data->City = $city->City;

            // Set the validation rules from the array above
            $this->form_validation->set_rules($this->validation_rules);

            // check if the form validation passed
            if($this->form_validation->run())
            {
                    // get rid of the btnAction item that tells us which button was clicked.
                    // If we don't unset it MY_Model will try to insert it
                    unset($_POST['btnAction']);

                    // See if the model can update the record
                    $data = array(
                                'name' => $this->input->post('name'),
                                'surname'=> $this->input->post('surname'),
                                'account_id' => $this->input->post('account_id'),
                                'section'=>$this->input->post('section'),
                                'title'=>$this->input->post('title'),
                                'position'=>$this->input->post('position'),
                                'address_l1' => $this->input->post('address_l1'),
                                'address_l2' => $this->input->post('address_l2'),
                                'area' => $this->input->post('area'),
                                'CityID' => $this->input->post('CityID'),
                                'zipcode' => $this->input->post('zipcode'),
                                'Latitude' => $this->input->post('Latitude'),
                                'Longitude' => $this->input->post('Longitude'),
                                'latlng_precision' => $this->input->post('latlng_precision'),
                                'phone_area_code' => $this->input->post('phone_area_code'),
                                'phone' => $this->input->post('phone'),
                                'fax' => $this->input->post('fax'),
                                'email' => $this->input->post('email'),
                                'updated_on' => now() );
                    
                    if($this->contacts_m->update($id, $data))                                
                    {
                            // All good...
                            $this->session->set_flashdata('success', lang('accounts:edit_success'));
                            redirect('admin/accounts/contacts');
                    }
                    // Something went wrong. Show them an error
                    else
                    {
                            $this->session->set_flashdata('error', lang('accounts:error'));
                            redirect('admin/accounts/contacts/edit/'.$id);
                    }
            }
            $this->template->title(lang('accounts:contact'), lang('accounts:new_item'))
            ->append_js('module::contacts_create.js')                        
            ->append_js('module::ws_autocomplete.js')                         
            ->append_css('module::accounts.css')                            
            ->append_css('module::jquery/jquery.autocomplete.css')                        
            ->build('admin/contacts/form', $this->data);
	}
        
        
	/**
         * Delete - no se borra, se deja inactivo
         * @param type $id 
         */
        public function delete($id = 0)
	{
		// make sure the button was clicked and that there is an array of ids
		if (isset($_POST['btnAction']) AND is_array($_POST['action_to']))
		{
                        // pass the ids and let MY_Model delete the items
			$this->contacts_m->inactive_many($this->input->post('action_to'));
		}
		elseif (is_numeric($id))
		{
			// they just clicked the link so we'll delete that one
			$this->contacts_m->inactive($id);
		}
		redirect('admin/accounts/contacts');
	}

        
	/**
	 * Preview contact
	 * @access public
	 * @param int $id the ID of the contact to preview
	 * @return void
	 */
	public function preview($id = 0)
	{
                $contact = $this->contacts_m->get($id);
                $contact = $this->_convertIDtoText($contact);
                // set template
		$this->template
				->set_layout('modal', 'admin')
                                ->append_css('module::workless.css')
                                ->append_css('module::accounts.css')
				->set('contact', $contact)
				->build('admin/contacts/partials/contact');                         
	}                
        
        
        /**
         * ACTION  
         */
        public function action()
        {
            //TO-DO         
        }

// HELPERS ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::        
        
        /**
         * Convierte ID´s de resultado SQL a texto - acepta objeto o arrays de objetos
         * @param result array resultado SQL
         * @return result object 
         */
        public function _convertIDtoText($results)
        {  
            if(is_array($results))
            {                
                foreach($results as $reg)
                {
                    $this->_convertIDtoText_run($reg);
                }
            }else
                {
                    $this->_convertIDtoText_run($results);
                }
            return $results;              
        }
        
        public function _convertIDtoText_run($reg)
        {
            //nombre de la cuenta
            $account = $this->accounts_m->get($reg->account_id);
            $reg->account = $account ? $account->name : '';
            //Use Geoworldmap library - nombre de la ciudad
            $city = $this->geoworldmap->getCityByID($reg->CityID);
            $reg->City = $city ? $city->City : '';            
        }
        
        public function _check_validAccountId($reg)
        {
            if(!$this->accounts_m->get($reg))
            {
                $this->form_validation->set_message('_check_validAccountId', sprintf(lang('accounts:account_id_not_valid')));
                return FALSE;
            }else
                {
                    return TRUE;
                }
        }
        
        
// AJAX :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        
        /**
	 * method to fetch filtered results for account list
	 * @access public
	 * @return void
	 */
	public function ajax_filter()
	{
                //captura post
                $post_data = array();
                if($this->input->post('f_type'))
                {
                    $data->account_id = $this->input->post('f_type');
                    $post_data['account_id']=$data->account_id;                    
                }    
                if($this->input->post('f_keywords'))
                {    
                    $data->keywords = $this->input->post('f_keywords');
                    $post_data['keywords']=$data->keywords; 
                }    
                $post_data['active'] = 1;
                //pagination
                $total_rows = $this->contacts_m->search('counts',$post_data);
                //params (URL -for links-, Total records, records per page, segmnet number )
                $pagination = create_pagination('admin/accounts/contacts/ajax_filter', $total_rows, 10, 5);
                $post_data['pagination'] = $pagination;                
                //query with limits
                $results = $this->contacts_m->search('results',$post_data);                             
                $results = $this->_convertIDtoText($results);
		//set the layout to false and load the view
                $this->input->is_ajax_request() ? $this->template->set_layout(FALSE) : '';                 
		$this->template
			->set('pagination', $pagination)                       
			->set('contacts', $results)
                        ->append_css('module::accounts.css')                        
                        ->append_js('module::contacts_index.js')
                        ->append_js('module::model.js');
                $this->input->is_ajax_request() ? $this->template->build('admin/contacts/partials/contacts', $this->data) : $this->template->build('admin/contacts/index', $this->data);                
	}
        
        
}