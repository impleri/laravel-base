<?php

namespace app\controllers\resources;

use Impleri\Resource\Interfaces\Element;
use Impleri\Resource\Traits\BaseResource;
use Impleri\Resource\Interfaces\CollectionForm;
use app\controllers\BaseController;
use app\models\User;
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

class UserResource extends BaseController implements Element, CollectionForm
{
    use BaseResource;

    /**
     * Get Collection
     *
     * Processes input to return a paginated collection of matched items.
     * Corresponds to the RESTful GET action for the collection.
     * @return \Illuminate\Http\Response Laravel response
     */
    public function getCollection()
    {
        $query = User::query();
        $users = $query->get();
        $data = array('users' => false, 'json' => array());

        $data['site_title'] = 'Site';

        if (!$users->isEmpty()) {
            $data['users'] = $users;
            $data['json'] = $users->toArray();
        }

        return $this->respond($data, 'users.list');
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

        $user = new User;

        // Ardent handles validation automatically
        $data = array(
            'success' => $user->save()
        );

        if ($data['success']) {
            // Return user object if successful
            $data['user'] = $user;
        }

        return $this->respond($data, 'users.created');
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
     * Add To Collection
     *
     * Shows form to add a new element to the collection.
     * @return \Illuminate\Http\Response Laravel response
     */
    public function addToCollection()
    {
        $data = array('site_title' => 'Site');
        return $this->respond($data, 'users.create');
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
        $user = User::find($rid);
        $data = array('users' => false, 'json' => array());

        $data['site_title'] = 'Site';

        if ($user) {
            $data['user'] = $user;
            $data['json'] = $user->toArray();
        }

        return $this->respond($data, 'users.show');
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
            return $this->$callback($rid = 0);
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
        $user = User::find($rid = 0);
        $data = array(
            'success' => $user->save()
        );

        $errors = $user->errors()->all();
        if (!empty($errors)) {
            $data['errors'] = $errors;
        }
        return $this->respond($data, 'user.saved', 200);
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
        $user = User::find($rid = 0);
        $data = array(
            'success' => $user->delete()
        );

        $errors = $user->errors()->all();
        if (!empty($errors)) {
            $data['errors'] = $errors;
        }

        return $this->respond($data, 'user.deleted', 200);
    }
}
