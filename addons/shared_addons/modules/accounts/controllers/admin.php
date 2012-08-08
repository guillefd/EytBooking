<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a Accounts module for PyroCMS
 *
 * @author 		Willy RW-DEV
 * @website		
 * @package             PyroCMS
 * @subpackage          Accounts Module
 */
class Admin extends Admin_Controller
{
	protected $section = 'accounts';
        
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
				'field' => 'account_type',
				'label' => 'lang:accounts:account_type',
				'rules' => 'trim|required|callback__check_valid_accountType'
			),
			array(
				'field' => 'industry',
				'label' => 'lang:accounts:industry',
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
			),                     
			array(
				'field' => 'razon_social',
				'label' => 'lang:accounts:razonsocial',
				'rules' => 'trim|max_length[200]'
			),                    
			array(
				'field' => 'cuit',
				'label' => 'lang:accounts:cuit',
				'rules' => 'trim'
			),                    
			array(
				'field' => 'iva',
				'label' => 'lang:accounts:iva',
				'rules' => 'trim'
			),                    
			array(
				'field' => 'iibb',
				'label' => 'lang:accounts:iibb',
				'rules' => 'trim'
			),                    
			array(
				'field' => 'pago_proveedores_mail',
				'label' => 'lang:accounts:pago_prov_mail',
				'rules' => 'trim'
			),                    
			array(
				'field' => 'pago_proveedores_tel',
				'label' => 'lang:accounts:pago_prov_tel',
				'rules' => 'trim'
			),                    
			array(
				'field' => 'pago_proveedores_forma_de_pago',
				'label' => 'lang:accounts:pago_prov_forma_de_pago',
				'rules' => 'trim'
			),             
			array(
				'field' => 'pago_proveedores_dias_horarios',
				'label' => 'lang:accounts:pago_prov_dias',
				'rules' => 'trim'
			),                   
			array(
				'field' => 'pago_proveedores_detalle',
				'label' => 'lang:accounts:name',
				'rules' => 'trim'
			),  
			array(
				'field' => 'cuentas_por_cobrar_mail',
				'label' => 'lang:accounts:cuentas_cobrar_mail',
				'rules' => 'trim'
			),                    
			array(
				'field' => 'cuentas_por_cobrar_tel',
				'label' => 'lang:accounts:cuentas_cobrar_tel',
				'rules' => 'trim'
			),                       
			array(
				'field' => 'cuentas_por_cobrar_detalle',
				'label' => 'lang:accounts:cuentas_cobrar',
				'rules' => 'trim'
			)                    
        );

	public function __construct()
	{
		parent::__construct();
		// Load all the required classes
		$this->load->model('accounts_m');
		$this->load->library(array('form_validation','geoworldmap'));
		$this->lang->load('accounts');
                $this->load->config('dropdown_list');
                $this->load->helper(array('accounts_date','accounts_converters','date'));
                // IMG path
                $this->template->prepend_metadata('<script>var IMG_PATH = "'.BASE_URL.SHARED_ADDONPATH.'modules/'.$this->module.'/img/"; </script>');
	}
        
        /**
        * Genera array de valores para los dropdown del form      
        */
        public function _gen_dropdown_list()
        {
                //week array
		$this->data->week_array =$this->config->item('dd_week_days'); 
                //hour array
		$this->data->hour_array =gen_lista_horas(); 
                //condicion iva array
                $this->data->cond_iva_array = $this->config->item('dd_cond_iva');
                //account_type array
                $this->data->account_type_array = $this->config->item('dd_account_type');
                //acount payment mode
                $this->data->forma_de_pago_array = $this->config->item('dd_payment_mode');            
        }

	/**
	 * List all items
	 */
	public function index()
	{
                $this->_gen_dropdown_list();
		// Create pagination links
		$total_rows = $this->accounts_m->search('counts');                
                $pagination = create_pagination('admin/accounts/index', $total_rows, 10);
                $post_data['pagination'] = $pagination;
                $post_data['active'] = 1; //only active accounts           
		// Using this data, get the relevant results
		$accounts = $this->accounts_m->search('results',$post_data);
                $accounts = $this->_convertIDtoText($accounts);        
		//do we need to unset the layout because the request is ajax?
		$this->input->is_ajax_request() ? $this->template->set_layout(FALSE) : '';                
		// Build the view with accounts/views/admin/items.php
		$this->data->accounts =& $accounts;             
		$this->template->title($this->module_details['name'])
                               ->set('pagination', $pagination)
                               ->append_css('module::accounts.css')                        
                               ->append_js('module::accounts_index.js') 
                               ->append_js('module::model.js');                 
                
		$this->input->is_ajax_request() ? $this->template->build('admin/partials/accounts', $this->data) : $this->template->build('admin/index', $this->data);                
	}        
        
	/**
	 * Preview account
	 * @access public
	 * @param int $id the ID of the blog post to preview
	 * @return void
	 */
	public function preview($id = 0)
	{
                // DB query - se convierte a array para usar funcion convertir IDs
                $account[0] = $this->accounts_m->get($id);
                $account = $this->_convertIDtoText($account);
                $account = array_pop($account);
                // set template
		$this->template
				->set_layout('modal', 'admin')
                                ->append_css('module::workless.css')
                                ->append_css('module::accounts.css')
				->set('account', $account)
				->build('admin/partials/account');                         
	}        

	public function create()
	{
		// Set the validation rules from the array above
		$this->form_validation->set_rules($this->validation_rules);                
                
                $this->_gen_dropdown_list();
                
		// check if the form validation passed
		if($this->form_validation->run())
		{
                        // See if the model can create the record
			if($this->accounts_m->insert(
                              array('name' => $this->input->post('name'),
                                    'account_type' => $this->input->post('account_type'),
                                    'industry' => $this->input->post('industry'),
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
                                    'razon_social' => $this->input->post('razon_social'),
                                    'cuit' => $this->input->post('cuit'),
                                    'iva' => $this->input->post('iva'),
                                    'iibb' => $this->input->post('iibb'),
                                    'pago_proveedores_mail' => $this->input->post('pago_proveedores_mail'),
                                    'pago_proveedores_tel' => $this->input->post('pago_proveedores_tel'),
                                    'pago_proveedores_dias_horarios' => cleanString_DiasHorarios($this->input->post('pago_proveedores_dias_horarios')),
                                    'pago_proveedores_forma_de_pago' => $this->input->post('pago_proveedores_forma_de_pago'),
                                    'pago_proveedores_detalle' => $this->input->post('pago_proveedores_detalle'),
                                    'cuentas_por_cobrar_mail' => $this->input->post('cuentas_por_cobrar_mail'),
                                    'cuentas_por_cobrar_tel' => $this->input->post('cuentas_por_cobrar_tel'),
                                    'cuentas_por_cobrar_detalle' => $this->input->post('cuentas_por_cobrar_detalle'),
                                    'author_id' => $this->current_user->id,
                                    'created_on' => now() )))
			{
				// All good...
				$this->session->set_flashdata('success', lang('accounts:success'));
				redirect('admin/accounts');
			}
			// Something went wrong. Show them an error
			else
			{
				$this->session->set_flashdata('error', lang('accounts:error'));
				redirect('admin/accounts/create');
			}
		}
		
		foreach ($this->validation_rules AS $rule)
		{
			$this->data->{$rule['field']} = $this->input->post($rule['field']);
		}

		// Build the view using accounts/views/admin/form.php
		$this->template->title($this->module_details['name'], lang('accounts.new_item'))
	        ->append_js('module::ws_autocomplete.js')                         
                ->append_js('module::accounts_create.js')
                ->append_js('module::model.js')        
                ->append_css('module::accounts.css')                            
                ->append_css('module::jquery/jquery.autocomplete.css')                        
                ->build('admin/form', $this->data);
	}
	
	public function edit($id = 0)
	{
            if($id==0)
            {
                $this->session->set_flashdata('error', lang('accounts:error_id_empty'));
		redirect('admin/accounts');
            }
            else
            {    
                //consulta SQL
                $this->data = $this->accounts_m->get($id); 
                if($this->data == FALSE)
                {
                    $this->session->set_flashdata('error', lang('accounts:error_id_empty'));
                    redirect('admin/accounts');
                }                
            }		
                $this->data = $this->accounts_m->get($id);
                //Use Geoworldmap library 
                $city = $this->geoworldmap->getCityByID($this->data->CityID);
                $this->data->City = $city->City;
                $this->_gen_dropdown_list();

		// Set the validation rules from the array above
		$this->form_validation->set_rules($this->validation_rules);

		// check if the form validation passed
		if($this->form_validation->run())
		{
			// get rid of the btnAction item that tells us which button was clicked.
			// If we don't unset it MY_Model will try to insert it
			unset($_POST['btnAction']);
			
			// See if the model can update the record
			//$this->db->where('account_id', $id);
                        if($this->accounts_m->update($id, array(
                                    'name' => $this->input->post('name'),
                                    'account_type' => $this->input->post('account_type'),
                                    'industry' => $this->input->post('industry'),
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
                                    'razon_social' => $this->input->post('razon_social'),
                                    'cuit' => $this->input->post('cuit'),
                                    'iva' => $this->input->post('iva'),
                                    'iibb' => $this->input->post('iibb'),
                                    'pago_proveedores_mail' => $this->input->post('pago_proveedores_mail'),
                                    'pago_proveedores_tel' => $this->input->post('pago_proveedores_tel'),
                                    'pago_proveedores_dias_horarios' => cleanString_DiasHorarios($this->input->post('pago_proveedores_dias_horarios')),
                                    'pago_proveedores_forma_de_pago' => $this->input->post('pago_proveedores_forma_de_pago'),
                                    'pago_proveedores_detalle' => $this->input->post('pago_proveedores_detalle'),
                                    'cuentas_por_cobrar_mail' => $this->input->post('cuentas_por_cobrar_mail'),
                                    'cuentas_por_cobrar_tel' => $this->input->post('cuentas_por_cobrar_tel'),
                                    'cuentas_por_cobrar_detalle' => $this->input->post('cuentas_por_cobrar_detalle'),
                                    //'author_id' => $this->current_user->id,
                                    'updated_on' => now() )))                                
			{
				// All good...
				$this->session->set_flashdata('success', lang('accounts:edit_success'));
				redirect('admin/accounts');
			}
			// Something went wrong. Show them an error
			else
			{
				$this->session->set_flashdata('error', lang('accounts:error'));
				redirect('admin/accounts/edit/'.$id);
			}
		}

		// Build the view using accounts/views/admin/form.php
		$this->template->title($this->module_details['name'], lang('accounts:edit_account'))
                ->append_js('module::model.js')    	        
                ->append_js('module::ws_autocomplete.js')                         
                ->append_js('module::accounts_create.js')                    
                ->append_css('module::accounts.css') 
                ->append_css('module::jquery/jquery.autocomplete.css')                         
		->build('admin/form', $this->data);
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
			$this->accounts_m->inactive_many($this->input->post('action_to'));
		}
		elseif (is_numeric($id))
		{
			// they just clicked the link so we'll delete that one
			$this->accounts_m->inactive($id);
		}
		redirect('admin/accounts');
	}
        
        /**
         * Convierte ID´s de resultado SQL a texto - acepta objeto o arrays de objetos
         * @param result array resultado SQL
         * @return result object 
         */
        public function _convertIDtoText($results)
        {  
            foreach($results as $reg)
            {
                //Use helper
                $reg->account_type = accountTypeID_to_text($this->config->item('dd_account_type'),$reg->account_type);
                $reg->iva = accountIvaID_to_text($this->config->item('dd_cond_iva'), $reg->iva);
                //Use Geoworldmap library 
                $city = $this->geoworldmap->getCityByID($reg->CityID);
                $reg->City = $city->City;
                $reg->pago_proveedores_dias_horarios = StringToHtml_diasHorarios($reg->pago_proveedores_dias_horarios);
            }           
            return $results;              
        }

// :::::: CALLBACKS ::::::::::::::::::::::::::::::::::::::::::::::: 
        
        /**
	 * Callback method that checks the account_type
	 * @access public
	 * @param string timezone to check
	 * @return bool
	 */
	public function _check_valid_accountType($id)
	{
            if($id==='0' || !array_key_exists($id,$this->config->item('dd_account_type')))
            {
                $this->form_validation->set_message('_check_valid_accountType', sprintf(lang('accounts:account_type_not_valid'), $id));
                return FALSE;
            }
            return TRUE;
	}
        
        

// :::::: AJAX methods :::::::::::::::::::::::::::::::::::::::::::::::        
        
	/**
	 * method to fetch filtered results for account list
	 * @access public
	 * @return void
	 */
	public function ajax_filter()
	{
		$this->_gen_dropdown_list();
                //captura post
                $post_data = array();
                if($this->input->post('f_type'))
                {
                    $data->account_type = $this->input->post('f_type');
                    $post_data['account_type']=$data->account_type;                    
                }    
                if($this->input->post('f_keywords'))
                {    
                    $data->keywords = $this->input->post('f_keywords');
                    $post_data['keywords']=$data->keywords; 
                }    
                $post_data['active'] = 1;
                //pagination
                $total_rows = $this->accounts_m->search('counts',$post_data);
                $pagination = create_pagination('admin/accounts/ajax_filter', $total_rows, 10);
                $post_data['pagination'] = $pagination;                
                //query with limits
                $results = $this->accounts_m->search('results',$post_data);                             
                $results = $this->_convertIDtoText($results);
		//set the layout to false and load the view
                $this->input->is_ajax_request() ? $this->template->set_layout(FALSE) : '';                 
		$this->template
			->set('pagination', $pagination)                       
			->set('accounts', $results)
                        ->append_css('module::accounts.css')                        
                        ->append_js('module::accounts_index.js')
                        ->append_js('module::model.js');                                        
                        //->build('admin/partials/accounts');  
                $this->input->is_ajax_request() ? $this->template->build('admin/partials/accounts', $this->data) : $this->template->build('admin/index', $this->data);                
	}
        
        /**
         * Returns json response with accounts list, given "keyword" search
         */
        public function accounts_autocomplete_ajax()
        {
            $respond->accounts = array();
            $respond->count = 0;
            if($this->input->get('term'))
            {             
		$post_data['keywords'] = $this->input->get('term');
                $post_data['pagination']['limit'] = $this->input->get('limit');
                $post_data['active'] = 1;
                if ($result = $this->accounts_m->search('results',$post_data))
		{
			foreach ($result as $account)
			{
                            $respond->accounts[] = $account;
                            $respond->count++;
			}
		}                                   
            }
            
            echo json_encode($respond);    
        } 
        
        /**
         * Returns json response with account full record
         */
        public function get_account_ajax($id)
        {
            if($id)
            {             
               $respond = $this->accounts_m->get($id);
                                  
            }else
                {
                    $respond = FALSE;
                }
            
            echo json_encode($respond);    
        }        
        
}        