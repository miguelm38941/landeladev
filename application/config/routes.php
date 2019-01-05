<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['mobileapi/mesordonnances/(:num)'] = 'api/mobile/ordonnances/mes_ordonnances/$1';
$route['mobileapi/ordonnances_a_recevoir/(:num)'] = 'api/mobile/ordonnances/ordonnance_a_recevoir/$1';
$route['mobileapi/accepter_ordonnance/(:num)'] = 'api/mobile/ordonnances/recevoir_ordonnance/$1';
$route['mobileapi/ordonnances_livrees/(:num)'] = 'api/mobile/ordonnances/ordonnances_livrees/$1';
$route['mobileapi/mesobservations/(:num)'] = 'api/mobile/ordonnances/mes_observations/$1';
$route['mobileapi/mesconsultations/(:num)'] = 'api/mobile/ordonnances/mes_consultations/$1';
$route['mobileapi/consultations_crees/(:num)'] = 'api/mobile/ordonnances/consultations_crees/$1';
$route['mobileapi/informations'] = 'api/mobile/ordonnances/informations';
$route['fingerprintapi/(:num)'] = 'api/fingerprint';
$route['mobileapi/livrer_ordonnance'] = 'api/mobile/ordonnances/livrer_ordonnance';
$route['mobileapi/get_medicaments/(:num)'] = 'api/mobile/ordonnances/get_medicaments/$1';
$route['mobileapi/livrer_medicaments'] = 'api/mobile/ordonnances/livrer_medicaments';
$route['mobileapi/nouvelle_consultation'] = 'api/mobile/ordonnances/nouvelle_consultation';
$route['mobileapi/inscription'] = 'api/mobile/authenticate/inscription';
$route['mobileapi/inscription_membre'] = 'api/mobile/authenticate/inscription_membres';
$route['mobileapi/entities/(:any)'] = 'api/mobile/authenticate/get_entity/$1';
