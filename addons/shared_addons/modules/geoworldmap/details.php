<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Geoworldmap extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
                        'name'        => array
                                         (
                                          'en' => 'GeoWorldMap',
                                          'es' => 'GeoWorldMap'
                                         ),
			'description' => array
                                         (
                                          'en' => 'Geo World Map: Countrys, Regions and Cities + Webservices',
                                          'es' => 'Geo World Map: Paises, Regiones, Ciudades + Webservices'
                                         ),
			'frontend'	=> FALSE,
			'backend'	=> TRUE,
			'skip_xss'	=> TRUE,
			'menu'		=> 'utilities',                   
			'roles' => array(
                                          'put_live', 'edit_live', 'delete_live'
                                        ),			
			'sections' => array
                                      (
                                      'geoworldmap' => array
                                                    (
                                                    'name' => 'geo_cities_list_title',
                                                    'uri' => 'admin/geoworldmap',
                                                    'shortcuts' => array
                                                                   (
                                                                    array
                                                                        (
                                                                        'name' => 'geo_city_create_title',
                                                                        'uri' => 'admin/geoworldmap/cities/create',
                                                                        'class' => 'add'
                                                                         ),                                                       
                                                                   ),
                                                    ),
                                      'countries' => array
                                                    (
                                                    'name' => 'geo_countries_list_title',
                                                    'uri' => 'admin/geoworldmap/countries',
                                                    'shortcuts' => array
                                                                   (
                                                                    array
                                                                        (
                                                                        'name' => 'geo_country_create_title',
                                                                        'uri' => 'admin/geoworldmap/countries/create',
                                                                        'class' => 'add'
                                                                         ),                                                       
                                                                   ),
                                                    ),
                                      'regions' => array
                                                    (
                                                    'name' => 'geo_region_NO_title',
                                                    'uri' => 'admin/geoworldmap/regions',
                                                    'shortcuts' => array
                                                                   (
                                                                    array
                                                                        (
                                                                        'name' => 'geo_region_create_title',
                                                                        'uri' => 'admin/geoworldmap/regions/create',
                                                                        'class' => 'add'
                                                                         ),                                                       
                                                                   ),
                                                    ),                               
                                      ),
                            );
	}

	public function install()
	{
		$this->dbforge->drop_table('geo_cities');
		$this->dbforge->drop_table('geo_regions');
		$this->dbforge->drop_table('geo_countries');
		$this->dbforge->drop_table('geo_dmas');
		$this->dbforge->drop_table('geo_subnets');               
		$this->dbforge->drop_table('geo_proxynetworks');
		$this->dbforge->drop_table('geo_privateaddresses');  
		$this->dbforge->drop_table('geo_nbc'); 
		$this->dbforge->drop_table('geo_timezone');                
                
                $geo_cities = " CREATE TABLE " . $this->db->dbprefix('geo_cities') . " (                
                                CityId int AUTO_INCREMENT NOT NULL ,
                                CountryID smallint NOT NULL ,
                                RegionID smallint NOT NULL ,
                                City varchar (45) NOT NULL ,
                                Latitude varchar (25) NOT NULL ,
                                Longitude varchar (25) NOT NULL ,
                                timezoneid varchar(50) COLLATE utf8_unicode_ci NOT NULL,
                                gmt varchar(10) COLLATE utf8_unicode_ci NOT NULL,
                                DmaId smallint NULL ,
                                County varchar (25) NULL ,
                                PhoneCode varchar (4) NULL ,
                                PRIMARY KEY(CityId)                                    
                                )ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=42952;
                ";

		$geo_regions = "
                                CREATE TABLE " . $this->db->dbprefix('geo_regions') . " (                
                                RegionID smallint AUTO_INCREMENT NOT NULL ,
                                CountryID smallint NOT NULL ,
                                Region varchar (45) NOT NULL ,
                                Code varchar (8) NOT NULL ,
                                ADM1Code char (4) NOT NULL ,
                                PRIMARY KEY(RegionID)    
                                );
                ";
                
		$geo_countries = "
                                CREATE TABLE " . $this->db->dbprefix('geo_countries') . " (                
                                CountryId smallint AUTO_INCREMENT NOT NULL ,
                                Country varchar (50) NOT NULL ,
                                FIPS104 varchar (2) NOT NULL ,
                                ISO2 varchar (2) NOT NULL ,
                                ISO3 varchar (3) NOT NULL ,
                                ISON varchar (4) NOT NULL ,
                                Internet varchar (2) NOT NULL ,
                                Capital varchar (25) NULL ,
                                MapReference varchar (50) NULL ,
                                NationalitySingular varchar (35) NULL ,
                                NationalityPlural varchar (35) NULL ,
                                Currency varchar (30) NULL ,
                                CurrencyCode varchar (3) NULL ,                               
                                Population varchar(30) COLLATE utf8_unicode_ci NOT NULL ,
                                Title varchar (50) NULL ,
                                Comment varchar (255) NULL ,
                                Latitude varchar(35) COLLATE utf8_unicode_ci NOT NULL,
                                Longitude varchar(35) COLLATE utf8_unicode_ci NOT NULL,                                
                                PhoneCode varchar (4) NULL ,                                 
                                PRIMARY KEY(CountryId)                                    
                                );
                ";
                
		$geo_dmas = "
                                CREATE TABLE " . $this->db->dbprefix('geo_dmas') . " (                
                                DmaId smallint NOT NULL ,
                                CountryId smallint NULL ,
                                DMA varchar (3) NULL ,
                                Market varchar (50) NULL                                    
                                );
                ";

// ---- Tables not used - START               
                
		$geo_subnets = "
                                CREATE TABLE " . $this->db->dbprefix('geo_subnets') . " (
                                SubNetAddress varchar (11) NOT NULL ,
                                Certainty smallint NULL ,
                                CityId int NULL ,
                                RegionId int NULL ,
                                CountryId int NULL ,
                                DmaId smallint NULL ,
                                RegionCertainty smallint NULL ,
                                CountryCertainty smallint NULL ,
                                PRIMARY KEY(SubNetAddress)
                                );
                ";                
                
		$geo_proxynetworks = "
                                CREATE TABLE " . $this->db->dbprefix('geo_proxynetworks') . " (                
                                SubnetAddress varchar (11) NULL ,
                                Network varchar (50) NULL ,
                                CityId int NULL                                    
                                );
                ";
                
		$geo_privateaddresses = "
                                CREATE TABLE " . $this->db->dbprefix('geo_privateaddresses') . " (                
                                AddressPrefix varchar (11) NOT NULL,
                                PRIMARY KEY(AddressPrefix)                                    
                                );
                ";
                
		$geo_nbc = "
                                CREATE TABLE " . $this->db->dbprefix('geo_nbc') . " (                
                                PrimaryCityId int NOT NULL ,
                                CityId int NOT NULL ,
                                Distance smallint NULL                                     
                                );
                ";
                
                $geo_timezone = "CREATE TABLE " . $this->db->dbprefix('geo_timezone') . " (
                                tzid int(11) NOT NULL AUTO_INCREMENT,
                                timeZoneId varchar(200) DEFAULT NULL,
                                GMT_offset varchar(10) DEFAULT NULL,
                                DST_offset varchar(10) DEFAULT NULL,
                                PRIMARY KEY (tzid)                         
                                ) CHARACTER SET utf8; ";
                
// ---- Tables not used - END
                
// Load database files                
                $loadfile_1 = "LOAD DATA LOCAL INFILE '".BASE_URL.SHARED_ADDONPATH."modules/geoworldmap/sql/cities.txt' INTO TABLE ".$this->db->dbprefix('geo_cities'); 
                $loadfile_1.= " FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' "; 
                $loadfile_1.= " LINES TERMINATED BY '\\r\\n' IGNORE 1 LINES; ";               

                $loadfile_2 = "LOAD DATA LOCAL INFILE '".BASE_URL.SHARED_ADDONPATH."modules/geoworldmap/sql/regions.txt' INTO TABLE ".$this->db->dbprefix('geo_regions'); 
                $loadfile_2.= " FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' "; 
                $loadfile_2.= " LINES TERMINATED BY '\\r\\n' IGNORE 1 LINES; ";                 

                $loadfile_3 = "LOAD DATA LOCAL INFILE '".BASE_URL.SHARED_ADDONPATH."modules/geoworldmap/sql/countries.txt' INTO TABLE ".$this->db->dbprefix('geo_countries'); 
                $loadfile_3.= " FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' "; 
                $loadfile_3.= " LINES TERMINATED BY '\\r\\n' IGNORE 1 LINES; ";                 
                
                $loadfile_4 = "LOAD DATA LOCAL INFILE '".BASE_URL.SHARED_ADDONPATH."modules/geoworldmap/sql/dmas.txt' INTO TABLE ".$this->db->dbprefix('geo_dmas'); 
                $loadfile_4.= " FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' "; 
                $loadfile_4.= " LINES TERMINATED BY '\\r\\n' IGNORE 1 LINES; "; 
                
                $loadfile_5 = "LOAD DATA LOCAL INFILE '".BASE_URL.SHARED_ADDONPATH."modules/geoworldmap/sql/timezones.txt' INTO TABLE ".$this->db->dbprefix('geo_timezone');                 
                $loadfile_5.= " FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' "; 
                $loadfile_5.= " LINES TERMINATED BY '\\r\\n' IGNORE 1 LINES; ";                 
                
		if ($this->db->query($geo_subnets)
                        && $this->db->query($geo_cities)
                        && $this->db->query($geo_regions)   
                        && $this->db->query($geo_countries)
                        && $this->db->query($geo_dmas)                        
                        && $this->db->query($geo_proxynetworks)
                        && $this->db->query($geo_privateaddresses)
                        && $this->db->query($geo_nbc)  
                        && $this->db->query($geo_timezone)                          
                        && $this->db->query($loadfile_1)
                        && $this->db->query($loadfile_2) 
                        && $this->db->query($loadfile_3)                                                                 
                        && $this->db->query($loadfile_4) 
                        && $this->db->query($loadfile_5)                        
                        )
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
            $this->dbforge->drop_table('geo_subnets');
            $this->dbforge->drop_table('geo_cities');
            $this->dbforge->drop_table('geo_regions');
            $this->dbforge->drop_table('geo_countries');
            $this->dbforge->drop_table('geo_dmas');
            $this->dbforge->drop_table('geo_proxynetworks');
            $this->dbforge->drop_table('geo_privateaddresses');
            $this->dbforge->drop_table('geo_nbc');   
            $this->dbforge->drop_table('geo_timezone');             
            
            $this->db->delete('settings', array('module' => 'geoworldmap'));            

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