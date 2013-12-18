<?php namespace app\models;

use app\models\types\Slugged;

class Page extends Slugged
{
    public static $rules = array(
        'title' => 'required',
        'slug'  => 'required|unique',
        'body'  => 'required'
    );
}
