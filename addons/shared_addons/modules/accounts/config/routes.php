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

// front-end
//$route['accounts(/:num)?']	        = 'accounts/index/$1';

//back-end

//accounts
$route['accounts/admin(/:num)?']                = 'admin/index';

//account-contact
$route['accounts/admin/contacts']                   = 'admin_contacts/index';
$route['accounts/admin/contacts/index']             = 'admin_contacts/index';
$route['accounts/admin/contacts/index(/:num)']      = 'admin_contacts/index$1';
$route['accounts/admin/contacts/create']            = 'admin_contacts/create';
$route['accounts/admin/contacts/edit(/:num)']       = 'admin_contacts/edit$1';
$route['accounts/admin/contacts/preview(/:num)']    = 'admin_contacts/preview$1';
$route['accounts/admin/contacts/delete(/:num)']     = 'admin_contacts/delete$1';
$route['accounts/admin/contacts/action']             = 'admin_contacts/action';

//ajax
$route['accounts/admin/accounts_autocomplete_ajax']       = 'admin/accounts_autocomplete_ajax';
$route['accounts/admin/contacts/ajax_filter']             = 'admin_contacts/ajax_filter';
$route['accounts/admin/contacts/ajax_filter(/:num)']      = 'admin_contacts/ajax_filter$1';
$route['accounts/admin/get_account_ajax(/:num)']           = 'admin/get_account_ajax$1';