<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * @package  	PyroCMS
 * @subpackage  Products
 * @category  	Module
 */
class Admin extends Admin_Controller
{
	/**
	 * The current active section
	 * @access protected
	 * @var string
	 */
	protected $section = 'products';

	/**
	 * The constructor
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('products_m'));
        $this->load->helper(array('string', 'date','records_by_id', 'products','products_dropdown'));                
		$this->lang->load(array('products', 'categories', 'locations','features','spaces'));
		$this->load->library(array('form_validation','features_categories', 'usageunit', 'product_type','categories', 'files/files','dropzone'));            
		$this->data->hours = array_combine($hours = range(0, 23), $hours);
		$this->data->minutes = array_combine($minutes = range(0, 59), $minutes);
        $this->template->append_css('module::products.css')
                       ->prepend_metadata('<script>var IMG_PATH = "'.BASE_URL.SHARED_ADDONPATH.'modules/'.$this->module.'/img/"; </script>');                                     
// DEBUG ::::::::::::::::::::::::::::::::::::::::::::::
        //$this->output->enable_profiler(TRUE);
// DEBUG ::::::::::::::::::::::::::::::::::::::::::::::        
	}
        
    /**
	 * Show all created products posts
	 * @access public
	 * @return void
	 */
	public function index($page=0)
	{
		// Create pagination links
		$total_rows = $this->products_m->search('counts');
        //params (URL -for links-, Total records, records per page, segmnet number )
		$pagination = create_pagination('admin/products/index', $total_rows, 5, 4);
        $post_data['pagination'] = $pagination;                
        //query with limits
        $products = $this->products_m->search('results',$post_data);  
		$this->data = gen_filter_dropdowns(); 
		$this->template
			 ->title($this->module_details['name'])
			 ->append_js('module::products_filter.js')
             ->append_css('module::jquery/jquery.autocomplete.css')     			 
			 ->set('pagination', $pagination)
			 ->set('products', $products)
			 ->build('admin/products/index', $this->data);
	}

	/**
	 * Create new post
	 * @access public
	 * @return void
	 */
	public function create()
	{
		$validation_rules = validation_rules(); 
		$this->form_validation->set_rules( $validation_rules );
		if ($this->form_validation->run())
		{			
			// BEGIN TRANSACTION :::::::::::::::::::::::::::::::::::::
			$this->db->trans_start();
			$product_id = $this->products_m->insert(array(
									'category_id'       => $this->input->post('category_id'),
									'account_id'        => $this->input->post('account_id'),
									'outsourced'        => $this->input->post('chk_seller_account'),
									'seller_account_id' => convert_empty_value_to_zero($this->input->post('seller_account_id')),
									'location_id'       => convert_empty_value_to_zero($this->input->post('location_id')),
									'space_id'          => convert_empty_value_to_zero($this->input->post('space_id')),
									'name'				=> $this->input->post('name'),
									'slug'				=> $this->input->post('slug').'_'.gen_url_addon_code(),
									'intro'				=> $this->input->post('intro'),
									'body'				=> $this->input->post('body'),
									'active'			=> $this->input->post('status'),
									'created_on'        => now(),
									'author_id'			=> $this->current_user->id
			));		
			if($product_id)
			{
				$features_field_list = array('product_id','default_feature_id','description','value','is_optional');
				$features_array = array();
				$features_array = generate_features_array_from_json( $features_field_list, $this->input->post('features'), $product_id );
			}
			if ($this->products_m->insert_features($features_array))
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('products_post_add_success'), $this->input->post('title')));
			}
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('products_post_add_error'));
			}
			$this->db->trans_complete();
			// END TRANSACTION :::::::::::::::::::::::::::::::::::::			
			// Redirect back to the form or main page
			$this->input->post('btnAction') == 'save_exit' ? redirect('admin/products') : redirect('admin/products/edit/' . $id);
		}
		else
		{
			// Go through all the known fields and get the post values
			foreach ($validation_rules as $key => $field)
			{
				$product->$field['field'] = set_value($field['field']);
			}
		}               
        $this->data = gen_dropdown_list(); 

       	//load path for Dropzones assets
	    $this->dropzone->loadAssetPath();
		
		$this->template
			->title($this->module_details['name'], lang('products_create_title'))     	
			->append_css('module::jquery/jquery.tagsinput.css')
            ->append_css('module::jquery/jquery.autocomplete.css')
            ->append_css('dropzoneCSS::dropzone.css')
			->append_js('module::jquery/jquery.tagsinput.js')
            ->append_js('module::jquery/jquery.mask.min.js')                        
			->append_js('module::products_form.js')
            ->append_js('module::products_form_features.js')
        	->append_js('dropzoneJS::dropzone.min.js')
        	->append_js('dropzoneJS::main.js')
			->set('product', $product)
			->set('dzForm', $this->dropzone->dzFormMarkup('admin/products/filetempupload_ajax'))
			->build('admin/products/form',$this->data);
	}

	/**
	 * Edit products
	 *
	 * @access public
	 * @param int $id the ID of the products post to edit
	 * @return void
	 */
	public function edit($id = 0)
	{
		$id OR redirect('admin/products');
		//first entry, populate human readable values		
		if(!$this->input->post())
		{
		    $product = $this->products_m->get($id);
		    if($product)
		    {
				$features_array = $this->products_m->get_all_features_by_id($id);
				convert_and_populate_id_fields_to_text($product, $features_array);
			}
			else
				{
					$this->session->set_flashdata(array('error' => sprintf(lang('products_edit_error_noexist'), $id)));
					redirect('admin/products');
				}	
		}
		$validation_rules = validation_rules(); 
		$this->form_validation->set_rules( $validation_rules );
		if ($this->form_validation->run())
		{
			// BEGIN TRANSACTION :::::::::::::::::::::::::::::::::::::
			$this->db->trans_start();
			$result = $this->products_m->update_product($id, array(
									'category_id'       => $this->input->post('category_id'),
									'account_id'        => $this->input->post('account_id'),
									'outsourced'        => $this->input->post('chk_seller_account'),
									'seller_account_id' => convert_empty_value_to_zero($this->input->post('seller_account_id')),
									'location_id'       => convert_empty_value_to_zero($this->input->post('location_id')),
									'space_id'          => convert_empty_value_to_zero($this->input->post('space_id')),
									'name'				=> $this->input->post('name'),
									'slug'				=> $this->input->post('slug').'_'.gen_url_addon_code(),
									'intro'				=> $this->input->post('intro'),
									'body'				=> $this->input->post('body'),
									'active'			=> $this->input->post('status'),
									'updated_on'        => now(),
			));			
			if ($result && $this->products_m->delete_products_features($id) )
			{
				$features_field_list = array('product_id','default_feature_id','description','value','is_optional');
				$features_array = array();
				$features_array = generate_features_array_from_json( $features_field_list, $this->input->post('features'), $id );
				if ($this->products_m->insert_features($features_array))
				{
					$this->session->set_flashdata(array('success' => sprintf(lang('products_edit_success'), $this->input->post('name'))));
				}
				else
				{
					$this->session->set_flashdata('error', $this->lang->line('products_edit_error'));
				}		
			}			
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('products_edit_error'));
			}
			$this->db->trans_complete();
			// END TRANSACTION :::::::::::::::::::::::::::::::::::::			
			// Redirect back to the form or main page
			$this->input->post('btnAction') == 'save_exit' ? redirect('admin/products') : redirect('admin/products/edit/' . $id);
		}
		// Go through all the known fields and get the post values
		foreach ($validation_rules as $key => $field)
		{
			if (isset($_POST[$field['field']]))
			{				
				$product->$field['field'] = set_value($field['field']);
			}
		}
		$this->data = gen_dropdown_list();    
		$this->template
			->title($this->module_details['name'], lang('products_create_title'))
			->append_js('module::jquery/jquery.tagsinput.js')
            ->append_js('module::jquery/jquery.mask.min.js')                        
			->append_js('module::products_form.js')
            ->append_js('module::products_form_features.js')
			->append_css('module::jquery/jquery.tagsinput.css')
            ->append_css('module::jquery/jquery.autocomplete.css')                         
			->set('product', $product)
			->build('admin/products/form',$this->data);
	}


	public function view($id = 0)
	{	    
	    if( $product = $this->products_m->get($id) )
	    {
			$features_array = $this->products_m->get_all_features_by_id($id);
			convert_and_populate_id_fields_to_text($product, $features_array);
		}
		else
			{
				$this->session->set_flashdata(array('error' => sprintf(lang('products_error_noexist'), $id)));
				redirect('admin/products');
			}
		$this->template
			->title($this->module_details['name'], lang('products_create_title'))                                     
			->set('product', $product)
			->set('features', $features_array)
			->set('dd_yes_no', gen_dd_yes_no())
			->build('admin/products/view',$this->data);				
	}


	public function delete($id = 0)
	{		
		if( $product = $this->products_m->get($id) )
		{
			if($this->products_m->delete_product($id))
			{
				$this->session->set_flashdata(array('success' => sprintf(lang('products_delete_success'), $product->name)));			
			}	
			else
				{
					$this->session->set_flashdata(array('error' => sprintf(lang('products_delete_error'), $product->name)));				
				}
			redirect('admin/products');	
		}
		$this->session->set_flashdata(array('error' => sprintf(lang('products_error_noexist'), $id)));		
		redirect('admin/products');
	}


	public function undelete($id = 0)
	{		
		if( $product = $this->products_m->get($id,1) )
		{
			if($this->products_m->undelete_product($id))
			{
				$this->session->set_flashdata(array('success' => sprintf(lang('products_undelete_success'), $product->name)));			
			}	
			else
				{
					$this->session->set_flashdata(array('error' => sprintf(lang('products_undelete_error'), $product->name)));				
				}
			redirect('admin/products');	
		}
		$this->session->set_flashdata(array('error' => sprintf(lang('products_error_noexist'), $id)));		
		redirect('admin/products');
	}

	/**
	 * Helper method to determine what to do with selected items from form post
	 * @access public
	 * @return void
	 */
	public function action()
	{
		switch ($this->input->post('btnAction'))
		{
			case 'publish':
				role_or_die('products', 'put_live');
				$this->publish();
				break;
			
			case 'delete':
				role_or_die('products', 'delete_live');
				$this->delete();
				break;
			
			default:
				redirect('admin/products');
				break;
		}
	}


// AUX _ VALIDATIONS

	public function _check_seller_account_option()
	{
		if( $this->input->post('chk_seller_account')==1 )
		{
			if( !$this->input->post('seller_account_id') )
			{
				$this->form_validation->set_message('_check_seller_account_option', sprintf(lang('products_seller_account_not_selected'), lang('products_seller_account_label')));
				return false;
			}
		}
		return true;
	}

	public function _check_features($features)
	{
		$vecF = array();
		$vecF_result = array();
		$vecF = json_decode($features);
		if(is_array($vecF))
		{
			foreach($vecF as $vec)
			{
				if(!empty($vec))
				{
					array_push($vecF_result,$vec);
				}
			}
		}
		if(empty($vecF_result))
		{
			$this->form_validation->set_message('_check_features', sprintf(lang('products_features_submit_error'), lang('products_features_label')));
			return false;
		}
		else
			{
				return true;
			}	
	}

        /**
	 * method to fetch filtered results for products list
	 * @access public
	 * @return void
	 */
	public function ajax_filter()
	{
                //captura post
                $post_data = array();  
                if($this->input->post('f_keywords'))
                {    
                    $post_data['keywords'] = $this->input->post('f_keywords');
                }                 
                if($this->input->post('f_account_id'))
                {
                    $post_data['account_id'] = $this->input->post('f_account_id');                  
                }                                
                if($this->input->post('f_category_id') && $this->input->post('f_category_id')!='')
                {
                    $post_data['category_id'] = $this->input->post('f_category_id');                  
                }                                   
                if( ($this->input->post('f_status') || $this->input->post('f_status')==0) && $this->input->post('f_status')!='')
                {
                    $post_data['active'] = $this->input->post('f_status');              
                }                
                if( ($this->input->post('f_deleted') || $this->input->post('f_deleted')==0) && $this->input->post('f_deleted')!='')
                {
                    $post_data['deleted'] = $this->input->post('f_deleted');              
                } 
                //pagination
                $total_rows = $this->products_m->search('counts',$post_data);
                //params (URL -for links-, Total records, records per page, segmnet number )
				$pagination = create_pagination('admin/products/index', $total_rows, 10, 4);
                $post_data['pagination'] = $pagination;                
                //query with limits
                $products = $this->products_m->search('results',$post_data);                                         
				//set the layout to false and load the view
                $this->input->is_ajax_request() ? $this->template->set_layout(FALSE) : '';                 
				$this->template
								->title($this->module_details['name'])
								->set('products', $products)
								->set('pagination', $pagination)                        
		                        ->append_js('module::locations_index.js')
		                        ->append_css('module::jquery/jquery.autocomplete.css')
		                        ->build('admin/products/tables/products', $this->data);
	}


	public function filetemp_upload()
	{
		$tempfolderid = $this->check_temp_folder();
		echo json_encode( Files::upload($tempfolderid) );
	}	

    /**
     * [check_temp_folder description]
     * @return [type] [description]
     */
	public function check_temp_folder()
	{
		$tempfoldername = 'Temp';
		$tree = Files::folder_tree();
		$notfound = true;
		$i = 0;
		while($notfound && $i <= count($tree) )
		{
			if( $tree[$i-1]['name'] == $tempfoldername )
			{
				$notfound = false;
				$tempfolderid = $tree[$i-1]['id'];
			}	
			$i++;
		}
		if($notfound)
		{
			$result = Files::create_folder(0, $tempfoldername );
			$tempfolderid = $result['data']['id'];	
		}
		return $tempfolderid;
	}

}
