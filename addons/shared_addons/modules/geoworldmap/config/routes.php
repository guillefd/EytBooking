<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
| 	www.your-site.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://www.codeigniter.com/user_guide/general/routing.html
*/

// public
//$route['(products)/(:num)/(:num)/(:any)']	= 'products/view/$4';
//$route['(products)/page(/:num)?']		= 'products/index$2';
//$route['(products)/rss/all.rss']		= 'rss/index';
//$route['(products)/rss/(:any).rss']		= 'rss/category/$2';
//
// admin
$route['geoworldmap/admin/cities']                          = 'admin/index';
$route['geoworldmap/admin/cities/create']                   = 'admin/create';
$route['geoworldmap/admin/cities/edit/(:num)']              = 'admin/edit/$4';
$route['geoworldmap/admin/cities/regions_ajax']             = 'admin/load_regions_ajax';
$route['geoworldmap/admin/cities/autocomplete_ajax']        = 'admin/cities_autocomplete_ajax';

$route['geoworldmap/admin/countries']                       = 'admin_countries/index';
$route['geoworldmap/admin/countries/create']                = 'admin_countries/create';
$route['geoworldmap/admin/countries/create_ajax']           = 'admin_countries/create_ajax';
$route['geoworldmap/admin/countries/edit/(:num)']           = 'admin_countries/edit/$1';
$route['geoworldmap/admin/countries/index/(:num)']          = 'admin_countries/index/$1';
$route['geoworldmap/admin/countries/ajax_filter']           = 'admin_countries/ajax_filter';
$route['geoworldmap/admin/countries/ajax_filter/(:num)']    = 'admin_countries/ajax_filter/$1';
$route['geoworldmap/admin/countries/preview/(:num)']        = 'admin_countries/preview/$1';

$route['geoworldmap/admin/regions/(:num)']                  = 'admin_regions/index/$1';
$route['geoworldmap/admin/regions/create']                  = 'admin_regions/create';
$route['geoworldmap/admin/regions/edit/(:num)']             = 'admin_regions/edit/$1';
$route['geoworldmap/admin/regions/create_ajax']             = 'admin_regions/create_ajax';


//webservices
$route['geoworldmap/admin/webservice/geonames_timezone/(:any)/(:any)']     = 'admin/check_ws_geonames_timezone/$1/$2';

//ajax
$route['geoworldmap/admin/webservice/citygeocode']          = 'admin/webservice_city_geocode_ajax';
$route['geoworldmap/admin/webservice/addressgeocode']       = 'admin/webservice_address_geocode_ajax';
$route['geoworldmap/admin/webservice/timezone']             = 'admin/webservice_geonames_timezone_ajax';
$route['geoworldmap/admin/webservice/countryinfo']          = 'admin_countries/webservice_geonames_countryinfo_ajax';
$route['geoworldmap/admin/webservice/countrieslist']        = 'admin_countries/webservice_goog_geocode_ajax';

