<?php namespace app\controllers;

use Controller;
use Response;

class Base extends Controller
{
	protected $data = array();


	public function __construct()
	{
		$this->data['site_title'] = 'Site Name';
		$this->data['errors'] = array();
	}

	protected function render($view, $response = 200)
	{
		return Response::view($view, $this->data, $response);
	}
}
