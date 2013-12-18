<?php namespace app\controllers;

use app\models\Page;
use Redirect;
use Event;
use Views;
use App;

class Site extends Base
{
	public function index()
	{
		return $this->render('hello');
	}

    public function page($slug)
    {
        $response = false;
        $page = Page::findBySlug($slug);

        if ($page) {
            $this->data['page'] = $page;
            $response = $this->render('page.show');
        }

        return $response;
    }

    public function post($slug)
    {

    }

    public function tag($slug)
    {

    }

    public function archives($year = 0, $month = 0)
    {

    }

    public function notauth($exception = '')
    {
        $this->data['exception'] = $exception;
        return $this->render('error.403', 403);
    }

    public function notfound($exception = '')
    {
        $this->data['exception'] = $exception;
        return $this->render('error.404', 301);
    }
}
