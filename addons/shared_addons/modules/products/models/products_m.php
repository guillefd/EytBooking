<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Products_m extends MY_Model {

	protected $_table = 'products';

	function get_all()
	{
		$this->db->select('products.*, products_categories.title AS category_title, products_categories.slug AS category_slug, profiles.display_name')
			->join('products_categories', 'products.category_id = products_categories.id', 'left')
			->join('profiles', 'profiles.user_id = products.author_id', 'left');

		$this->db->order_by('created_on', 'DESC');

		return $this->db->get('products')->result();
	}

	function get($id)
	{
		return $this->db->select('products.*, profiles.display_name')
					->join('profiles', 'profiles.user_id = products.author_id', 'left')
					->where(array('products.product_id' => $id))
					->get('products')
					->row();
	}
	
	public function get_by($key, $value = '')
	{
		$this->db->select('products.*, profiles.display_name')
			->join('profiles', 'profiles.user_id = products.author_id', 'left');
			
		if (is_array($key))
		{
			$this->db->where($key);
		}
		else
		{
			$this->db->where($key, $value);
		}

		return $this->db->get($this->_table)->row();
	}

	function get_many_by($params = array())
	{
		$this->load->helper('date');

		if (!empty($params['category']))
		{
			if (is_numeric($params['category']))
				$this->db->where('products_categories.id', $params['category']);
			else
				$this->db->where('products_categories.slug', $params['category']);
		}

		if (!empty($params['month']))
		{
			$this->db->where('MONTH(FROM_UNIXTIME(created_on))', $params['month']);
		}

		if (!empty($params['year']))
		{
			$this->db->where('YEAR(FROM_UNIXTIME(created_on))', $params['year']);
		}

		// Is a status set?
		if (!empty($params['status']))
		{
			// If it's all, then show whatever the status
			if ($params['status'] != 'all')
			{
				// Otherwise, show only the specific status
				$this->db->where('status', $params['status']);
			}
		}

		// Nothing mentioned, show live only (general frontend stuff)
		else
		{
			$this->db->where('status', 'live');
		}

		// By default, dont show future posts
		if (!isset($params['show_future']) || (isset($params['show_future']) && $params['show_future'] == FALSE))
		{
			$this->db->where('created_on <=', now());
		}

		// Limit the results based on 1 number or 2 (2nd is offset)
		if (isset($params['limit']) && is_array($params['limit']))
			$this->db->limit($params['limit'][0], $params['limit'][1]);
		elseif (isset($params['limit']))
			$this->db->limit($params['limit']);

		return $this->get_all();
	}
	


	function count_by($params = array())
	{
		$this->db->join('products_categories', 'products.category_id = products_categories.id', 'left');

		if (!empty($params['category']))
		{
			if (is_numeric($params['category']))
				$this->db->where('products_categories.id', $params['category']);
			else
				$this->db->where('products_categories.slug', $params['category']);
		}

		if (!empty($params['month']))
		{
			$this->db->where('MONTH(FROM_UNIXTIME(created_on))', $params['month']);
		}

		if (!empty($params['year']))
		{
			$this->db->where('YEAR(FROM_UNIXTIME(created_on))', $params['year']);
		}

		// Is a status set?
		if (!empty($params['status']))
		{
			// If it's all, then show whatever the status
			if ($params['status'] != 'all')
			{
				// Otherwise, show only the specific status
				$this->db->where('status', $params['status']);
			}
		}

		// Nothing mentioned, show live only (general frontend stuff)
		else
		{
			$this->db->where('status', 'live');
		}

		return $this->db->count_all_results('products');
	}

	function update($id, $input)
	{
		$input['updated_on'] = now();

		return parent::update($id, $input);
	}

	function publish($id = 0)
	{
		return parent::update($id, array('status' => 'live'));
	}


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



}