<?php namespace app\models\types;

class Taxonomy extends Slugged
{
    public static $rules = array(
        'name' => 'required',
        'slug'  => 'required|unique',
        'description'  => 'required'
    );

    public static $sluggable = array(
        'build_from' => 'name',
        'save_to'    => 'slug',
    );
}
