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
                        'rules' => 'trim|required|callback__check_validLocationId',
                ),
		array(
                        'field' => 'denomination',
                        'label' => 'lang:spaces:denomination',
                        'rules' => 'trim',
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
                        'field' => 'facilities',
                        'label' => 'lang:spaces:facilities',
                        'rules' => '',
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
		$this->load->library(array('form_validation','accounts','spaces_denominations','products','shapes','layouts','facilities','geoworldmap'));            
                // template addons
                $this->template->append_css('module::products.css') 
                               ->prepend_metadata('<script>var IMG_PATH = "'.BASE_URL.SHARED_ADDONPATH.'modules/'.$this->module.'/img/"; </script>');                
                
                
	}
        
        function _gen_dropdown_list()
        {
            $this->data->denominations_array = $this->spaces_denominations->gen_dd_array();
            $this->data->shapes_array = $this->shapes->gen_dd_array();            
            $this->data->layouts_array = $this->layouts->gen_dd_array();            
            $this->data->facilities_array = $this->facilities->gen_dd_array();            
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
                $this->_gen_dropdown_list();
                $this->_convertIDtoText($spaces);
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
	 * Create method, creates a new space
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
                              'denomination_id'=>$this->input->post('denomination_id'),          
                              'name' =>$this->input->post('name'),
                              'description' => $this->input->post('description'),                    
                              'level' => $this->input->post('level'),
                              'width' => $this->input->post('width'), 
                              'height' => $this->input->post('height'), 
                              'length' => $this->input->post('length'),                     
                              'square_mt'=> $this->input->post('square_mt'), 
                              'shape_id'=>$this->input->post('shape_id'),
                              'layouts' => $this->input->post('layouts'),  
                              'facilities' => serialize($this->input->post('facilities')), 
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
            //facilities[] array value for re-populating form
            $space->facilities = $this->input->post('facilities');
            
            $this->template
                    ->title($this->module_details['name'], lang('spaces:create_title'))
	            ->append_js('module::spaces_form.js')
	            ->append_js('module::spaces_form_model.js')                    
                    ->append_css('module::jquery/jquery.autocomplete.css')                                       
                    ->set('space', $space)
                    ->build('admin/spaces/form',$this->data);	
	}
        
        
	/**
	 * Edit method, edits an existing space
	 * @access public
	 * @param int id The ID of the location to edit
	 * @return void
	 */
	public function edit($id = 0)
	{			
            if($id==0)
            {
                $this->session->set_flashdata('error', lang('spaces:error_id_empty'));
		redirect('admin/products/spaces/index');
            }
            else
            {                    
                //consulta SQL
                $space = $this->products_spaces_m->get_where(array('space_id'=>$id));                
                if($space == FALSE)
                {
                    $this->session->set_flashdata('error', lang('spaces:error_id_empty'));
                    redirect('admin/products/spaces/index');
                }
                //convert facilities value to array
                $space->facilities =  unserialize($space->facilities);
            }                      
            // Set the validation rules from the array above
            $this->form_validation->set_rules($this->validation_rules);           
            
            // Validate the results
            if ($this->form_validation->run())
            {		
                $data = array('location_id'=>$this->input->post('location_id'),
                              'denomination_id'=>$this->input->post('denomination_id'),          
                              'name' =>$this->input->post('name'),
                              'description' => $this->input->post('description'),                    
                              'level' => $this->input->post('level'),
                              'width' => $this->input->post('width'), 
                              'height' => $this->input->post('height'), 
                              'length' => $this->input->post('length'),                     
                              'square_mt'=> $this->input->post('square_mt'), 
                              'shape_id'=>$this->input->post('shape_id'),
                              'layouts' => $this->input->post('layouts'),  
                              'facilities' => serialize($this->input->post('facilities')), 
                              'updated_on' => now() 
                              );                 
                if($this->products_spaces_m->update($id, $data))
                {        
                    // All good...
                    $this->session->set_flashdata('success', lang('spaces:edit_success'));
                    redirect('admin/products/spaces/index');
                }
                else
                    {
                            $this->session->set_flashdata('error', lang('spaces:edit_error'));
                            redirect('admin/products/spaces/edit/'.$id);
                    }
            }
            // Loop through each rule
            $this->_gen_dropdown_list();
            //CONVERT ID TO TEXT
            $this->_convertIDtoText($space);  

            // Loop through each rule
            foreach ($this->validation_rules as $rule)
            {
                    if ($this->input->post($rule['field']) !== FALSE)
                    {
                            $space->{$rule['field']} = $this->input->post($rule['field']);
                    }
            }         
            $this->template
                    ->title($this->module_details['name'], lang('spaces:edit_title'))
	            ->append_js('module::spaces_form.js')
	            ->append_js('module::spaces_form_model.js')                    
                    ->append_css('module::jquery/jquery.autocomplete.css')                                       
                    ->set('space', $space)
                    ->build('admin/spaces/form',$this->data);
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
			$this->products_spaces_m->inactive_many($this->input->post('action_to'));
		}
		elseif (is_numeric($id))
		{
			// they just clicked the link so we'll delete that one
			if($this->products_spaces_m->inactive($id))
                        {        
                            // All good...
                            $this->session->set_flashdata('success', lang('spaces:delete_success'),$id);
                            redirect('admin/products/spaces/index');
                        }
                         else
                            {
                                $this->session->set_flashdata('error', lang('spaces:delete_error'));
                                redirect('admin/products/spaces/index');
                            }
		}
		redirect('admin/products/spaces/index');
	}          

	/**
	 * Preview Space
	 * @access public
	 * @param int $id the ID of the location
	 * @return void
	 */
	public function preview($id = 0)
	{
                $space = $this->products_spaces_m->get_where(array('space_id'=>$id));
                $this->_gen_dropdown_list();                 
                //convert facilities value to array
                $space->facilities_txt =  $this->convertFacilitiesToText(unserialize($space->facilities));               
                $space = $this->_convertIDtoText($space);
                // set template
		$this->template
				->set_layout('modal','admin')
                                ->append_css('module::workless.css')
				->set('space', $space)
				->build('admin/spaces/partials/space');                         
	}        

        
// HELPERS :::::::::::::::::::::::::::::::::::::::::::::::::::
        
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
            if($location = $this->products->get_location($reg->location_id))
            {    
                //nombre de la cuenta
                $account = $this->accounts->get_account($location->account_id);
                //Use Geoworldmap library - nombre de la ciudad
                $city = $this->geoworldmap->getCityByID($account->CityID);
                $reg->location_extended = $location->name.' [ '.$account->name.' ]';
                $reg->account = $account->name;
                $reg->location = $location->name;
                $reg->address = $location->address_l1.' '.$location->address_l2;
                $reg->area = $location->area;
                $reg->city = $city->City;
            }
            else
                {
                    $reg->location = " --- ";
                }
            $reg->denomination = $reg->denomination_id > 0 ? $this->data->denominations_array[$reg->denomination_id] : '';
            $reg->shape = $reg->shape_id > 0 ? $this->data->shapes_array[$reg->shape_id] : '';
            $reg->layouts_txt = $this->convertLayoutsToText($reg->layouts);
        }       
        
        public function convertLayoutsToText($string)
        {
            $txt = "";            
            if (!empty($string))
            {
                $strvecs = explode(';',$string);
                foreach($strvecs as $vec)
                {
                    if(!empty($vec))
                    {
                        $reg = explode(',',$vec);
                        $txt.= $this->data->layouts_array[$reg[0]].': '.$reg[1].'<br>';
                    }
                }
                        
            }
            return $txt;
        }
        
        public function convertFacilitiesToText($array)
        {
            $txt = '<table><th colspan="2">'.lang('spaces:facilities').'</th>';
            foreach($this->data->facilities_array as $key => $subVec)
            {
                $txt.='<tr><td>'.$key.': </td><td>';
                foreach($subVec as $skey =>$reg)
                {
                    $txt.= in_array($skey, $array) ? ' ['.$reg.']' : '';
                }
                $txt.='</td></tr>';
            }
            $txt.='</table>';
            return $txt;
        }

// AJAX CALLS
        
                /**
         * Returns json response with spaces list, given "keyword" search
         */
        public function spaces_autocomplete_ajax()
        {
            $respond->spaces = array();
            $respond->count = 0;
            if($this->input->get('term'))
            {             
		$post_data['keywords'] = $this->input->get('term');
                $post_data['pagination']['limit'] = $this->input->get('limit');
                $post_data['location_id'] = $this->input->get('location_id');
                $post_data['active'] = 1;
                if ($result = $this->products_spaces_m->search('results',$post_data))
		{
			foreach ($result as $space)
			{
                            // Loop through each rule
                            $this->_gen_dropdown_list();
                            //CONVERT ID TO TEXT
                            $this->_convertIDtoText($space); 
                            $respond->spaces[] = $space;
                            $respond->count++;
			}
		}                                   
            }
            
            echo json_encode($respond);    
        }
        
        
// CHECK ID ::::::::::::::::::::::::::::::::::::::::::::::::::
        	/**
	 * Callback method that checks the location id
	 * @access public
	 * @param id The id to check
	 * @return bool
	 */        
        public function _check_validLocationId($id)
        {
            if(!$this->products->get_location($id))
            {
                if($this->method == "edit" && $this->products->get_location($id,0))//2nd param active = 0
                {
                    return TRUE; //devuelve TRUE porque el ID fue seleccionado cuando locacíon estuvo activa
                }
                $this->form_validation->set_message('_check_validLocationId', sprintf(lang('spaces:location_id_not_valid')));
                return FALSE;
            }else
                {
                    return TRUE;
                }
        }
        
        public function _check_facilities_id()
        {
            //multiple
            return $this->input->post('facilities');
        }

        
        
}