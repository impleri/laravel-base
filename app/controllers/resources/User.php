<?php namespace app\controllers\resources;

use Impleri\Resource\Interfaces\Collection;
use Impleri\Resource\Interfaces\Element;
use app\models\User as UserModel;
use Redirect;
use Request;
use Config;
use Lang;

/**
 * Confide Controller Template
 *
 * This is the default Confide controller template for controlling user
 * authentication. Feel free to change to your needs.
 */

class User extends Base implements Collection, Element
{
    public function __construct()
    {
        parent::__construct();
        $this->data['user'] = false;
        $this->data['users'] = false;
    }

    /**
     * Get Collection
     *
     * Processes input to return a paginated collection of matched items.
     * Corresponds to the RESTful GET action for the collection.
     * @return \Illuminate\Http\Response Laravel response
     */
    public function getCollection()
    {
        $users = UserModel::query()->get();

        if (!$users->isEmpty()) {
            $this->setResponse('users', $users);
        }

        return $this->respond($this->data, 'user.list');
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

        $user = new UserModel;

        // Ardent handles validation automatically
        $this->data['success'] = $user->save();

        if ($this->data['success']) {
            $this->setResponse('user', $user);
        }

        return $this->respond($this->data, 'user.created');
    }

    /**
     * Put Collection
     *
     * Processes input to overwrite the entire collection. Corresponds to the
     * RESTful PUT action for the collection.
     * @return \Illuminate\Http\Response Laravel response
     */
    public function putCollection()
    {
        return $this->notSupported();
    }

    /**
     * Delete Collection
     *
     * Processes input to delete the entire collection. Corresponds to the
     * RESTful DELETE action for the collection.
     * @return \Illuminate\Http\Response Laravel response
     */
    public function deleteCollection()
    {
        return $this->notSupported();
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
        $user = UserModel::find($rid);
        if ($user) {
            $this->setResponse('user', $user);
        }

        return $this->respond($this->data, 'user.show');
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
        $user = UserModel::find($rid);
        $this->data['success'] = $user->save();

        return $this->respond($this->data, 'user.saved');
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
        $user = UserModel::find($rid);
        $this->data['success'] = $user->delete();

        return $this->respond($this->data, 'user.deleted');
    }
}
