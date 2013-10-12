<?php
/*
|--------------------------------------------------------------------------
| Cabinet Controller Template
|--------------------------------------------------------------------------
|
| This is the default Cabinet controller template for controlling uploads.
| Feel free to change to your needs.
|
*/

class UploadController extends BaseController {

    /**
     * Displays the form for account creation
     *
     */
    public function getCreate()
    {
        return View::make(Config::get('cabinet::upload_form'));
    }

    /**
     * Stores new upload
     *
     */
    public function postIndex()
    {
        $file = Input::file('file');

        $upload = new Upload;

        try {
            $upload->process($file);
        } catch(Exception $exception){
            // Something went wrong. Log it.
            Log::error($exception);
            // Return error
            return Response::json($exception->getMessage(), 400);
        }

        // If it now has an id, it should have been successful.
        if ( $upload->id ) {
            return Response::json(array('status' => 'success', 'file' => $upload->toArray()), 200);
        } else {
            return Response::json('Error', 400);
        }
    }

    public function getIndex()
    {
        return View::make(Config::get('cabinet::upload_list'));
    }

    public function getData()
    {
        $uploads =  Upload::leftjoin('users', 'uploads.id', '=', 'users.id')
            ->select(
                array('uploads.id', 'uploads.filename', 'uploads.path', 'uploads.extension',
                    'uploads.size', 'uploads.mimetype', 'users.id as user_id', 'users.username as username')
            );

        return Datatables::of($uploads)
            ->remove_column('id')
            ->remove_column('user_id')
            ->edit_column('username', '<a href="{{ URL::to(\'admin/users/\'.$id.\'/edit\')}}">{{$username}}</a>')
            ->make();
    }

}
