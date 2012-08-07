<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Products extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('products_m');
		$this->load->model('products_categories_m');
		$this->load->model('comments/comments_m');
		$this->load->library(array('keywords/keywords'));
		$this->lang->load('products');
	}

	// products/page/x also routes here
	public function index()
	{
		$this->data->pagination = create_pagination('products/page', $this->products_m->count_by(array('status' => 'live')), NULL, 3);
		$this->data->products = $this->products_m->limit($this->data->pagination['limit'])->get_many_by(array('status' => 'live'));

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($this->data->products);
		
		foreach ($this->data->products AS &$post)
		{
			$post->keywords = Keywords::get_links($post->keywords, 'products/tagged');
		}

		$this->template
			->title($this->module_details['name'])
			->set_breadcrumb( lang('products_products_title'))
			->set_metadata('description', $meta['description'])
			->set_metadata('keywords', $meta['keywords'])
			->build('index', $this->data);
	}

	public function category($slug = '')
	{
		$slug OR redirect('products');

		// Get category data
		$category = $this->products_categories_m->get_by('slug', $slug) OR show_404();

		// Count total products posts and work out how many pages exist
		$pagination = create_pagination('products/category/'.$slug, $this->products_m->count_by(array(
			'category'=> $slug,
			'status' => 'live'
		)), NULL, 4);

		// Get the current page of products posts
		$products = $this->products_m->limit($pagination['limit'])->get_many_by(array(
			'category'=> $slug,
			'status' => 'live'
		));

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($products);
		
		foreach ($products AS &$post)
		{
			$post->keywords = Keywords::get_links($post->keywords, 'products/tagged');
		}

		// Build the page
		$this->template->title($this->module_details['name'], $category->title )
			->set_metadata('description', $category->title.'. '.$meta['description'] )
			->set_metadata('keywords', $category->title )
			->set_breadcrumb( lang('products_products_title'), 'products')
			->set_breadcrumb( $category->title )
			->set('products', $products)
			->set('category', $category)
			->set('pagination', $pagination)
			->build('category', $this->data );
	}

	public function archive($year = NULL, $month = '01')
	{
		$year OR $year = date('Y');
		$month_date = new DateTime($year.'-'.$month.'-01');
		$this->data->pagination = create_pagination('products/archive/'.$year.'/'.$month, $this->products_m->count_by(array('year'=>$year,'month'=>$month)), NULL, 5);
		$this->data->products = $this->products_m->limit($this->data->pagination['limit'])->get_many_by(array('year'=> $year,'month'=> $month));
		$this->data->month_year = format_date($month_date->format('U'), lang('products_archive_date_format'));

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($this->data->products);
		
		foreach ($this->data->products AS &$post)
		{
			$post->keywords = Keywords::get_links($post->keywords, 'products/tagged');
		}

		$this->template->title( $this->data->month_year, $this->lang->line('products_archive_title'), $this->lang->line('products_products_title'))
			->set_metadata('description', $this->data->month_year.'. '.$meta['description'])
			->set_metadata('keywords', $this->data->month_year.', '.$meta['keywords'])
			->set_breadcrumb($this->lang->line('products_products_title'), 'products')
			->set_breadcrumb($this->lang->line('products_archive_title').': '.format_date($month_date->format('U'), lang('products_archive_date_format')))
			->build('archive', $this->data);
	}

	// Public: View a post
	public function view($slug = '')
	{
		if ( ! $slug or ! $post = $this->products_m->get_by('slug', $slug))
		{
			redirect('products');
		}

		if ($post->status != 'live' && ! $this->ion_auth->is_admin())
		{
			redirect('products');
		}
		
		// if it uses markdown then display the parsed version
		if ($post->type == 'markdown')
		{
			$post->body = $post->parsed;
		}

		// IF this post uses a category, grab it
		if ($post->category_id && ($category = $this->products_categories_m->get($post->category_id)))
		{
			$post->category = $category;
		}

		// Set some defaults
		else
		{
			$post->category->id		= 0;
			$post->category->slug	= '';
			$post->category->title	= '';
		}

		$this->session->set_flashdata(array('referrer' => $this->uri->uri_string));

		$this->template->title($post->title, lang('products_products_title'))
			->set_metadata('description', $post->intro)
			->set_metadata('keywords', implode(', ', Keywords::get_array($post->keywords)))
			->set_breadcrumb(lang('products_products_title'), 'products');

		if ($post->category->id > 0)
		{
			$this->template->set_breadcrumb($post->category->title, 'products/category/'.$post->category->slug);
		}
		
		$post->keywords = Keywords::get_links($post->keywords, 'products/tagged');

		$this->template
			->set_breadcrumb($post->title)
			->set('post', $post)
			->build('view', $this->data);
	}
	
	public function tagged($tag = '')
	{
		$tag OR redirect('products');

		// Count total products posts and work out how many pages exist
		$pagination = create_pagination('products/tagged/'.$tag, $this->products_m->count_tagged_by($tag, array(
			'status' => 'live'
		)), NULL, 4);

		// Get the current page of products posts
		$products = $this->products_m->limit($pagination['limit'])->get_tagged_by($tag, array(
			'status' => 'live'
		));
		
		foreach ($products AS &$post)
		{
			$post->keywords = Keywords::get_links($post->keywords, 'products/tagged');
		}

		// Set meta description based on post titles
		$meta = $this->_posts_metadata($products);
		
		$name = str_replace('-', ' ', $tag);

		// Build the page
		$this->template->title($this->module_details['name'], lang('products_tagged_label').': '.$name )
			->set_metadata('description', lang('products_tagged_label').': '.$name.'. '.$meta['description'] )
			->set_metadata('keywords', $name )
			->set_breadcrumb( lang('products_products_title'), 'products')
			->set_breadcrumb( lang('products_tagged_label').': '.$name )
			->set('products', $products)
			->set('tag', $tag)
			->set('pagination', $pagination)
			->build('tagged', $this->data );
	}

	// Private methods not used for display
	private function _posts_metadata(&$posts = array())
	{
		$keywords = array();
		$description = array();

		// Loop through posts and use titles for meta description
		if(!empty($posts))
		{
			foreach($posts as &$post)
			{
				if($post->category_title)
				{
					$keywords[$post->category_id] = $post->category_title .', '. $post->category_slug;
				}
				$description[] = $post->title;
			}
		}

		return array(
			'keywords' => implode(', ', $keywords),
			'description' => implode(', ', $description)
		);
	}
}
