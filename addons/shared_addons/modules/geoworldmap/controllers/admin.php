<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package  	PyroCMS
 * @subpackage  Categories
 * @category  	Module
 * @author  	PyroCMS Dev Team
 */
class Admin extends Admin_Controller {

	/**
	 * The current active section
	 * @access protected
	 * @var int
	 */
	protected $section = 'geoworldmap';
	
	/**
	 * Array that contains the validation rules
	 * @access protected
	 * @var array
	 */
	protected $validation_rules = array(
		array(
			'field' => 'City',
			'label' => 'lang:geo_city_label',
			'rules' => 'trim|required|max_length[50]'
		),
		array(
			'field' => 'CountryID',
			'label' => 'lang:geo_country_label',
			'rules' => 'trim|required|callback__check_valid_countryid'
		),  
		array(
			'field' => 'RegionID',
			'label' => 'lang:geo_region_label',
			'rules' => 'trim|required|callback__check_valid_regionid'
		),                
		array(
			'field' => 'Latitude',
			'label' => 'lang:geo_latitude_label',
			'rules' => 'trim'
		),                
		array(
			'field' => 'Longitude',
			'label' => 'lang:geo_longitude_label',
			'rules' => 'trim'
		),                
		array(
			'field' => 'timezoneid',
			'label' => 'lang:geo_timezoneid_label',
			'rules' => 'trim|required|callback__check_timezone'
		),                            
		array(
			'field' => 'gmt',
			'label' => 'lang:geo_gmt_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'PhoneCode',
			'label' => 'lang:geo_city_phonecode_label',
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
                
		$this->load->model(array('geo_cities_m','geo_countries_m','geo_regions_m'));
		$this->lang->load(array('geoworldmap','webservices'));		
		$this->load->library(array('form_validation'));
                //webservices library            
                $this->load->library('webservices');
                //listado para combo paises
		$this->data->countries = array();
		if ($countries = $this->geo_countries_m->get_all())
		{
			foreach ($countries as $country)
			{
				$this->data->countries[$country->CountryId] = $country->Country;
			}
		}
                //listado para combo timezones
		$this->data->timezones = array();
		if ($timezones = $this->geo_countries_m->timezones_get_all())
		{
			foreach ($timezones as $tz)
			{
				$this->data->timezones[$tz->timeZoneId] = $tz->timeZoneId.' '.$tz->GMT_offset;
			}
		}       
	}	      
        
	/**
	 * Show all created blog posts
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$base_where = array('country'=>'');
                //add post values to base_where if f_module is posted

                $base_where['country'] = $this->input->post('f_country') ? $this->input->post('f_country') : $base_where['country'];

                $base_where = $this->input->post('f_region') ? $base_where + array('region' => $this->input->post('f_region')) : $base_where; 
                
                if($this->input->post('f_region')){ 
                    if ($regions = $this->geo_regions_m->get_many_by($this->input->post('f_region')))
                    {
                            foreach ($regions as $region)
                            {
                                    $this->data->regions[$region->RegionID] = $region->Region;
                            }
                    }
                }else
                    {
                        $this->data->regions = array();
                    }

		$base_where = $this->input->post('f_keywords') ? $base_where + array('keywords' => $this->input->post('f_keywords')) : $base_where;

		// Create pagination links
		$total_rows = $this->geo_cities_m->count_all();                
		$pagination = create_pagination('admin/geoworldmap/index', $total_rows);

		// Using this data, get the relevant results
		$cities = $this->geo_cities_m->limit($pagination['limit'])->search($base_where);                 

		//do we need to unset the layout because the request is ajax?
		$this->input->is_ajax_request() ? $this->template->set_layout(FALSE) : '';

		$this->template
			->title($this->module_details['name'])
			->append_js('admin/filter.js')
			->set('pagination', $pagination)
			->set('cities', $cities);

		$this->input->is_ajax_request() ? $this->template->build('admin/tables/cities', $this->data) : $this->template->build('admin/index', $this->data);

	}
      
        
	/**
	 * Preview blog post
	 * @access public
	 * @param int $id the ID of the blog post to preview
	 * @return void
	 */
	public function preview($id = 0)
	{
                // DB query
                $city = $this->geo_cities_m->get_by($id);
                // set template
		$this->template
		->set_layout('modal', 'admin')
                ->append_css('module::workless.css')                        
		->set('city', $city)
		->build('admin/cities/preview');                         
	}        

	
	/**
	 * Create new city
	 * @access public
	 * @return void
	 */
	public function create()
	{
            $this->form_validation->set_rules($this->validation_rules);
            //check valor cero de CountryID, RegionID y timezoneid
            if($this->input->post('CountryID') =='0'){ $_POST['CountryID']='';  } 
            if($this->input->post('RegionID') =='0'){ $_POST['RegionID']='';  }             
            if($this->input->post('timezoneid') =='0'){ $_POST['timezoneid']='';  }               
		if ($this->form_validation->run())
		{
                        
			$id = $this->geo_cities_m->insert(array(
				'CountryID'				=> $this->input->post('CountryID'),
				'RegionID'				=> $this->input->post('RegionID'),
				'City'                                  => $this->input->post('City'),
				'Latitude'                              => $this->input->post('Latitude'),
				'Longitude'				=> $this->input->post('Longitude'),
				'timezoneid'				=> $this->input->post('timezoneid'),
				'gmt'				        => $this->input->post('timezoneid') ? $this->timezoneid_to_gmt($this->input->post('timezoneid')) : '',                                
				'PhoneCode'				=> $this->input->post('PhoneCode'),                            
			));
			if ($id)
			{
				$this->pyrocache->delete_all('geoworldmap_m');
				$this->session->set_flashdata('success', sprintf($this->lang->line('geo_city_add_success'), $this->input->post('City')));
			}
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('geo_city_add_error'));
			}

			// Redirect back to the form or main page
			$this->input->post('btnAction') == 'save_exit' ? redirect('admin/geoworldmap') : redirect('admin/geoworldmap/edit/' . $id);
		}
		else
		{
			// Go through all the known fields and get the post values
			foreach ($this->validation_rules as $key => $field)
			{                      
                                    $city->$field['field'] = set_value($field['field']);                                
			}
		}
                // if countryID get regions list
                if($this->input->post('CountryID'))
                {    
                    $regions = $this->input->post('CountryID') ? $this->geo_regions_m->get_many_by($this->input->post('CountryID')) : array();
			foreach ($regions as $region)
			{
				$this->data->regions[$region->RegionID] = $region->Region;
			}
                }else
                    {
                        $this->data->regions = array();
                    }           
                
		$this->template
			->title($this->module_details['name'], lang('geo_city_create_title'))
			->append_js('admin/filter.js')                        
			->append_js('module::geo_cities_form.js')                           
			->append_js('module::load_region.js')
			->append_js('module::ws_autocomplete.js')                        
			->set('city', $city)
		    ->build('admin/cities/form', $this->data);
                
	}
	
         /**
	 * Edit city	
	 * @access public
	 * @param int $id the ID of the city to edit
	 * @return void
	 */
	public function edit($id = 0)
	{
		$id OR redirect('admin/geoworldmap');

		$city = $this->geo_cities_m->get_by($id);
		$this->form_validation->set_rules($this->validation_rules);
                //check valor cero de CountryID, RegionID y timezoneid
                if($this->input->post('CountryID') =='0'){ $_POST['CountryID']='';  } 
                if($this->input->post('RegionID') =='0'){ $_POST['RegionID']='';  }             
                if($this->input->post('timezoneid') =='0'){ $_POST['timezoneid']='';  }                 
		if ($this->form_validation->run())
		{

			$result = $this->geo_cities_m->update($id, array(
				'CountryID'				=> $this->input->post('CountryID'),
				'RegionID'				=> $this->input->post('RegionID'),
				'City'                                  => $this->input->post('City'),
				'Latitude'                              => $this->input->post('Latitude'),
				'Longitude'				=> $this->input->post('Longitude'),
				'timezoneid'				=> $this->input->post('timezoneid'),
				'gmt'				        => $this->timezoneid_to_gmt($this->input->post('timezoneid')), 
				'PhoneCode'				=> $this->input->post('PhoneCode'),   
                                ));                           		
			if ($result)
			{
				$this->session->set_flashdata(array('success' => sprintf(lang('geo_city_edit_success'), $this->input->post('City'))));
			}			
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('geo_city_edit_error'));
			}

			// Redirect back to the form or main page
			$this->input->post('btnAction') == 'save_exit' ? redirect('admin/geoworldmap') : redirect('admin/geoworldmap/edit/'.$id);
		}

		// Go through all the known fields and get the post values
		foreach ($this->validation_rules as $key => $field)
		{
			if ($this->input->post($field['field']))
			{
				$city->$field['field'] = set_value($field['field']);
			}
		}
                // if countryID get regions list
                if($this->input->post('CountryID') || $city->CountryID)
                {    
                    $regions = $this->input->post('CountryID') ? $this->geo_regions_m->get_many_by($this->input->post('CountryID')) : $this->geo_regions_m->get_many_by($city->CountryID);
			foreach ($regions as $region)
			{
				$this->data->regions[$region->RegionID] = $region->Region;
			}
                }else
                    {
                        $this->data->regions = array();
                    }                      
                    
        	$this->template
			->title($this->module_details['name'], lang('geo_city_edit_title'))
			->append_js('module::filter.js')                        
			->append_js('module::geo_cities_form.js')                           
			->append_js('module::load_region.js')   
			->append_js('module::ws_autocomplete.js')                           
			->set('city', $city)
		        ->build('admin/cities/form', $this->data);                        
           
	}	        

	/**
	 * Create method, creates a new category via ajax
	 * @access public
	 * @return void
	 */
	public function create_ajax()
	{
		// Loop through each validation rule
		$this->form_validation->set_rules($this->validation_rules);            
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
				'category_id'	        => $id,
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
        
	/**
	 * Respond Lat and Long of city-region-country given to Google Maps API Geocode
         * Params POST city[string] RegionID[num] CountryID[num]
	 * @access public
	 * @return obj json
	 */
	public function webservice_city_geocode_ajax()
	{            
            $params['city'] = $this->input->post('City') ? $this->input->post('City') : '';
            if($this->input->post('RegionID'))
            {
                $region = $this->geo_regions_m->get_by($this->input->post('RegionID'));
                $params['region'] = $region->Region;
            }else
                {
                   $params['region'] = '';
                }
            if($this->input->post('CountryID'))
            {
                $Country = $this->geo_countries_m->get_by($this->input->post('CountryID'));
                $params['country'] = $Country->Country;
            }else
                {
                   $params['country'] = '';
                }                            
           // check al values not empty 
           if(empty($params['city']) || empty($params['region']) || empty($params['country']))
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
        
	/**
	 * Respond Lat and Long of address-city-region-country given to Google Maps API Geocode
         * Params POST address[string] + CityID[num]
	 * @access public
	 * @return obj json
	 */
	public function webservice_address_geocode_ajax()
	{            
            $params['address'] = $this->input->post('address') ? $this->input->post('address') : '';        
            if($this->input->post('cityid'))
            {
                $city = $this->geo_cities_m->get_by($this->input->post('cityid'));
                $params['city'] = $city->City;
                $params['region'] = $city->region;
                $params['country'] = $city->country;                
            }else
                {
                   $params['city'] = '';
                   $params['country'] = '';
                   $params['region'] = '';
                }                                        
           // check al values not empty 
           if(empty($params['address']) || empty($params['city']) || empty($params['region']) || empty($params['country']))
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

	public function webservice_geonames_timezone_ajax()
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
                    $geonames_ws->timezones = $this->geo_countries_m->timezones_get_all();
                    $geonames_ws->obj = json_decode($this->webservices->geonames_timezone_by_lat_long($params['Latitude'],$params['Longitude']));
                    //convert to ajax for respond
                    $geonames_ws = json_encode($geonames_ws);
               }
            
            // ajax response   
            echo $geonames_ws; 

	}      

       
	/**
	 * method to fetch filtered results for blog list
	 * @access public
	 * @return void
	 */
	public function ajax_filter()
	{
		//captura post
                $data->country = $this->input->post('f_country');
                $data->keywords = $this->input->post('f_keywords');                
                             
		$post_data = array('country'=>$data->country,'keywords'=>$data->keywords);
	
                //pagination
                $total_rows = $this->geo_cities_m->search('counts',$post_data);
                $pagination = create_pagination('admin/geoworldmap/ajax_filter', $total_rows);                
                //query with limits
                $results = $this->geo_cities_m->limit($pagination['limit'])->search('results',$post_data);
                        
		//set the layout to false and load the view
		$this->template
			->set_layout(FALSE)
			->set('pagination', $pagination)                       
			->set('cities', $results)
			->build('admin/tables/cities');
                        
	}

        public function load_regions_ajax()
        {
            if($this->input->post('CountryID') && $this->input->post('CountryID')!='0')
            {             
                $regions = $this->geo_regions_m->get_many_by($this->input->post('CountryID'));
            }
            else
                {
                    $regions[] = '';
                }
            echo(json_encode($regions));    
        }

        public function cities_autocomplete_ajax()
        {
            $respond->cities = array();
            $respond->count = 0;
            if($this->input->get('term'))
            {             
		if ($result = $this->geo_cities_m->get_ajax_like($this->input->get('term'),$this->input->get('limit')))
		{
			foreach ($result as $city)
			{
                            $respond->cities[] = array('city'=>$city->City, 'region'=>$city->region,'country'=>$city->country,'id'=>$city->CityId,'countryphonecode'=>$city->countryphonecode,'cityphonecode'=>$city->PhoneCode);                          
                            $respond->count++;
			}
		}                                   
            }
            
            echo json_encode($respond);    
        }           
        
// ------------------- Help functions        
        
	/**
	 * Callback method that checks the timezone
	 * @access public
	 * @param string timezone to check
	 * @return bool
	 */
	public function _check_timezone($timezone)                
	{
            if (empty($timezone))                
            {
                return TRUE;
            }
            else if(!$this->geo_countries_m->check_timezone($timezone))           
            {
                $this->form_validation->set_message('_check_timezone', sprintf(lang('geo_timezoneid_not_valid'), $timezone));
                return FALSE;
            }else
                {
                    return TRUE;
                }
	}
        
	/**
	 * Callback method that checks the timezone
	 * @access public
	 * @param string timezone to check
	 * @return bool
	 */
	public function _check_valid_countryid($id)
	{
            if ($id==='0' && is_numeric($id))
            {
                $this->form_validation->set_message('_check_valid_countryid', sprintf(lang('geo_countryid_not_valid'), $id));
                return FALSE;
            }
            return TRUE;
	}     
        
	public function _check_valid_regionid($id)
	{
            if ($id==='0' && is_numeric($id))
            {
                $this->form_validation->set_message('_check_valid_regionid', sprintf(lang('geo_regionid_not_valid'), $id));
                return FALSE;
            }
            return TRUE;
	}
        
        /**
         * convierte timezoneid timezone a gmt
         */
        public function timezoneid_to_gmt($tzid)
        {
            if($tzid && $tzid!='0'){
                if( $gmt = $this->geo_countries_m->check_timezone($tzid))
                {                
                    return $gmt->GMT_offset;
                }
            }else
                {
                    return FALSE;
                }
        }
        

        /**
         * convierte gmt timezone a timezoneid
         */
        public function gmt_to_timezoneid($gmt)
        {
            if( $tzid = $this->geo_countries_m->check_gmt($gmt))
            {                                 
                return $tzid->timeZoneId;
            }
        }

        
        /**
        * Webservice Type : REST 
        Url : api.geonames.org/timezone?
        Parameters : lat,lng, radius (buffer in km for closest timezone in coastal areas), date (date for sunrise/sunset);
        Result : the timezone at the lat/lng with gmt offset (1. January) and dst offset (1. July) 
        * @param type $lat
        * @param type $long
        * @return type array 
         */
        public function check_ws_geonames_timezone($lat,$lng,$is_ajax=FALSE)
        {
           if($is_ajax)
           {           
                echo $this->webservices->geonames_timezone_by_lat_long($lat,$lng);
           }else
               {
                    return json_decode($this->webservices->geonames_timezone_by_lat_long($lat,$lng));
               }
        }
        
// ::::::::::: API´s
        
        public function API_getCityByID($id)
        {
            return $this->geo_cities_m->get_by($id);
        }
                
}