<?php namespace app\models;

class Page extends Slugged
{
    public static $rules = array(
        'title' => 'required',
        'slug'  => 'required|unique',
        'body'  => 'required'
    );
}
