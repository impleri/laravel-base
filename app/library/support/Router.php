<?php namespace app\library\support;

use Illuminate\Support\Str;
use Route;

/**
 * Router Helper
 *
 * Small class to extend Router functions
 */
class Router
{
    public static function group ($resources, $prefix = 'resources')
    {
        Route::group(
            array('prefix' => $prefix),
            function () use ($resources) {
                foreach ($resources as $name => $data) {
                    if (!is_array($data)) {
                        $data = array(
                            'class' => $data
                        );
                    }

                    if (is_numeric($name)) {
                        $name = $data['class'];
                    }


                    self::resource($name, $data);
                }
            }
        );
    }

    public static function resource($resource, $data = array())
    {
        $controller = (isset($data['class'])) ? $data['class'] : $resource;
        $hasItems = (isset($data['hasItems'])) ? $data['hasItems'] : true;
        $putCollction = (isset($data['allowSaveAll'])) ? $data['allowSaveAll'] : false;
        $deleteCollction = (isset($data['allowDeleteAll'])) ? $data['allowDeleteAll'] : false;

        $collection_fmt = $controller . '@%sCollection';
        Route::get($resource, sprintf($collection_fmt, 'get'));
        Route::post($resource, sprintf($collection_fmt, 'post'));

        if ($putCollction) {
            Route::put($resource, sprintf($collection_fmt, 'put'));
        }

        if ($deleteCollction) {
            Route::delete($resource, sprintf($collection_fmt, 'delete'));
        }

        if ($hasItems) {
            $element = sprintf('%1$s/{%1$s}', $resource);
            $element_fmt = $controller . '@%sElement';
            Route::get($element, sprintf($element_fmt, 'get'));
            Route::post($element, sprintf($element_fmt, 'post'));
            Route::put($element, sprintf($element_fmt, 'put'));
            Route::delete($element, sprintf($element_fmt, 'delete'));
        }
    }
}
