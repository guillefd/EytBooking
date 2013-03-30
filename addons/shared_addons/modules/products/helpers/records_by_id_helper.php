<?php defined('BASEPATH') OR exit('No direct script access allowed');



//:::::::::::::: QUERY SAME TABLE :::::::::::::::::::::::::::::::::::::

function get_location_name_by_id($id=0)
{
	$loc->name = '';
	if($id!=0)
	{
		ci()->load->library('products');
		$loc = ci()->products->get_location($id);		
	}
	return $loc->name;
}

function get_space_name_by_id($id=0)
{
	$loc->name = '';
	if($id!=0)
	{
		ci()->load->library('products');
		$loc = ci()->products->get_space_by_id($id);		
	}
	return $loc->name;
}

function get_account_by_id($id=0, $field = '', $active = 1)
{
	$acc = '';
	if($id!=0 && $field!='')
	{
		ci()->load->library('products');
		$acc = ci()->products->get_account($id, $active);		
	}
	return $acc->{$field};
}

function get_category_name_byid($id=0)
{
	$cat = '';
	if($id!=0)
	{
		$cat = ci()->categories->get_by_id($id);
		$cat = ci()->categories->explode_string_to_array($cat->title);
		$cat = ci()->categories->extract_value_by_language($cat);
	}
	return $cat;
}


//:::::::::::::: QUERY 2 or more tables :::::::::::::::::::::::::::::::::::::

function get_locationID_by_spaceID($id=0)
{
	$sp = '';
	if($id!=0)
	{
		ci()->load->library('products');
		$sp = ci()->products->get_space_by_id($id);		
	}
	return $sp->location_id;
}


function get_account_by_spaceID($id=0, $field = '')
{
	$acc = '';
	if($id!=0 && $field!='')
	{
		ci()->load->library('products');
		$acc = ci()->products->get_account_by_spaceid($id);		
	}
	return $acc->{$field};
}


function get_statusText_by_status_id($id='')
{
	$stat = '';
	if($id!='')
	{
		switch($id)
		{
			case 0: 
					return lang('products_inactive');
					break;
			case 1: 
					return lang('products_active');
					break;
			default: return $id;					
		}
	}
	return $stat;
}



function get_enableText_by_id($id='')
{
	$text = '';
	if($id!='')
	{
		switch($id)
		{
			case 0: 
					return lang('products_disabled_label');
					break;
			case 1: 
					return lang('products_enabled_label');
					break;
			default: return $id;					
		}
	}
	return $text;
}