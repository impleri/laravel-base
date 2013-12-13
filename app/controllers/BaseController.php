<?php

namespace app\controllers;

use Controller;
use View;

class BaseController extends Controller
{
	protected $data = array();


	public function __construct()
	{
		$this->data['site_title'] = 'Site Name';
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
