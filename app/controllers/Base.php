<?php

namespace app\controllers;

use Controller;
use View;

class Base extends Controller
{
	protected $data = array();


	public function __construct()
	{
		$this->data['site_title'] = 'Site Name';
	}

	protected function &render($view)
	{
		return View::make($view, $this->data);
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
