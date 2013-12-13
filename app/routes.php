<?php
/**
 * Application Routes
 *
 * Here is where you can register all of the routes for an application. It's a
 * breeze. Simply tell Laravel the URIs it should respond to and give it the
 * Closure to execute when that URI is requested.
 */

// All RESTful actions for resource elements should go under here as an API
$resource_fmt = 'app\controllers\resources\%sResource';
$resources = array (
    'user' => sprintf($resource_fmt, 'User'),
);
Impleri\Resource\Router::resources($resources);

// Confide routes for handling user login/logout/confirm/reset
Route::get('user/confirm/{code}', 'app\controllers\UserController@getConfirm');
Route::get('user/reset_password/{token}', 'app\controllers\UserController@getResetPassword');
Route::controller('user', 'app\controllers\UserController');

// Final route
Route::get(
    '/',
    function () {
        return View::make('hello');
    }
);
