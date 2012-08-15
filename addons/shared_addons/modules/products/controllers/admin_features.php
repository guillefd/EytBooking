<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package  	PyroCMS
 * @subpackage  locations
 * @category  	Module
 * @author  	PyroCMS Dev Team
 */
class Admin_Features extends Admin_Controller {

	/**
	 * The current active section
	 * @access protected
	 * @var int
	 */
	protected $section = 'features';
	
	/**
	 * Array that contains the validation rules
	 * @access protected
	 * @var array
	 */
	protected $validation_rules_features = array(
                                                        array(
                                                                'field' => 'cat_feature_id',
                                                                'label' => 'lang:features:cat_feature_label',
                                                                'rules' => 'trim|required',
                                                            ),
                                                        array(
                                                                'field' => 'cat_product_id',
                                                                'label' => 'lang:features:cat_product_label',
                                                                'rules' => 'trim|required',
                                                            ),            
                                                        array(
                                                                'field' => 'name',
                                                                'label' => 'lang:features:name_label',
                                                                'rules' => 'trim|required',
                                                            ),            
                                                        array(
                                                                'field' => 'description',
                                                                'label' => 'lang:features:description_label',
                                                                'rules' => 'trim',
                                                             ),
                                                        array(
                                                                'field' => 'usageunit_id',
                                                                'label' => 'lang:features:usageunit_label',
                                                                'rules' => 'trim|required',
                                                            ),                            
                                                        array(
                                                                'field' => 'value',
                                                                'label' => 'lang:features:value_label',
                                                                'rules' => 'trim',
                                                            ),            
                                                        array(
                                                                'field' => 'group',
                                                                'label' => 'lang:features:group_label',
                                                                'rules' => 'trim',
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
		
		$this->load->model('products_features_m');
                $this->load->helper(array('date'));
		$this->lang->load(array('products','categories','locations','features'));		
		// Loads libraries
		$this->load->library(array('form_validation','cat_features'));
                // template addons
                $this->template->append_css('module::products.css') 
                               ->prepend_metadata('<script>var IMG_PATH = "'.BASE_URL.SHARED_ADDONPATH.'modules/'.$this->module.'/img/"; </script>');                
                
                
	}
        
        
	/**
	 * Index method, lists all locations
	 * @access public
	 * @return void
	 */
	public function index()
	{
		// Create pagination links
		$total_rows = $this->products_features_m->search('counts');
		$pagination = create_pagination('admin/products/features/index', $total_rows, 10, 5);
                $post_data['pagination']  = $pagination;
                $post_data['active'] = 1; //only active accounts - IMPROVE!!!                         			
		// Using this data, get the relevant results
		$features = $this->products_features_m->search('results',$post_data);
                //CONVERT ID TO TEXT
                //$this->_convertIDtoText($features);
                //$this->_formatValuesForView($features);

		$this->template
			->title($this->module_details['name'], lang('features:list_title'))
			->set('features', $features)
			->set('pagination', $pagination)                        
                        //->append_js('module::features_index.js')
                        //->append_js('module::model.js')                        
                        //->append_css('module::jquery/jquery.autocomplete.css')
			->build('admin/features/index', $this->data);
	}        
        
        
	/**
	 * Create method, creates a new feature
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
            if ($location->type == '') $location->type = 'wysiwyg-simple';               

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
 
        
}