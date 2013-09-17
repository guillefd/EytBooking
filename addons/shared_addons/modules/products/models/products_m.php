<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Products_m extends MY_Model {

// FEATURES :::::::::::::::::::::::::::::::::::::::::::

	public function __construct()
	{		
		parent::__construct();
		$this->t_products = 'products';
		$this->t_products_f = 'products_features';
		$this->t_products_f_defaults = 'products_features_defaults';
	}

	
	function insert_features($array)
	{
		return $this->db->insert_batch($this->t_products_f, $array); 
	}


	function get_all_features_by_id($product_id)
	{
		$this->db->select('products_features.*, pfd.name, pfd.usageunit_id, ui.name as usageunit')
		 		 ->join('products_features_defaults as pfd','products_features.default_feature_id = pfd.id')
		 		 ->join('products_usageunit as ui','pfd.usageunit_id = ui.id');
		$this->db->where('product_id', $product_id);
		$this->db->order_by('is_optional', 'ASC');
		return $this->db->get($this->t_products_f)->result();
	}	


	function delete_products_features($product_id)
	{
		return $this->db->delete('products_features', array('product_id' => $product_id)); 
	}	


// PRODUCT :::::::::::::::::::::::::::::::::::::::::::

	function get($id, $deleted = 0)
	{
		return $this->db->select('products.*, profiles.display_name')
					->join('profiles', 'profiles.user_id = products.author_id', 'left')
					->where(array('products.product_id' => $id))
					->where('deleted', $deleted)
					->get('products')
					->row();
	}


	function update_product($id, $data)
	{
		$this->db->where('product_id', $id);
		return $this->db->update('products', $data);		
	}	


	function delete_product($id)
	{
		$data = array('deleted'=>1);
		$this->db->where('product_id', $id);
		return $this->db->update('products', $data); 		
	}

	function undelete_product($id)
	{
		$data = array('deleted'=>0);
		$this->db->where('product_id', $id);
		return $this->db->update('products', $data); 		
	}


	function get_many_by($params = array())
	{
		// Limit the results based on 1 number or 2 (2nd is offset)
		if (isset($params['limit']) && is_array($params['limit']))
			$this->db->limit($params['limit'][0], $params['limit'][1]);
		elseif (isset($params['limit']))
			$this->db->limit($params['limit']);
		//only not deleted
		$this->db->where('deleted', 0);
		return $this->get_all();
	}
	


	function count_by($params = array())
	{
		$this->db->join('products_categories', 'products.category_id = products_categories.id', 'left');
		//only not deleted
		$this->db->where('deleted', 0);
		return $this->db->count_all_results('products');
	}


		/**
	 * Searches accounts posts based on supplied data array
	 * @param $data array
	 * @return array
	 */
	function search($mode,$data = array())
	{
	    $query = "SELECT * FROM (`default_".$this->t_products."`)";
            //deleted
            if (array_key_exists('deleted', $data) && $data['deleted']==1) 
            {
                $query.= ' WHERE (`deleted` = 0 OR `deleted` = 1)';                
            }
            else
            	{
            		$query.= ' WHERE `deleted` = 0';   
            	}	    
            if (array_key_exists('keywords', $data))
            {
                $query.= " AND (`name` LIKE '%".$data['keywords']."%')";
            }	    
            // Solo cuentas activas
            if (array_key_exists('active', $data) )
            {
                $query.= ' AND `active` = '.$data['active'];                
            }
            if (array_key_exists('account_id', $data) && $data['account_id']!=0)
            {
                $query.= ' AND `account_id` = '.$data['account_id'];
            }         
            if (array_key_exists('category_id', $data) && $data['category_id']!=0)
            {
                $query.= ' AND `category_id` = '.$data['category_id'];
            } 
            //Ordenar alfabeticamente
            $query.= " ORDER BY `name` ASC";            
            // Limit the results based on 1 number or 2 (2nd is offset)
            if (isset($data['pagination']['limit']) && is_array($data['pagination']['limit']))
            {
                    $query.= " LIMIT ".$data['pagination']['limit'][1].", ".$data['pagination']['limit'][0];
            }        
            elseif (isset($data['pagination']['limit']))
            {    
                    $query.= " LIMIT ".$data['pagination']['limit'];
            }        
            //fire query
            $q = $this->db->query($query);         
            if($mode =='counts')
            {                
                return $q->num_rows;
            }
            else
                {
                    return $q->result();
                }
	} 



// AUX ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

	function check_product_exists($field, $value = '', $id = 0)
	{
		$this->db->where(array($field => $value, 'product_id <>' =>$id));
		$q = $this->db->get('products');	
		if($q->num_rows()>0)
		{
			return false;
		}
		else
			{
				return true;
			}
	}


// FILES ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

	function move_product_file($fileid, $newfolderid)
	{
		$data = array('folder_id'=>$newfolderid);
		$this->db->where('id', $fileid);
		return $this->db->update('files', $data);
	}	



}