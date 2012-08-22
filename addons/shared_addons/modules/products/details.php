<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Products extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
                        'name'        => array
                                         (
                                          'en' => 'Products',
                                          'es' => 'Productos'
                                         ),
			'description' => array
                                         (
                                          'en' => 'Product Manager',
                                          'es' => 'Administrador de Productos'
                                         ),
			'frontend'	=> TRUE,
			'backend'	=> TRUE,
			'skip_xss'	=> TRUE,
			'menu'		=> 'ERP',                   
			'roles' => array(
                                          'put_live', 'edit_live', 'delete_live'
                                        ),			
			'sections' => array
                                      (
                                      'products' => array
                                                    (
                                                    'name' => 'products_list',
                                                    'uri' => 'admin/products',
                                                    'shortcuts' => array
                                                                   (
                                                                    array
                                                                        (
                                                                        'name' => 'products_create_title',
                                                                        'uri' => 'admin/products/create',
                                                                        'class' => 'add'
                                                                         ),
                                                                   ),
                                                    ),                        
                                      'spaces' => array
                                                      (
                                                       'name' => 'spaces:list',
                                                       'uri' => 'admin/products/spaces',
                                                       'shortcuts' => array
                                                                      (
                                                                        array
                                                                            (
                                                                            'name' => 'spaces:create_title',
                                                                            'uri' => 'admin/products/spaces/create',
                                                                            'class' => 'add'
                                                                            ),
                                                                        ),
                                                        ),                            
                                      'locations' => array
                                                      (
                                                       'name' => 'location:list',
                                                       'uri' => 'admin/products/locations',
                                                       'shortcuts' => array
                                                                      (
                                                                        array
                                                                            (
                                                                            'name' => 'location:create_title',
                                                                            'uri' => 'admin/products/locations/create',
                                                                            'class' => 'add'
                                                                            ),
                                                                        ),
                                                        ),
                                      'categories' => array
                                                      (
                                                       'name' => 'cat_list_title',
                                                       'uri' => 'admin/products/categories',
                                                       'shortcuts' => array
                                                                      (
                                                                        array
                                                                            (
                                                                            'name' => 'cat_create_title',
                                                                            'uri' => 'admin/products/categories/create',
                                                                            'class' => 'add'
                                                                            ),
                                                                        ),
                                                        ),                            
                                      'features' => array
                                                      (
                                                       'name' => 'features:list_title',
                                                       'uri' => 'admin/products/features',
                                                       'shortcuts' => array
                                                                      (
                                                                        array
                                                                            (
                                                                            'name' => 'features:create_title',
                                                                            'uri' => 'admin/products/features/create',
                                                                            'class' => 'add'
                                                                            ),
                                                                        ),
                                                        ),                             
                                      ),
                            );
	}

	public function install()
	{
		$this->dbforge->drop_table('products');
                $this->dbforge->drop_table('products_categories');
		$this->dbforge->drop_table('products_locations');                
		$this->dbforge->drop_table('products_spaces');                 
		$this->dbforge->drop_table('products_files');
                $this->dbforge->drop_table('products_files_folders');               
		$this->dbforge->drop_table('products_listprice');                
		$this->dbforge->drop_table('products_currency');                
		$this->dbforge->drop_table('products_usageunit');                
		$this->dbforge->drop_table('products_taxtype');                
                $this->dbforge->drop_table('products_spaces_shapes');                  
                $this->dbforge->drop_table('products_spaces_layouts');                  
                $this->dbforge->drop_table('products_spaces_facilities');                                  
		$this->dbforge->drop_table('products_spaces_denominations');                
		$this->dbforge->drop_table('products_features_category');                
		$this->dbforge->drop_table('products_features_defaults');                
		$this->dbforge->drop_table('products_features');                

		$products_categories = "
			CREATE TABLE " . $this->db->dbprefix('products_categories') . " (
			  `id` int(11) NOT NULL auto_increment,
			  `slug` varchar(100) collate utf8_unicode_ci NOT NULL default '',
			  `title` varchar(100) collate utf8_unicode_ci NOT NULL default '',
			  `description` text collate utf8_unicode_ci NOT NULL,
			  PRIMARY KEY  (`id`),
			  UNIQUE KEY `slug - unique` (`slug`),
			  UNIQUE KEY `title - unique` (`title`),
			  KEY `slug - normal` (`slug`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Products Categories.';
		";

		$products = "
			CREATE TABLE " . $this->db->dbprefix('products') . " (
			  `id` int(11) NOT NULL auto_increment,
			  `title` varchar(100) collate utf8_unicode_ci NOT NULL default '',
			  `slug` varchar(100) collate utf8_unicode_ci NOT NULL default '',
			  `category_id` int(11) NOT NULL,
			  `location_id` int(11) NOT NULL default '0',                     
			  `attachment` varchar(255) collate utf8_unicode_ci NOT NULL default '',
			  `thumbnail` varchar(255) collate utf8_unicode_ci NOT NULL default '',                          
			  `intro` text collate utf8_unicode_ci NOT NULL,
			  `body` text collate utf8_unicode_ci NOT NULL,
			  `parsed` text collate utf8_unicode_ci NOT NULL,
			  `keywords` varchar(32) NOT NULL default '',                       
			  `author_id` int(11) NOT NULL default '0',
			  `created_on` int(11) NOT NULL,
			  `updated_on` int(11) NOT NULL default 0,
                          `comments_enabled` INT(1)  NOT NULL default '1',
			  `status` enum('draft','live') collate utf8_unicode_ci NOT NULL default 'draft',
			  `type` set('html','markdown','wysiwyg-advanced','wysiwyg-simple') collate utf8_unicode_ci NOT NULL,
			  PRIMARY KEY  (`id`),
			  UNIQUE KEY `title` (`title`),
			  KEY `category_id - normal` (`category_id`),
			  KEY `location_id - normal` (`location_id`)                          
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Products';
		";

		$products_locations = "
			CREATE TABLE " . $this->db->dbprefix('products_locations') . " (
			  `id` int(11) NOT NULL auto_increment,
			  `account_id` int(11) NOT NULL default '0',   
			  `name` varchar(100) collate utf8_unicode_ci NOT NULL default '',
			  `slug` varchar(100) collate utf8_unicode_ci NOT NULL default '',
                          `intro` text collate utf8_unicode_ci NOT NULL,
			  `description` text collate utf8_unicode_ci NOT NULL,               
			  `address_l1` varchar(150) collate utf8_unicode_ci NOT NULL default '',
			  `address_l2` varchar(150) collate utf8_unicode_ci NOT NULL default '',                          
			  `area` varchar(100) collate utf8_unicode_ci NOT NULL default '',                                                   
			  `CityID` int(11) NOT NULL default '0',                                                                                 
			  `zipcode` varchar(20) collate utf8_unicode_ci NOT NULL default '',                                                    
			  `Latitude` varchar(30) collate utf8_unicode_ci NOT NULL default '',                          
			  `Longitude` varchar(30) collate utf8_unicode_ci NOT NULL default '',                          
			  `latlng_precision` varchar(30) collate utf8_unicode_ci NOT NULL default '',                                                    
			  `phone_area_code` varchar(20) collate utf8_unicode_ci NOT NULL default '',
			  `phone` varchar(100) collate utf8_unicode_ci NOT NULL default '',                          
			  `fax` varchar(100) collate utf8_unicode_ci NOT NULL default '',                                                    
			  `mobile` varchar(100) collate utf8_unicode_ci NOT NULL default '',                                                    
			  `email` varchar(100) collate utf8_unicode_ci NOT NULL default '',                                                                              
			  `chatSocial_accounts` text collate utf8_unicode_ci NOT NULL,                                                    
			  `author_id` int(11) NOT NULL default '0',
			  `created_on` int(11) NOT NULL,
			  `updated_on` int(11) NOT NULL default 0,
			  `type` set('html','markdown','wysiwyg-advanced','wysiwyg-simple') collate utf8_unicode_ci NOT NULL,
			  `active` tinyint NOT NULL default '1',                          
			  PRIMARY KEY  (`id`),
			  UNIQUE KEY `name` (`name`),
			  KEY `account_id - normal` (`account_id`),
			  KEY `CityID - normal` (`CityID`)                          
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Products Locations.';
		";    
                
		$products_spaces = "
			CREATE TABLE " . $this->db->dbprefix('products_spaces') . " (
			  `space_id` int(11) NOT NULL auto_increment,
			  `location_id` int(11) NOT NULL default '0',                        
                          `denomination_id` tinyint NOT NULL default '0', 
			  `name` varchar(100) collate utf8_unicode_ci NOT NULL default '',
			  `description` text collate utf8_unicode_ci NOT NULL,               
			  `level` varchar(100) collate utf8_unicode_ci NOT NULL default '',                                                   
			  `width` varchar(20) collate utf8_unicode_ci NOT NULL default '',                      
			  `height` varchar(20) collate utf8_unicode_ci NOT NULL default '',
			  `length` varchar(20) collate utf8_unicode_ci NOT NULL default '',                          
			  `square_mt` varchar(20) collate utf8_unicode_ci NOT NULL default '',                           
			  `shape_id` tinyint NOT NULL default '0', 
			  `layouts` text collate utf8_unicode_ci NOT NULL, 
			  `facilities` text collate utf8_unicode_ci NOT NULL, 
			  `author_id` int(11) NOT NULL default '0',
			  `created_on` int(11) NOT NULL,
			  `updated_on` int(11) NOT NULL default 0,                          
			  `active` tinyint NOT NULL default '1',                          
			  PRIMARY KEY  (`space_id`),
			  KEY `account_id - normal` (`location_id`)                     
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Locations spaces.';
		";                

		$products_files = "
			CREATE TABLE " . $this->db->dbprefix('products_files') . " (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `product_id` int(11) NOT NULL,                             
			  `folder_id` int(11) NOT NULL DEFAULT '0',
			  `user_id` int(11) NOT NULL DEFAULT '1',
			  `type` enum('a','v','d','i','o') COLLATE utf8_unicode_ci DEFAULT NULL,
			  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `extension` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
			  `mimetype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `width` int(5) DEFAULT NULL,
			  `height` int(5) DEFAULT NULL,
			  `filesize` int(11) NOT NULL DEFAULT 0,
			  `date_added` int(11) NOT NULL DEFAULT 0,
			  `sort` int(11) NOT NULL DEFAULT 0,
			  PRIMARY KEY (`id`),
			  KEY `product_id - normal` (`product_id`)                            
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";

		$products_files_folders = "
			CREATE TABLE " . $this->db->dbprefix('products_files_folders') . " (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `parent_id` int(11) DEFAULT '0',
			  `slug` varchar(100) NOT NULL,
			  `name` varchar(50) NOT NULL,
			  `date_added` int(11) NOT NULL,
			  `sort` int(11) NOT NULL DEFAULT 0,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		"; 

		$products_listprice = "
			CREATE TABLE " . $this->db->dbprefix('products_listprice') . " (
			  `id` int(11) NOT NULL auto_increment,
			  `product_id` int(11) NOT NULL,                          
			  `title` varchar(100) collate utf8_unicode_ci NOT NULL default '',
			  `intro` text collate utf8_unicode_ci NOT NULL,
			  `unit_price` decimal(25,2) NOT NULL default '0.00',
			  `taxtype_id` int(11) NOT NULL,                           
			  `tax` decimal(3,2) NOT NULL default '0.00',
			  `currency_id` int(11) NOT NULL default 0,                            
			  `usageunit_id` int(11) NOT NULL default 0,  
			  `type` enum('main','optional') collate utf8_unicode_ci NOT NULL default 'main',
			  `author_id` int(11) NOT NULL default 0,
			  `created_on` int(11) NOT NULL,
			  `updated_on` int(11) NOT NULL default 0,
			  PRIMARY KEY  (`id`),
			  UNIQUE KEY `title` (`title`),
			  KEY `product_id - normal` (`product_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Products list Price';
		"; 

		$products_currency = "
			CREATE TABLE " . $this->db->dbprefix('products_currency') . " (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(50) NOT NULL,
			  `code` varchar(20) NOT NULL,                          
			  `symbol` varchar(5) NOT NULL,                          
			  `conversion_rate` decimal(25,2) NOT NULL default '0.00',                          
			  `status` enum('active','inactive') collate utf8_unicode_ci NOT NULL default 'active',
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";                 

		$products_usageunit = "
			CREATE TABLE " . $this->db->dbprefix('products_usageunit') . " (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(50) NOT NULL,                      
			  `symbol` varchar(5) NOT NULL,                          
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";

		$products_taxtype = "
			CREATE TABLE " . $this->db->dbprefix('products_taxtype') . " (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(100) NOT NULL,                      
			  `symbol` varchar(10) NOT NULL,  
			  `tax` double NOT NULL default '0.00',                      
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";                   

		$products_features_categories = "
			CREATE TABLE " . $this->db->dbprefix('products_features_categories') . " (
			  `id` int(11) NOT NULL auto_increment,
			  `name` varchar(100) collate utf8_unicode_ci NOT NULL default '',                     
			  `description` text collate utf8_unicode_ci NOT NULL,
			  PRIMARY KEY  (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Products Features Categories.';
		";   

                $products_spaces_denominations = "
			CREATE TABLE " . $this->db->dbprefix('products_spaces_denominations') . " (
			  `id` int(11) NOT NULL auto_increment,
			  `name` varchar(100) collate utf8_unicode_ci NOT NULL default '',                     
			  `description` text collate utf8_unicode_ci NOT NULL,
			  PRIMARY KEY  (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Products Spaces Denominations.';
		"; 
                
                $products_spaces_shapes = "
			CREATE TABLE " . $this->db->dbprefix('products_spaces_shapes') . " (
			  `id` int(11) NOT NULL auto_increment,
			  `name` varchar(100) collate utf8_unicode_ci NOT NULL default '',                     
			  `description` text collate utf8_unicode_ci NOT NULL,
			  PRIMARY KEY  (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Products Spaces Shapes.';
		";                 
                
                $products_spaces_layouts = "
			CREATE TABLE " . $this->db->dbprefix('products_spaces_layouts') . " (
			  `id` int(11) NOT NULL auto_increment,
			  `name` varchar(100) collate utf8_unicode_ci NOT NULL default '',                     
			  `description` text collate utf8_unicode_ci NOT NULL,
			  PRIMARY KEY  (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Products Spaces Layouts.';
		";                 

                $products_spaces_facilities = "
			CREATE TABLE " . $this->db->dbprefix('products_spaces_facilities') . " (
			  `id` int(11) NOT NULL auto_increment,
			  `category` varchar(100) collate utf8_unicode_ci NOT NULL default '',                                               
			  `name` varchar(100) collate utf8_unicode_ci NOT NULL default '',                     
			  `description` text collate utf8_unicode_ci NOT NULL,
                          `value` varchar(100) collate utf8_unicode_ci NOT NULL default '',
			  PRIMARY KEY  (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Products Spaces Layouts.';
		";                 

		$products_features_defaults = "
			CREATE TABLE " . $this->db->dbprefix('products_features_defaults') . " (
			  `id` int(11) NOT NULL auto_increment,
			  `cat_feature_id` int(11) NOT NULL,                           
			  `cat_product_id` int(11) NOT NULL,                                                     
			  `name` varchar(100) collate utf8_unicode_ci NOT NULL default '',
			  `description` text collate utf8_unicode_ci NOT NULL,
                          `usageunit_id` int(11) NOT NULL,                                                     
                          `value` decimal(20,2) NOT NULL default '0.00',                                                      
                          `group` varchar(100) collate utf8_unicode_ci NOT NULL default '',                          
			  PRIMARY KEY  (`id`),
			  KEY `group - normal` (`group`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Products Features Defaults.';
		";                   

		$products_features = "
			CREATE TABLE " . $this->db->dbprefix('products_features') . " (
			  `id` int(11) NOT NULL auto_increment,
			  `product_id` int(11) NOT NULL,                           
			  `cat_feature_id` int(11) NOT NULL,                           
			  `name` varchar(100) collate utf8_unicode_ci NOT NULL default '',
			  `description` text collate utf8_unicode_ci NOT NULL,
                          `usageunit_id` int(11) NOT NULL,                            
                          `value` decimal(20,2) NOT NULL default '0.00',                            
                          `group` varchar(100) collate utf8_unicode_ci NOT NULL default '',                                                    
			  PRIMARY KEY  (`id`),
			  KEY `product_id - normal` (`product_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Products Features';
		";                    
                
		if ($this->db->query($products_categories) 
                        && $this->db->query($products) 
                        && $this->db->query($products_spaces)                         
                        && $this->db->query($products_locations) 
                        && $this->db->query($products_files)
                        && $this->db->query($products_files_folders)                        
                        && $this->db->query($products_listprice)
                        && $this->db->query($products_currency)
                        && $this->db->query($products_usageunit)
                        && $this->db->query($products_taxtype)
                        && $this->db->query($products_spaces_shapes)
                        && $this->db->query($products_spaces_layouts)                        
                        && $this->db->query($products_spaces_facilities)                        
                        && $this->db->query($products_spaces_denominations)                        
                        && $this->db->query($products_features_categories)
                        && $this->db->query($products_features_defaults)
                        && $this->db->query($products_features)
                        )
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
            $this->dbforge->drop_table('products');
            $this->dbforge->drop_table('products_categories');
            $this->dbforge->drop_table('products_locations');
            $this->dbforge->drop_table('products_spaces');
            $this->dbforge->drop_table('products_files');
            $this->dbforge->drop_table('products_files_folders');
            $this->dbforge->drop_table('products_listprice');
            $this->dbforge->drop_table('products_currency');
            $this->dbforge->drop_table('products_usageunit');
            $this->dbforge->drop_table('products_taxtype');
            $this->dbforge->drop_table('products_spaces_shapes');
            $this->dbforge->drop_table('products_spaces_layouts');     
            $this->dbforge->drop_table('products_spaces_facilities');     
            $this->dbforge->drop_table('products_spaces_denominations');            
            $this->dbforge->drop_table('products_features_categories');
            $this->dbforge->drop_table('products_features_defaults');
            $this->dbforge->drop_table('products_features');                                   
            $this->db->delete('settings', array('module' => 'products'));
            // Put a check in to see if something failed, otherwise it worked
            return TRUE;
	}

	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		/**
		 * Either return a string containing help info
		 * return "Some help info";
		 *
		 * Or add a language/help_lang.php file and
		 * return TRUE;
		 *
		 * help_lang.php contents
		 * $lang['help_body'] = "Some help info";
		*/
		return TRUE;
	}
}

/* End of file details.php */