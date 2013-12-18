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

    public function author()
    {
        return $this->belongsTo('app\models\User', 'author');
    }

    public function tags()
    {
        return $this->belongsToMany('app\models\Tag');
    }
}
