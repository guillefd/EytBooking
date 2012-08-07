<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package  	PyroCMS
 * @subpackage  Categories
 * @category  	Module
 * @author  	PyroCMS Dev Team
 */
class Admin_Regions extends Admin_Controller {

	/**
	 * The current active section
	 * @access protected
	 * @var int
	 */
	protected $section = 'regions';
	
	/**
	 * Array that contains the validation rules
	 * @access protected
	 * @var array
	 */
	protected $validation_rules = array(
		array(
			'field' => 'Region',
			'label' => 'lang:geo_region_label',
			'rules' => 'trim|required|max_length[50]'
		),
		array(
			'field' => 'CountryID',
			'label' => 'lang:geo_country_label',
			'rules' => 'trim|required'
		), 
		array(
			'field' => 'Code',
			'label' => 'lang:geo_region_code_label',
			'rules' => 'trim'
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
                
		$this->load->model(array('geo_countries_m','geo_regions_m'));
		$this->lang->load(array('geoworldmap','webservices'));		
		$this->load->library(array('form_validation'));
                
                //listado para combo countries                
		if ($countries = $this->geo_countries_m->get_all())
		{                
                    foreach ($countries as $country)
                    {
                            $this->data->countries[$country->CountryId] = $country->Country;
                    }                    
                }                
	}
        
/**
	 * Show all countries
	 * @access public
	 * @return void
	 */
	public function index($countryid)
	{               
                $country = $this->geo_countries_m->get_by($countryid);
                
		// Using this data, get the relevant results
		$regions = $this->geo_regions_m->get_many_by($countryid);

		$this->template
			->title($this->module_details['name'])
                        ->set('country',$country)
			->set('regions', $regions)
                        ->build('admin/regions/index');
	}
        
/**
	 * Create new country
	 * @access public
	 * @return void
	 */
	public function create()
	{
            $this->form_validation->set_rules($this->validation_rules);

		if ($this->form_validation->run())
		{
                        
			$id = $this->geo_regions_m->insert(array(
				'CountryID'				=> $this->input->post('CountryID'),
				'Region'				=> $this->input->post('Region'),
				'Code'                                  => $this->input->post('Code'),
				'ADM1Code'                              => '',
			));
			if ($id)
			{
				$this->pyrocache->delete_all('geoworldmap_m');
				$this->session->set_flashdata('success', sprintf($this->lang->line('geo_region_add_success'), $this->input->post('Country')));
			}
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('geo_region_add_error'));
			}

			// Redirect back to the form or main page
			$this->input->post('btnAction') == 'save_exit' ? redirect('admin/geoworldmap/countries/') : redirect('admin/geoworldmap/regions/edit/' . $id);
		}
		else
		{
			// Go through all the known fields and get the post values
			foreach ($this->validation_rules as $key => $field)
			{
                            $region->$field['field'] = set_value($field['field']);
			}
		}                            
                        
		$this->template
			->title($this->module_details['name'], lang('geo_region_create_title'))                                                                 
			->set('region', $region)
		        ->build('admin/regions/form', $this->data);
                
	}
        

        /**
	 * Create new country
	 * @access public
	 * @return void
	 */
	public function create_ajax()
	{
                $this->form_validation->set_rules($this->validation_rules);            
                // Go through all the known fields and get the post values
                foreach ($this->validation_rules as $key => $field)
                {
                    $region->{$field['field']} = set_value($field['field']);
                }                
		
		$this->data->method = 'create';
		$this->data->region =& $region;                
		
		if ($this->form_validation->run())
		{
			$id = $this->geo_regions_m->insert_ajax(array(
				'CountryID'				=> $this->input->post('CountryID'),
				'Region'				=> $this->input->post('Region'),
				'Code'                                  => $this->input->post('Code'),
				'ADM1Code'                              => '',
			));
			
			if ($id > 0)
			{
				$message = sprintf( lang('geo_region_add_success'), $this->input->post('Region'));
			}
			else
			{
				$message = lang('geo_region_add_error');
			}

			return $this->template->build_json(array(
				'message'		=> $message,
				'Region'		=> $this->input->post('Region'),
				'RegionID'	        => $id,
				'status'		=> 'ok'
			));
		}	
		else
		{
			// Render the view
			$form = $this->load->view('admin/regions/form', $this->data, TRUE);
                                                
			if ($errors = validation_errors())
			{
				return  $this->template->build_json(array(
					'message'	=> $errors,
					'status'	=> 'error',
					'form'		=> $form
				));
			}

			echo $form;
		}
                
	}                  


        /**
	 * Edit country	
	 * @access public
	 * @param int $id the ID of the country to edit
	 * @return void
	 */
	public function edit($id = 0)
	{
		$id OR redirect('admin/geoworldmap/regions');
		$region = $this->geo_regions_m->get_by($id);
                $this->form_validation->set_rules($this->validation_rules);

		if ($this->form_validation->run())
		{
                        
			$result = $this->geo_regions_m->update($id, array(
				'CountryID'				=> $this->input->post('CountryID'),
				'Region'				=> $this->input->post('Region'),
				'Code'                                  => $this->input->post('Code'),
				'ADM1Code'                              => '',
			));                           		
			if ($result)
			{
				$this->session->set_flashdata(array('success' => sprintf(lang('geo_region_edit_success'), $this->input->post('Region'))));
			}			
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('geo_region_edit_error'));
			}

			// Redirect back to the form or main page
			$this->input->post('btnAction') == 'save_exit' ? redirect('admin/geoworldmap/countries') : redirect('admin/geoworldmap/regions/edit/'.$id);
		}

		// Go through all the known fields and get the post values
		foreach ($this->validation_rules as $key => $field)
		{
			if ($this->input->post($field['field']))
			{
				$region->$field['field'] = set_value($field['field']);
			}
		}                
                        
		$this->template
			->title($this->module_details['name'], lang('geo_region_create_title'))                                                                 
			->set('region', $region)
		        ->build('admin/regions/form', $this->data);
                
	}                

        
        
}

/* End of file XXX.php */
/* Location: ./application/controllers/XXX.php */
