<?php namespace app\models;

use app\models\types\Taxonomy;

class Tag extends Taxonomy
{
    public function posts()
    {
        return $this->belongsToMany('app\models\Post');
    }
}
