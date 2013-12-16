<?php
/**
 * Application Routes
 *
 * Here is where you can register all of the routes for an application. It's a
 * breeze. Simply tell Laravel the URIs it should respond to and give it the
 * Closure to execute when that URI is requested.
 */


$controller_dir = 'app\controllers\\';

// First register error pages
Route::get('404', array('as' => 'notfound', 'uses' => $controller_dir . 'Site@notfound'));
Route::get('403', array('as' => 'notauth', 'uses' => $controller_dir . 'Site@notauth'));


// All RESTful actions for resource elements should go under here as an API
$resource_dir = $controller_dir . 'resources\\';
$resources = array (
    'user' => $resource_dir . 'User',
);
Impleri\Resource\Router::resources($resources);

// Non-API actions

// User routes
Route::controller('user', $controller_dir . 'User');

// Global static routes
Route::get('/', $controller_dir . 'Site@index');

// Dynamic page routes
Route::get('{slug}', $controller_dir . 'Site@slug');
