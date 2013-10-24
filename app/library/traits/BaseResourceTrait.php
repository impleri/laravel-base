<?php namespace app\library\traits;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

/**
 * Base Resource Trait
 *
 * Provides some simple actions to map
 */
trait BaseResourceTrait
{
    /**
     * The output format to use.
     * @var string
     */
    protected $format = 'json';

    /**
     * Constructor
     *
     * Ensure the format is detected prior to routing.
     */
    public function __construct()
    {
        $this->getFormat();
    }

    /**
     * Order of format priorities for output.
     * @var array
     */
    protected function getDefaultFormat()
    {
        return 'json';
    }

    /**
     * Get Format
     *
     * Determines which format to use for output.
     */
    protected function getFormat()
    {
        if (!Request::wantsJson()) {
            $this->format = Request::format($this->getDefaultFormat());
        }
    }

    /**
     * Respond
     *
     * Generates a response according to the detected format.
     * @param  mixed   $data    Data to pass to response
     * @param  string  $view    Full name of view
     * @param  integer $status  HTTP status code
     * @param  array   $headers Headers to pass to response
     * @return \Illuminate\Http\Response   Laravel response
     */
    protected function respond($data, $view = '', $status = 200, $headers = array())
    {
        switch ($this->format) {
            case 'xml':
            case 'txt':
                $this->prepareViewPath($view);
                // fall through to html handling

            case 'html':
                if (!empty($view)) {
                    $response = Response::view($view, $data, $status, $headers);
                } else {
                    $response = Response::make(
                        Collection::make($data)->flatten()->implode(0, "\n"),
                        $status,
                        $headers
                    );
                }
                break;

            default:
                $response = Response::json($data, $status, $headers);
                break;
        }

        return $response;
    }

    /**
     * Prepare View Path
     *
     * Ensure resource views are in an expected directory.
     * @example The request is for a blog post in XML format. The view name
     * should be the default path for html rendering (e.g. "post.show"). The
     * prepared path will be resources.xml.post.show. This is to keep API-aimed
     * views separate from standard HTML ones.
     * @param  string $view View path
     * @return string Resource view path
     */
    protected function prepareViewPath(&$view = '')
    {
        if (!empty($view) && $this->format != 'html') {
            if (strpos($view, $this->format) === false) {
                $view = $this->format . '.' . $view;
            }

            if (strpos($view, 'resources') === false) {
                $view = 'resources.' . $view;
            }
        }
    }

    /**
     * Not Supported
     *
     * Helper method to return an error for unsupported methods.
     * @param  string $view The view to render
     * @return \Illuminate\Http\Response Laravel response
     */
    protected function notSupported ($view)
    {
        $data = array(
            'success' => false,
            'errors' => array(
                'This resource does not support this method'
            ),
        );
        return $this->respond($data, $view, 405);
    }
}
