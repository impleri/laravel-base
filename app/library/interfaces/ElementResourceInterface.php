<?php namespace app\library\interfaces;

use Illuminate\Database\Eloquent\Model;

/**
 * Element Resource Interface
 *
 * Define required methods for handling elements RESTfully.
 */
interface ElementResourceInterface extends CollectionResourceInterface
{
    /**
     * Get Element
     *
     * Processes input to retrieve an individual item within the collection.
     * Corresponds to the RESTful GET action for the element/item.
     * @param \Illuminate\Database\Eloquent\Model $model Autoloaded model
     * @return \Illuminate\Http\Response Laravel response
     */
    public function getElement(Model $model);

    /**
     * Post Item
     *
     * Processes input from older browsers to properly route a RESTful request.
     * @param \Illuminate\Database\Eloquent\Model $model Autoloaded model
     * @return \Illuminate\Http\Response Laravel response
     */
    public function postElement(Model $model);

    /**
     * Put Item
     *
     * Processes input to update an individual item within the collection.
     * Corresponds to the RESTful PUT action for the element/item.
     * @param \Illuminate\Database\Eloquent\Model $model Autoloaded model
     * @return \Illuminate\Http\Response Laravel response
     */
    public function putElement(Model $model);

    /**
     * Delete Item
     *
     * Processes input to remove an individual item from the collection.
     * Corresponds to the RESTful DELETE action for the element/item.
     * @param \Illuminate\Database\Eloquent\Model $model Autoloaded model
     * @return \Illuminate\Http\Response Laravel response
     */
    public function deleteElement(Model $model);
}
