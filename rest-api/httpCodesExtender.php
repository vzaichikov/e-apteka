<?

class HttpMethodNotAllowedException extends \Slim\Exception\HttpMethodNotAllowedException
{
    protected $code = 403;
}
