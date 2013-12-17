<?php namespace app\controllers\resources;

use Impleri\Resource\Interfaces\Collection;
use Impleri\Resource\Interfaces\Element;
use app\models\Page as PageModel;
use Redirect;
use Request;
use Config;
use Lang;

/**
 * Page Resource
 *
 * This controller handles CRUD actions for page resources.
 */

class Page extends Base implements Element
{
    public function __construct()
    {
        parent::__construct();
        $this->data['page'] = false;
    }

    /**
     * Get Element
     *
     * Processes input to retrieve an individual item within the collection.
     * Corresponds to the RESTful GET action for the element/item.
     * @param int $rid Resource ID
     * @return \Illuminate\Http\Response Laravel response
     */
    public function getElement($rid = 0)
    {
        $page = PageModel::find($rid);
        if ($page) {
            $this->setResponse('page', $page);
        }

        return $this->respond($this->data, 'page.show');
    }

    /**
     * Post Collection
     *
     * Processes input to create an individual item within the collection.
     * Corresponds to the RESTful POST action for the collection.
     * @return \Illuminate\Http\Response Laravel response
     */
    public function postCollection()
    {
        // Handle HTTP 1.0 requests
        $method = Request::input('_method', 'put');
        if (in_array($method, array('delete', 'put'))) {
            $callback = $method . 'Collection';
            return $this->$callback();
        }

        $page = new PageModel;

        // Ardent handles validation automatically
        $this->data['success'] = $page->save();

        if ($this->data['success']) {
            $this->setResponse('page', $page);
        }

        return $this->respond($this->data, 'page.created');
    }

    /**
     * Post Element
     *
     * Processes input from older browsers to properly route a RESTful request.
     * @param \Illuminate\Database\Eloquent\Model $model Autoloaded model
     * @return \Illuminate\Http\Response Laravel response
     */
    public function postElement($rid = 0)
    {
        // Handle HTTP 1.0 requests
        $method = Request::input('_method', 'put');
        if (in_array($method, array('delete', 'put'))) {
            $callback = $method . 'Element';
            return $this->$callback($rid);
        }
    }

    /**
     * Put Element
     *
     * Processes input to update an individual item within the collection.
     * Corresponds to the RESTful PUT action for the element/item.
     * @param int $rid Resource ID
     * @return \Illuminate\Http\Response Laravel response
     */
    public function putElement($rid = 0)
    {
        $page = PageModel::find($rid);
        $this->data['success'] = $page->save();

        return $this->respond($this->data, 'page.saved');
    }

    /**
     * Delete Element
     *
     * Processes input to remove an individual item from the collection.
     * Corresponds to the RESTful DELETE action for the element/item.
     * @param int $rid Resource ID
     * @return \Illuminate\Http\Response Laravel response
     */
    public function deleteElement($rid = 0)
    {
        $page = PageModel::find($rid);
        $this->data['success'] = $page->delete();

        return $this->respond($this->data, 'page.deleted');
    }
}
