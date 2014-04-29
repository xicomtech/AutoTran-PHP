<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
	Router::connect('/admin', array('controller' => 'users', 'action' => 'login', 'admin' => true ));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/page/*', array ('controller' => 'pages', 'action' => 'display'));
	Router::connect('/contact', array ('controller' => 'pages', 'action' => 'contact'));
	Router::parseExtensions('json');
	// API routing
	Router::connect("/api/login",array('controller' => 'apis', 'action' => 'login'));
	Router::connect("/api/dispatch",array('controller' => 'apis', 'action' => 'dispatch'));
	Router::connect("/api/pick_load",array('controller' => 'apis', 'action' => 'pick_load'));
	Router::connect("/api/vin_list",array('controller' => 'apis', 'action' => 'vin_list'));
	Router::connect("/api/vin_detail",array('controller' => 'apis', 'action' => 'vin_detail'));
	Router::connect("/api/area_code",array('controller' => 'apis', 'action' => 'area_code'));
	Router::connect("/api/type_code",array('controller' => 'apis', 'action' => 'type_code'));
	Router::connect("/api/severity_code",array('controller' => 'apis', 'action' => 'severity_code'));
	Router::connect("/api/special_code",array('controller' => 'apis', 'action' => 'special_code'));
	Router::connect("/api/vin_message",array('controller' => 'apis', 'action' => 'vin_message'));
	Router::connect("/api/position",array('controller' => 'apis', 'action' => 'position'));
	Router::connect("/api/dealer_detail",array('controller' => 'apis', 'action' => 'dealer_detail'));	
	Router::connect("/api/dashboard",array('controller' => 'apis', 'action' => 'dashboard'));
	Router::connect("/api/load_inspection",array('controller' => 'apis', 'action' => 'load_inspection'));
	Router::connect("/api/final_inspection",array('controller' => 'apis', 'action' => 'final_inspection'));
	Router::connect("/api/notes",array('controller' => 'apis', 'action' => 'notes'));
	
	

/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
