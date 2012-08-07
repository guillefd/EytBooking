<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Accounts extends Module {

	public $version = '0.9';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Accounts',
                                'es' => 'Cuentas'
			),
			'description' => array(
				'en' => 'Accounts customers and providers + contacts',
				'es' => 'Cuentas de proveedores y clientes + contactos'                            
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'ERP', // You can also place modules in their top level menu. For example try: 'menu' => 'Sample',
			'sections' => array(
				'accounts' => array(
					'name' 	=> 'accounts:accounts',
					'uri' 	=> 'admin/accounts',
                                        'shortcuts' => array(
							'create' => array(
								'name' 	=> 'accounts:create',
								'uri' 	=> 'admin/accounts/create',
								'class' => 'add'
								)
							)
						),
				'contacts' => array(
					'name' 	=> 'accounts:contacts',
					'uri' 	=> 'admin/accounts/contacts',
                                        'shortcuts' => array(
							'create' => array(
								'name' 	=> 'accounts:create_contact',
								'uri' 	=> 'admin/accounts/contacts/create',
								'class' => 'add'
								)
							)
						)
				)                                  
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('accounts');
		$this->db->delete('settings', array('module' => 'accounts'));

		$accounts = array(
                        'account_id' => array(
                                        'type' => 'INT',
                                        'constraint' => '11',
                                        'auto_increment' => TRUE
                                        ),
                        'name' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '100'
                                        ),
                        'account_type' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '100',
                                        'default' => ''
                                        ),
                        'industry' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '100',
                                        'default' => ''
                                        ),                    
                        'address_l1' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '100',
                                        'default' => ''
                                        ),
                        'address_l2' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '100',
                                        'default' => ''
                                        ),                    
                        'area' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '100',
                                        'default' => ''
                                        ),                 
                        'CityID' => array(
                                        'type' => 'INT',
                                        'constraint' => '11'
                                        ),                 
                        'zipcode' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '50',
                                        'default' => ''
                                        ),                 
                        'Latitude' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '100',
                                        'default' => ''
                                        ),                    
                        'Longitude' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '100',
                                        'default' => ''
                                        ),                    
                        'latlng_precision' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '100',
                                        'default' => ''
                                        ),                    
                        'phone_area_code' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '10',
                                        'default' => ''
                                        ),                    
                        'phone' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '100',
                                        'default' => ''
                                        ),                    
                        'fax' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '100',
                                        'default' => ''
                                        ),  
                        'email' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '150',
                                        'default' => ''
                                        ),     
                        'razon_social' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '150',
                                        'default' => ''
                                        ), 
                        'cuit' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '150',
                                        'default' => ''
                                        ), 
                        'iva' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '150',
                                        'default' => ''
                                        ), 
                        'iibb' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '150',
                                        'default' => ''
                                        ),                     
                        'pago_proveedores_mail' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '100',
                                        'default' => ''
                                        ),    
                        'pago_proveedores_tel' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '100',
                                        'default' => ''
                                        ),   
                        'pago_proveedores_dias_horarios' => array(
                                        'type' => 'TEXT'
                                        ), 
                        'pago_proveedores_forma_de_pago' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '100',
                                        'default' => '',
                                        ),                                         
                        'pago_proveedores_detalle' => array(
                                        'type' => 'TEXT'
                                        ),               
                        'cuentas_por_cobrar_mail' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '100',
                                        'default' => ''
                                        ),      
                        'cuentas_por_cobrar_tel' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '100',
                                        'default' => ''
                                        ),     
                        'cuentas_por_cobrar_detalle' => array(
                                        'type' => 'TEXT'
                                        ),               
                        'author_id' => array(
                                        'type' => 'INT',
                                        'constraint' => '11',
                                        'default' => 0
                                        ),                 
                        'created_on' => array(
                                        'type' => 'INT',
                                        'constraint' => '11'
                                        ), 
                        'updated_on' => array(
                                        'type' => 'INT',
                                        'constraint' => '11',
                                        'default' => 0
                                        ),
                            'active' => array(
                                            'type' => 'TINYINT',
                                            'constraint' => '4',
                                            'default' => 1
                                            ),                     
                        );

		$accounts_setting = array(
			'slug' => 'accounts_setting',
			'title' => 'Accounts Setting',
			'description' => 'A Yes or No option for the Accounts module',
			'`default`' => '1',
			'`value`' => '1',
			'type' => 'select',
			'`options`' => '1=Yes|0=No',
			'is_required' => 1,
			'is_gui' => 1,
			'module' => 'Accounts'
		);

		$this->dbforge->add_field($accounts);
		$this->dbforge->add_key('account_id', TRUE);

		if($this->dbforge->create_table('accounts') AND
		   $this->db->insert('settings', $accounts_setting) AND
		   is_dir($this->upload_path.'accounts') OR @mkdir($this->upload_path.'accounts',0777,TRUE))
		{                                
                    $this->dbforge->drop_table('accounts_contacts');
                    $accounts_contacts = array(
                            'contact_id' => array(
                                            'type' => 'INT',
                                            'constraint' => '11',
                                            'auto_increment' => TRUE
                                            ),
                            'name' => array(
                                            'type' => 'VARCHAR',
                                            'constraint' => '100'
                                            ),
                            'surname' => array(
                                            'type' => 'VARCHAR',
                                            'constraint' => '100'
                                            ),                    
                            'account_id' => array(
                                            'type' => 'VARCHAR',
                                            'constraint' => '100',
                                            'default' => ''
                                            ),  
                            'section' => array(
                                            'type' => 'VARCHAR',
                                            'constraint' => '100'
                                            ),
                            'title' => array(
                                            'type' => 'VARCHAR',
                                            'constraint' => '100'
                                            ),
                            'position' => array(
                                            'type' => 'VARCHAR',
                                            'constraint' => '100'
                                            ),                    
                            'address_l1' => array(
                                            'type' => 'VARCHAR',
                                            'constraint' => '100',
                                            'default' => ''
                                            ),
                            'address_l2' => array(
                                            'type' => 'VARCHAR',
                                            'constraint' => '100',
                                            'default' => ''
                                            ),                    
                            'area' => array(
                                            'type' => 'VARCHAR',
                                            'constraint' => '100',
                                            'default' => ''
                                            ),                 
                            'CityID' => array(
                                            'type' => 'INT',
                                            'constraint' => '11'
                                            ),                 
                            'zipcode' => array(
                                            'type' => 'VARCHAR',
                                            'constraint' => '50',
                                            'default' => ''
                                            ),                 
                            'Latitude' => array(
                                            'type' => 'VARCHAR',
                                            'constraint' => '100',
                                            'default' => ''
                                            ),                    
                            'Longitude' => array(
                                            'type' => 'VARCHAR',
                                            'constraint' => '100',
                                            'default' => ''
                                            ),                    
                            'latlng_precision' => array(
                                            'type' => 'VARCHAR',
                                            'constraint' => '100',
                                            'default' => ''
                                            ),                    
                            'phone_area_code' => array(
                                            'type' => 'VARCHAR',
                                            'constraint' => '10',
                                            'default' => ''
                                            ),                    
                            'phone' => array(
                                            'type' => 'VARCHAR',
                                            'constraint' => '100',
                                            'default' => ''
                                            ),                    
                            'fax' => array(
                                            'type' => 'VARCHAR',
                                            'constraint' => '100',
                                            'default' => ''
                                            ),  
                            'email' => array(
                                            'type' => 'VARCHAR',
                                            'constraint' => '150',
                                            'default' => ''
                                            ),     
                            'author_id' => array(
                                            'type' => 'INT',
                                            'constraint' => '11',
                                            'default' => 0
                                            ),                 
                            'created_on' => array(
                                            'type' => 'INT',
                                            'constraint' => '11'
                                            ), 
                            'updated_on' => array(
                                            'type' => 'INT',
                                            'constraint' => '11',
                                            'default' => 0
                                            ),                     
                            'active' => array(
                                            'type' => 'TINYINT',
                                            'constraint' => '4',
                                            'default' => 1
                                            ),                         
                            );
                    $this->dbforge->add_field($accounts_contacts);
                    $this->dbforge->add_key('contact_id', TRUE);

                    if($this->dbforge->create_table('accounts_contacts') AND
                    is_dir($this->upload_path.'accounts_contacts') OR @mkdir($this->upload_path.'accounts_contacts',0777,TRUE))
                    {
                            return TRUE;
                    }
		}                    
                
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('accounts');
		$this->dbforge->drop_table('accounts_contacts');                
		$this->db->delete('settings', array('module' => 'accounts'));
		{
			return TRUE;
		}
	}


	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
	}
}
/* End of file details.php */
