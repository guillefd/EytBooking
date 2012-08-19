<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package  	PyroCMS
 * @subpackage  spaces
 * @category  	Module
 * @author  	PyroCMS Dev Team
 */
class Admin_Spaces extends Admin_Controller {

	/**
	 * The current active section
	 * @access protected
	 * @var int
	 */
	protected $section = 'spaces';
	
	/**
	 * Array that contains the validation rules
	 * @access protected
	 * @var array
	 */
	protected $validation_rules = array(
		array(
                        'field' => 'location',
                        'label' => 'lang:spaces:location',
                        'rules' => 'trim',
                ),            
		array(
                        'field' => 'location_id',
                        'label' => 'lang:spaces:location',
                        'rules' => 'trim|required',
                ),
		array(
                        'field' => 'denomination_id',
                        'label' => 'lang:spaces:denomination',
                        'rules' => 'trim|required',
                ),            
		array(
                        'field' => 'name',
                        'label' => 'lang:spaces:name',
                        'rules' => 'trim|required',
                ),
		array(
                        'field' => 'description',
                        'label' => 'lang:spaces:description',
                        'rules' => 'trim',
                ),            
		array(
                        'field' => 'level',
                        'label' => 'lang:spaces:level',
                        'rules' => 'trim',
                ),            
		array(
                        'field' => 'width',
                        'label' => 'lang:spaces:width',
                        'rules' => 'trim',
                ), 
		array(
                        'field' => 'length',
                        'label' => 'lang:spaces:length',
                        'rules' => 'trim',
                ), 
		array(
                        'field' => 'height',
                        'label' => 'lang:spaces:heigth',
                        'rules' => 'trim',
                ),             
		array(
                        'field' => 'square_mt',
                        'label' => 'lang:spaces:square_mt',
                        'rules' => 'trim',
                ),            
		array(
                        'field' => 'shape_id',
                        'label' => 'lang:spaces:shape',
                        'rules' => 'trim',
                ),            
		array(
                        'field' => 'layouts',
                        'label' => 'lang:spaces:layouts',
                        'rules' => 'trim',
                ),            
		array(
                        'field' => 'room_type_id',
                        'label' => 'lang:spaces:room_type',
                        'rules' => 'trim',
                ),            
		array(
                        'field' => 'features',
                        'label' => 'lang:spaces:features',
                        'rules' => 'trim',
                )                                   
            );
        
	/**
	 * The constructor
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('products_spaces_m');
                $this->load->helper(array('date'));
		$this->lang->load(array('products','categories','locations','features','spaces'));		
		// Loads libraries
		$this->load->library(array('form_validation','accounts','spaces_denominations'));            
                // template addons
                $this->template->append_css('module::products.css') 
                               ->prepend_metadata('<script>var IMG_PATH = "'.BASE_URL.SHARED_ADDONPATH.'modules/'.$this->module.'/img/"; </script>');                
                
                
	}
        
        function _gen_dropdown_list()
        {
            $this->data->denominations_array = $this->spaces_denominations->gen_dd_array();
            $this->data->dimensions_array = array(''=>'','height'=>lang('spaces:height'),'width'=>lang('spaces:width'),'length'=>lang('spaces:length'));
        }        
        
        
	/**
	 * Index method, lists all spaces
	 * @access public
	 * @return void
	 */
	public function index()
	{	
		// Create pagination links
		$total_rows = $this->products_spaces_m->search('counts');
		$pagination = create_pagination('admin/products/spaces/index', $total_rows, 10, 5);
                $post_data['pagination']  = $pagination;
                $post_data['active'] = 1; //only active spaces - IMPROVE!!!                         			
		// Using this data, get the relevant results
		$spaces = $this->products_spaces_m->search('results',$post_data);
                //CONVERT ID TO TEXT
                //$this->_convertIDtoText($spaces);
                //$this->_formatValuesForView($spaces);

		$this->template
			->title($this->module_details['name'], lang('spaces:list_title'))
			->set('spaces', $spaces)
			->set('pagination', $pagination)                        
                        //->append_js('module::spaces_index.js')
                        //->append_js('module::model.js')                        
                        //->append_css('module::jquery/jquery.autocomplete.css')
			->build('admin/spaces/index', $this->data);
	}
        
	/**
	 * Create method, creates a new room
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
                $data = array('location_id'=>$this->input->post('location_id'),
                              'name' =>$this->input->post('name'),
                              'description' => $this->input->post('description'),                    
                              'level' => $this->input->post('level'),
                              'dimension' => $this->input->post('dimensions'), 
                              'square_mt' => $this->input->post('square_mt'), 
                              'shape_id'=>$this->input->post('shape_id'),
                              'layouts' => $this->input->post('layouts'), 
                              'room_type_id' => $this->input->post('room_type_id'), 
                              'features' => $this->input->post('features'), 
                              'author_id' => $this->current_user->id,
                              'created_on' => now() 
                              );
                if($this->products_spaces_m->insert($data))
		{
                    // All good...
                    $this->session->set_flashdata('success', lang('spaces:add_success'));
                    redirect('admin/products/spaces');
		}
		// Something went wrong. Show them an error
		else
                    {
			$this->session->set_flashdata('error', lang('spaces:add_error'));
                    	redirect('admin/products/spaces/create');
                    }
            }                                       

            $this->_gen_dropdown_list();    
            // Loop through each validation rule
            foreach ($this->validation_rules as $rule)
            {
                    $space->{$rule['field']} = set_value($rule['field']);                  
            }
            
            $this->template
                    ->title($this->module_details['name'], lang('spaces:create_title'))
	            ->append_js('module::spaces_form.js')
	            ->append_js('module::spaces_form_model.js')                    
                    ->append_css('module::jquery/jquery.autocomplete.css')                                       
                    ->set('space', $space)
                    ->build('admin/spaces/form',$this->data);	
	}        

        
        
}