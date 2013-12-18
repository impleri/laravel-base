<?php namespace app\models\types;

use Baum\Node;
use Sluggable;

class Taxonomy extends Node
{
    public static $sluggable = array(
        'build_from' => 'name',
        'save_to'    => 'slug',
    );

    public static function findBySlug($slug)
    {
        return static::where('slug', '=', $slug)->first();
    }
}
