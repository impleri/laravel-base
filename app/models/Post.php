<?php namespace app\models;

use app\models\types\Slugged;

class Post extends Slugged
{
    public static $rules = array(
        'title' => 'required',
        'slug'  => 'required|unique',
        'status'  => 'required',
        'body'  => 'required'
    );
}
