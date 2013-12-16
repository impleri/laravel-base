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

    public function slug($slug)
    {
        $methods = array('page');

        foreach ($methods as $method) {
            $response = $this->$method($slug);

            if ($response) {
                break;
            }
        }

        if (!$response) {
            $response = $this->notfound('Unable to find page');
        }

        return $response;
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
