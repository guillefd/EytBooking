<?php defined('BASEPATH') OR exit('No direct script access allowed');



//:::::::::::::: QUERY SAME TABLE :::::::::::::::::::::::::::::::::::::

function get_location_name_by_id($id=0)
{
	$loc = '';
	if($id!=0)
	{
		ci()->load->library('locations');
		$loc = ci()->locations->get_by_id($id);		
	}
	return $loc->name;
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
		ci()->load->library('spaces');
		$sp = ci()->spaces->get_by_id($id);		
	}
	return $sp->location_id;
}


function get_account_by_spaceID($id=0, $field = '')
{
	$acc = '';
	if($id!=0 && $field!='')
	{
		ci()->load->library('spaces');
		$acc = ci()->spaces->get_account_by_spaceid($id);		
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
