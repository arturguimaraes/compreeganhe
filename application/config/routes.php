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
|	https://codeigniter.com/user_guide/general/routing.html
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

// RESERVED ROUTES
$route['default_controller'] 	= 'pages/load';
$route['404_override'] 			= '';
$route['translate_uri_dashes'] 	= FALSE;

// ADMIN ROUTES
$route['admin'] 			= 'admin/index';
$route['adminSobre'] 		= 'admin/sobre';
$route['adminTaxas'] 		= 'admin/taxas';
$route['adminPrecos'] 		= 'admin/precos';
$route['adminAddProduct'] 	= 'admin/add';
$route['adminLogin']	 	= 'admin/login';
$route['adminOrders']	 	= 'admin/orders';
$route['adminUsers']	 	= 'admin/users';
$route['adminMessages']	 	= 'admin/messages';

// NOT PAGED ROUTES
$route['login'] 			= 'pages/login';
$route['logout'] 			= 'pages/logout';
$route['updateOrder'] 		= 'pages/updateOrder';

// ROUTES WITH LOGIN CHECKS
$route['signup']			= 'pages/signup';
$route['signup/(:any)']		= 'pages/signup/$1';
$route['confirm'] 			= 'pages/confirm';
$route['emptyCart'] 		= 'pages/emptyCart';
$route['export'] 			= 'pages/export';

// ROUTES WITH LOGIN AND PAYMENT CHECKS
$route['myaccount'] 		= 'pages/load/myaccount';
$route['myinfo'] 			= 'pages/load/myinfo';
$route['mynetwork'] 		= 'pages/load/mynetwork';
$route['myorders'] 			= 'pages/load/myorders';
$route['order'] 			= 'pages/load/order';
$route['mybudget'] 			= 'pages/load/mybudget';
$route['mynetworksbudget'] 	= 'pages/load/mynetworksbudget';
$route['shop'] 				= 'pages/load/shop';
$route['product'] 			= 'pages/load/product';
$route['cart'] 				= 'pages/load/cart';
$route['purchase'] 			= 'pages/load/purchase';
$route['buy']				= 'pages/load/buy';
$route['message'] 			= 'pages/load/message';
$route['messages'] 			= 'pages/load/messages';
$route['sendMessage'] 		= 'pages/load/sendMessage';
$route['deleteMessage'] 	= 'pages/deleteMessage';
$route['deleteAllMessages'] = 'pages/deleteAllMessages';
$route['rank'] 				= 'pages/load/rank';
$route['password'] 			= 'pages/load/password';
$route['pay'] 				= 'pages/load/pay';
$route['withdraw'] 			= 'pages/load/withdraw';

// ERROR PAGE ROUTE
$route['(:any)']			= 'pages/error';