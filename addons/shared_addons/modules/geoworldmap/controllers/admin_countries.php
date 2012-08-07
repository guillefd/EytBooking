<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package  	PyroCMS
 * @subpackage  Categories
 * @category  	Module
 * @author  	PyroCMS Dev Team
 */
class Admin_Countries extends Admin_Controller {

	/**
	 * The current active section
	 * @access protected
	 * @var int
	 */
	protected $section = 'countries';
	
	/**
	 * Array that contains the validation rules
	 * @access protected
	 * @var array
	 */
	protected $validation_rules = array(
		array(
			'field' => 'Country',
			'label' => 'lang:geo_country_label',
			'rules' => 'trim|required|max_length[50]'
		),
		array(
			'field' => 'FIPS104',
			'label' => 'lang:geo_country_fips104_label',
			'rules' => 'trim'
		),  
		array(
			'field' => 'ISO2',
			'label' => 'lang:geo_country_iso2_label',
			'rules' => 'trim'
		),              
		array(
			'field' => 'ISO3',
			'label' => 'lang:geo_country_iso3_label',
			'rules' => 'trim'
		), 
		array(
			'field' => 'ISON',
			'label' => 'lang:geo_country_ison_label',
			'rules' => 'trim'
		),             
		array(
			'field' => 'Internet',
			'label' => 'lang:geo_country_internetcode_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'Capital',
			'label' => 'lang:geo_country_capital_label',
			'rules' => 'trim'
		),             
		array(
			'field' => 'MapReference',
			'label' => 'lang:geo_continent_label',
			'rules' => 'trim|required'
		),             
		array(
			'field' => 'Currency',
			'label' => 'lang:geo_country_currency_label',
			'rules' => 'trim'
		),        
		array(
			'field' => 'CurrencyCode',
			'label' => 'lang:geo_country_currencycode_label',
			'rules' => 'trim'
		),   
		array(
			'field' => 'PhoneCode',
			'label' => 'lang:geo_country_phonecode_label',
			'rules' => 'trim'
		),            
		array(
			'field' => 'Population',
			'label' => 'lang:geo_country_population_label',
			'rules' => 'trim'
		),   
		array(
			'field' => 'Latitude',
			'label' => 'lang:geo_country_latitude_label',
			'rules' => 'trim'
		), 
		array(
			'field' => 'Longitude',
			'label' => 'lang:geo_country_longitude_label',
			'rules' => 'trim'
		),             
           
	);
        
	protected $validation_rules_ajax = array(
		array(
			'field' => 'Country',
			'label' => 'lang:geo_country_label',
			'rules' => 'trim|required|max_length[50]'
		),
		array(
			'field' => 'MapReference',
			'label' => 'lang:geo_continent_label',
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
                
		$this->load->model(array('geo_countries_m','geo_regions_m'));
		$this->lang->load(array('geoworldmap','webservices'));		
		$this->load->library(array('form_validation'));
                //webservices library            
                $this->load->library('webservices');
                //listado para combo continentes
		if ($continents = $this->geo_countries_m->get_all_continents())
		{                
                    foreach ($continents as $cont)
                    {
                            $this->data->continents[trim($cont->MapReference)] = trim($cont->MapReference);
                    }                    
                }
	}
        
        /**
	 * Show all countries
	 * @access public
	 * @return void
	 */
	public function index()
	{
                $base_where = array('continent'=>'');            
		//add post values to base_where if f_module is posted
		$base_where = $this->input->post('f_continent') ? $base_where + array('continent' => $this->input->post('f_continent')) : $base_where;

		$base_where = $this->input->post('f_keywords') ? $base_where + array('keywords' => $this->input->post('f_keywords')) : $base_where;

		// Create pagination links
		$total_rows = $this->geo_countries_m->count_all();
		$pagination = create_pagination('admin/geoworldmap/countries/index', $total_rows, NULL, 5);
                
		// Using this data, get the relevant results
		$countries = $this->geo_countries_m->limit($pagination['limit'])->get_many_by($base_where);

		//do we need to unset the layout because the request is ajax?
		$this->input->is_ajax_request() ? $this->template->set_layout(FALSE) : '';

		$this->template
			->title($this->module_details['name'])
			->append_js('admin/filter.js')
			->set('pagination', $pagination)
			->set('countries', $countries);

		$this->input->is_ajax_request() ? $this->template->build('admin/tables/countries', $this->data) : $this->template->build('admin/countries/index', $this->data);

	}
        
      	/**
	 * method to fetch filtered results for blog list
	 * @access public
	 * @return void
	 */
	public function ajax_filter()
	{
		$post_data = array();
                //captura post
                if($this->input->post('f_continent') && $this->input->post('f_continent')!='0')
                {
                    $post_data['continent'] = $this->input->post('f_continent');   
                }
                if($this->input->post('f_keywords') && $this->input->post('f_keywords')!='')
                {
                    $post_data['keywords'] = $this->input->post('f_keywords');                      
                }                                              	
                //pagination
                $total_rows = $this->geo_countries_m->search('counts',$post_data);
                $pagination = create_pagination('admin/geoworldmap/countries/ajax_filter', $total_rows, NULL, 5);                
                //query with limits
                $results = $this->geo_countries_m->limit($pagination['limit'])->search('results',$post_data);
                        
		//set the layout to false and load the view
		$this->template
			->set_layout(FALSE)
			->set('pagination', $pagination)                       
			->set('countries', $results)
			->build('admin/tables/countries');
                        
	}
        
	/**
	 * Preview country post
	 * @access public
	 * @param int $id the ID of the blog post to preview
	 * @return void
	 */
	public function preview($id = 0)
	{
                // DB query
                $country = $this->geo_countries_m->get_by($id);
                // set template
		$this->template
				->set_layout('modal', 'admin')
                ->append_css('workless.css')                        
				->set('country', $country)
				->build('admin/countries/preview');                         
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
                        
			$id = $this->geo_countries_m->insert(array(
				'Country'				=> $this->input->post('Country'),
				'FIPS104'				=> $this->input->post('FIPS104'),
				'ISO2'                                  => $this->input->post('ISO2'),
				'ISO3'                                  => $this->input->post('ISO3'),
				'ISON'                                  => $this->input->post('ISON'),                            
				'Internet'				=> $this->input->post('Internet'),
				'Capital'				=> $this->input->post('Capital'),
				'MapReference'				=> $this->input->post('MapReference'),                                
                                'Currency'                              => $this->input->post('Currency'),
                                'CurrencyCode'                          => $this->input->post('CurrencyCode'),
                                'Population'                            => $this->input->post('Population')!='' ? str_replace('.','',strval($this->input->post('Population'))) : '',
                                'Latitude'                              => $this->input->post('Latitude'),
                                'Longitude'                             => $this->input->post('Longitude'),
                                'PhoneCode'                             => $this->input->post('PhoneCode')                                
			));
			if ($id)
			{
				$this->pyrocache->delete_all('geoworldmap_m');
				$this->session->set_flashdata('success', sprintf($this->lang->line('geo_country_add_success'), $this->input->post('Country')));
			}
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('geo_country_add_error'), $this->input->post('Country'));
			}

			// Redirect back to the form or main page
			$this->input->post('btnAction') == 'save_exit' ? redirect('admin/geoworldmap/countries') : redirect('admin/geoworldmap/countries/edit/' . $id);
		}
		else
		{
			// Go through all the known fields and get the post values
			foreach ($this->validation_rules as $key => $field)
			{
                            $country->$field['field'] = set_value($field['field']);
			}
		}
                
		$this->input->is_ajax_request() ? $this->template->set_layout(FALSE) : '';                
                        
		$this->template
			->title($this->module_details['name'], lang('geo_country_create_title'))
			->append_js('admin/filter.js')                                                   
			->append_js('module::ws_country_autocomplete.js')                        
			->set('country', $country)
		    ->build('admin/countries/form', $this->data);
                
	}  
        
         /**
	 * Create new country
	 * @access public
	 * @return void
	 */
	public function create_ajax()
	{
                $this->form_validation->set_rules($this->validation_rules_ajax);            
                // Go through all the known fields and get the post values
                foreach ($this->validation_rules_ajax as $key => $field)
                {
                    $country->$field['field'] = set_value($field['field']);
                }                 
		
		$this->data->method = 'create';
		$this->data->country = $country;                
		if ($this->form_validation->run())
		{
			$id = $this->geo_countries_m->insert_ajax(array(
				'Country'				=> $this->input->post('Country'),
				'MapReference'				=> $this->input->post('MapReference'),                              
				'FIPS104'				=> '',
				'ISO2'                                  => '',
				'ISO3'                                  => '',
				'ISON'                                  => '',                            
				'Internet'				=> '',
//				'Capital'				=> $this->input->post('Capital'),                              
//                                'Currency'                              => $this->input->post('Currency'),
//                                'CurrencyCode'                          => $this->input->post('CurrencyCode'),
//                                'Population'                            => str_replace('.','',strval($this->input->post('Population'))),
                                'Latitude'                              => '',
                                'Longitude'                             => ''
			));
			
			if ($id > 0)
			{
				$message = sprintf( lang('geo_country_add_success'), $this->input->post('Country'));
			}
			else
			{
				$message = lang('geo_country_add_error');
			}

			return $this->template->build_json(array(
				'message'		=> $message,
				'Country'		=> $this->input->post('Country'),
				'CountryID'	        => $id,
				'status'		=> 'ok'
			));
		}	
		else
		{
			// Render the view
			$form = $this->load->view('admin/countries/form_ajax', $this->data, TRUE);
                                                
			if ($errors = validation_errors())
			{
				return  $this->template->build_json(array(
					'message'	=> $errors,
					'status'	=> 'error',
					'form'		=> $form
				));
			}else
                            {
                               echo $form;
                            }
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
		$id OR redirect('admin/geoworldmap/countries');

		$country = $this->geo_countries_m->get_by($id);
		$this->form_validation->set_rules($this->validation_rules);		
		if ($this->form_validation->run())
		{

			$result = $this->geo_countries_m->update($id, array(
				'Country'				=> $this->input->post('Country'),
				'FIPS104'				=> $this->input->post('FIPS104'),
				'ISO2'                                  => $this->input->post('ISO2'),
				'ISO3'                                  => $this->input->post('ISO3'),
				'ISON'                                  => $this->input->post('ISON'),                            
				'Internet'				=> $this->input->post('Internet'),
				'Capital'				=> $this->input->post('Capital'),
				'MapReference'				=> $this->input->post('MapReference'),                                
                                'Currency'                              => $this->input->post('Currency'),
                                'CurrencyCode'                          => $this->input->post('CurrencyCode'),
                                'Population'                            => str_replace('.','',strval($this->input->post('Population'))),
                                'Latitude'                              => $this->input->post('Latitude'),
                                'Longitude'                             => $this->input->post('Longitude'),
                                'PhoneCode'                             => $this->input->post('PhoneCode')    
			));                           		
			if ($result)
			{
				$this->session->set_flashdata(array('success' => sprintf(lang('geo_country_edit_success'), $this->input->post('Country'))));
			}			
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('geo_country_edit_error'), $this->input->post('Country'));
			}

			// Redirect back to the form or main page
			$this->input->post('btnAction') == 'save_exit' ? redirect('admin/geoworldmap/countries') : redirect('admin/geoworldmap/countries/edit/'.$id);
		}

		// Go through all the known fields and get the post values
		foreach ($this->validation_rules as $key => $field)
		{
			if ($this->input->post($field['field']))
			{
				$country->$field['field'] = set_value($field['field']);
			}
		}
		$this->template
			->title($this->module_details['name'], lang('geo_country_create_title'))
			->append_js('admin/filter.js')                                                   
			->append_js('module::ws_country_autocomplete.js')                        
			->set('country', $country)
		        ->build('admin/countries/form', $this->data);                                                             
           
	}        
        
// WEBSERVICE  #################   
        
	/**
	 * Show all cities returns by webservice query
	 * @access public
	 * @return obj json
	 */
	public function webservice_goog_geocode_ajax()
	{            
            if($this->input->post('Country'))
            {
                $params['country'] = $this->input->post('Country');
            }else
                {
                   $params['country'] = '';
                }                            
           // check al values not empty 
           if(empty($params['country']))
           {                    
               $goog_ws->status = 'parameter missing';
               $goog_ws = json_encode($goog_ws);
           }else
               {
                    $goog_ws = $this->webservices->googleapis_geocode($params);
               }
            
            // ajax response   
            echo $goog_ws; 

	}

	public function webservice_geonames_countryinfo_ajax()
	{            
            $params['Latitude'] = $this->input->post('Latitude') ? $this->input->post('Latitude') : '';
            $params['Longitude'] = $this->input->post('Longitude') ? $this->input->post('Longitude') : '';            
                           
           // check al values not empty 
           if(empty($params['Latitude']) || empty($params['Longitude']))
           {                    
               $geonames_ws->status = 'parameter missing';
               $geonames_ws = json_encode($geonames_ws);
           }else
               {
                    $geonames_ws->status = 'OK';               
                    $obj = json_decode($this->webservices->geonames_countryinfo_by_lat_long($params['Latitude'],$params['Longitude']));
                    $xml = $this->webservices->geonames_countryinfo_by_countrycode($obj->countryCode);
                    //convierte XML a objeto
                    $xml  = simplexml_load_string($xml);
                    // añade puntos a population
                    $xml->country->population = number_format(intval($xml->country->population), '0', ',', '.');
                    // asigna objeto XML a objeto a enviar
                    $geonames_ws->obj = $xml;    
                    //convert OBJ to ajax for respond
                    $geonames_ws = json_encode($geonames_ws);
               }
            
            // ajax response   
            echo $geonames_ws; 

	}         
        
}

/* End of file XXX.php */
/* Location: ./application/controllers/XXX.php */
