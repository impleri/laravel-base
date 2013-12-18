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
$resources = array (
    'user' => array(
        'isCollection' => true,
        'isElement' => true
    ),
    'page',
    'post' => array(
        'isCollection' => true,
        'isElement' => true,
    ),
    'tag' => array(
        'isCollection' => true,
        'isElement' => true,
        'allowPutAll' => true,
    ),
);

$options = array(
    'pattern' => $controller_dir . 'resources\%s',
);
Impleri\Resource\Router::resources($resources, $options);

// User routes
Route::controller('user', $controller_dir . 'User');

// Route patterns
Route::pattern('year', '[0-9]{2,4}'); // Allow 2 or 4 digit years
Route::pattern('month', '[0-9]{1,2}'); // Allow 1 or 2 digit months
Route::pattern('slug', '[a-z0-9_\-]+'); // Alphanumerics plus underscore and dash

// Blog Routes
Route::group(
    array('prefix' => 'blog'),
    function() use ($controller_dir) {
        Route::get('tags/{slug}', $controller_dir . 'Blog@tag');
        Route::get('{year}/{month?}', $controller_dir . 'Blog@archive');
        Route::get('{slug}', $controller_dir . 'Blog@post');
        Route::get('/', $controller_dir . 'Blog@index');
    }
);

// Dynamic page routes
Route::get('{slug}', $controller_dir . 'Site@page');

// Home page
Route::get('/', $controller_dir . 'Site@index');
