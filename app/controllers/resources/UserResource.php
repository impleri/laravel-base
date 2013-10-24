<?php

namespace app\controllers\resources;

use app\library\interfaces\ElementResourceInterface;
use app\library\traits\BaseResourceTrait;
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

class UserResource extends BaseController implements ElementResourceInterface
{
    use BaseResourceTrait;

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

        // Pass filters to query

        $users = $query->get();

        if (!$users->isEmpty()) {
            $data['users'] = $users->toArray();
        }
        $data = array(
            'users' => $users
        );

        $errors = $user->errors()->all();
        if (!empty($errors)) {
            $data['errors'] = $errors;
        }
        return $this->respond($data, '', 200);
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
        } else {
            // Get validation errors (see Ardent package)
            $data['errors'] = $user->errors()->all();
        }

        return $this->respond($data, 'user.created', 200);
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
        return $this->notSupported('');
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
        return $this->notSupported('');
    }

    /**
     * Get Element
     *
     * Processes input to retrieve an individual item within the collection.
     * Corresponds to the RESTful GET action for the element/item.
     * @param \app\models\User $user Autoloaded user model
     * @return \Illuminate\Http\Response Laravel response
     */
    public function getElement(User $user)
    {
        $data = array(
            'user' => $user
        );

        $errors = $user->errors()->all();
        if (!empty($errors)) {
            $data['errors'] = $errors;
        }

        return $this->respond($data, 'user.show', 200);
    }

    /**
     * Post Element
     *
     * Processes input from older browsers to properly route a RESTful request.
     * @param \Illuminate\Database\Eloquent\Model $model Autoloaded model
     * @return \Illuminate\Http\Response Laravel response
     */
    public function postElement(User $user)
    {
        // Handle HTTP 1.0 requests
        $method = Request::input('_method', 'put');
        if (in_array($method, array('delete', 'put'))) {
            $callback = $method . 'Element';
            return $this->$callback($model);
        }
    }

    /**
     * Put Element
     *
     * Processes input to update an individual item within the collection.
     * Corresponds to the RESTful PUT action for the element/item.
     * @param \app\models\User $user Autoloaded user model
     * @return \Illuminate\Http\Response Laravel response
     */
    public function putElement(User $user)
    {
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
     * @param \app\models\User $user Autoloaded user model
     * @return \Illuminate\Http\Response Laravel response
     */
    public function deleteElement(User $user)
    {
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
