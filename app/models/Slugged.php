<?php namespace app\models;

use LaravelBook\Ardent\Ardent;
use Sluggable;

class Slugged extends Ardent
{
    public static $rules = array(
        'title' => 'required',
        'slug'  => 'required|unique'
    );

    public static $sluggable = array(
        'build_from' => 'title',
        'save_to'    => 'slug',
    );

    public function beforeValidate()
    {
        Sluggable::make($this,true);
    }

    public static function findBySlug($slug)
    {
        return static::where('slug', '=', $slug)->first();
    }
}
