<?php namespace app\controllers\resources;

use app\controllers\Base as BaseController;
use Impleri\Resource\Traits\Resource;

/**
 * Base Resource Controller
 */
class Base extends BaseController
{
    use Resource;

    public function __construct()
    {
        parent::__construct();
        $this->data['success'] = false;
        $this->data['json'] = array();
        $this->data['errors'] = array();
    }

    public function setResponse($key, $value, $toJson = true)
    {
        $this->data[$key] = $value;
        if ($toJson) {
            $this->data['json'][$key] = (method_exists($value, 'toArray'))
                ? $value->toArray()
                : $value;
        }
    }
}
