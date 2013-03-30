<?php defined('BASEPATH') OR exit('No direct script access allowed');

//:::::::::: VALIDATION ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

function validation_rules()
{	
	return array(       
					array(
						'field' => 'category_id',
						'label' => 'lang:products_category_label',
						'rules' => 'trim|numeric|required'
					),
					array(
						'field' => 'account',
						'label' => 'lang:products_account_label',
						'rules' => 'trim'
					),             
					array(
						'field' => 'account_id',
						'label' => 'lang:products_account_label',
						'rules' => 'trim|numeric|required'
					), 
					array(
						'field' => 'seller_account',
						'label' => 'lang:products_account_label',
						'rules' => 'trim'
					), 
					array(
						'field' => 'chk_seller_account',
						'label' => 'lang:products_chk_seller_account_label',
						'rules' => 'trim'
					), 										
					array(
						'field' => 'seller_account_id',
						'label' => 'lang:products_account_label',
						'rules' => 'trim|numeric|callback__check_seller_account_option'
					), 					          
					array(
						'field' => 'location_id',
						'label' => 'lang:products_location_label',
						'rules' => 'trim|numeric'
					),                        
					array(
						'field' => 'space_id',
						'label' => 'lang:products_location_label',
						'rules' => 'trim|numeric'
					),               
			                array(
						'field' => 'name',
						'label' => 'lang:products_title_label',
						'rules' => 'trim|htmlspecialchars|required|max_length[100]'
					),
					array(
						'field' => 'slug',
						'label' => 'lang:products_slug_label',
						'rules' => 'trim|required|alpha_dot_dash|max_length[100]'
					),
					array(
						'field' => 'intro',
						'label' => 'lang:products_intro_label',
						'rules' => 'trim'
					),
					array(
						'field' => 'body',
						'label' => 'lang:products_content_label',
						'rules' => 'trim|required'
					),
					array(
						'field' => 'status',
						'label' => 'lang:products_status_label',
						'rules' => 'trim|numeric'
					),
					array(
						'field' => 'features',
						'label' => 'lang:products_features_label',
						'rules' => 'trim|required|callback__check_features'
					),            
				);	
}


//:::::::::: AUX ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

/**
 * Generate dropdown array list from libraries 
 */
function gen_dropdown_list() 
{
    $data->cat_features_array = ci()->features_categories->gen_dd_array();
    $data->usageunit_array = ci()->usageunit->gen_dd_array();
    $data->type_array = ci()->product_type->gen_dd_array();
    $data->cat_products_array = ci()->categories->gen_dd_multiarray();
    $data->dd_yes_no  = gen_dd_yes_no();
    $data->features_array = array();
    return $data;
}   


function gen_filter_dropdowns() 
{
    $data->type_array = ci()->product_type->gen_dd_array();
    $data->cat_products_array = ci()->categories->gen_dd_multiarray();
    $data->dd_yes_no  = gen_dd_yes_no_filter();
    $data->dd_status = gen_dd_status();
    return $data;
}


function convert_empty_value_to_zero($var)
{
	return empty($var) ? 0 : $var;
}


function generate_features_array_from_json($fields, $dataJson, $product_id)
{
	$array = array();
	if($dataArray = json_decode($dataJson) )
	{	
		foreach ($dataArray as $reg) 
		{
			if (!empty($reg)) 
			{
				$array[] = array( $fields[0]=>$product_id,
								  $fields[1]=>$reg->default_f_id,
								  $fields[2]=>$reg->description,
								  $fields[3]=>$reg->value,
								  $fields[4]=>$reg->isOptional
								);
			}
		}
	}
	return $array;
}


function generate_features_json_from_array($features_array)
{
	$data = array();
	if( !empty($features_array) )
	{	
		$obj = new stdClass;
		$i=0;
		foreach ($features_array as $feature) 
		{
			$obj->default_f_id = $feature->default_feature_id;
			$obj->name = $feature->name;
			$obj->description = $feature->description;
			$obj->usageunit = convert_usageunitid_to_text($feature->usageunit);
			$obj->value = $feature->value;
			$obj->isOptional = $feature->is_optional;
			$obj->vecFid = '';
			$obj->n = $i;
			$i++;
			$data[] = $obj;
		}
	}
	return json_encode($data);
}


function convert_usageunitid_to_text($string)
{
	ci()->load->library('usageunit');
	$vec = ci()->usageunit->split_name_lang($string);
	return ci()->usageunit->extract_value_by_language($vec);
}

/**
 * [gen_url_addon_code codigo 'unico' para agregar a URL del producto]
 * @return [type] [description]
 */
function gen_url_addon_code()
{
	ci()->config->load('product');
	$start = ci()->config->item('product_unix_starttime_point');
	return now() - $start;
}


function convert_and_populate_id_fields_to_text($product, $features_array)
{
	if(is_object($product) && !empty($product))
	{
		$product->account = get_account_by_id($product->account_id,'name');
		$product->chk_seller_account = $product->outsourced;
		$product->seller_account = $product->seller_account_id!=0 ? get_account_by_id($product->seller_account_id,'name') : '';
		$product->status = $product->active;
		$product->features = generate_features_json_from_array($features_array);
		$product->slug = extract_addon_code_url($product->slug);
	}
}

function extract_addon_code_url($string)
{
	$sub = strrchr($string, '_');
	return str_replace($sub, '', $string);
}

//:::::::::: AJAX ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

