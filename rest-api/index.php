<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Server\MiddlewareInterface;
use Slim\Factory\AppFactory;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpNotImplementedException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Handlers\ErrorHandler;

const languages = [
    'ru' => 2,
    'ua' => 3
];

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';
require_once DIR_SYSTEM . '/library/db/mysqli_rest.php';

require_once __DIR__ . '/httpCodesExtender.php';
require_once __DIR__ . '/models/hoboModel.php';
require_once __DIR__ . '/models/hoboModelProduct.php';
require_once __DIR__ . '/models/hoboModelStocks.php';
require_once __DIR__ . '/models/hoboModelOrder.php';
require_once __DIR__ . '/models/hoboModelDrugstore.php';

$dbObject = new \DB\MySQLiRest(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);

$modelProduct   = new \hobotix\hoboModelProduct($dbObject);
$modelStocks    = new \hobotix\hoboModelStocks($dbObject);
$modelOrder     = new \hobotix\hoboModelOrder($dbObject);
$modelDrugstore = new \hobotix\hoboModelDrugstore($dbObject);

$restApp = AppFactory::create();
$restApp->setBasePath('/rest-api');
$restApp->addRoutingMiddleware();

$customErrorHandler = function (
    \GuzzleHttp\Psr7\ServerRequest $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails
) use ($restApp) {   
    $message    = 'Unknown error';
    $statusCode = 500;

    if ($exception instanceof HttpUnauthorizedException) {
        $statusCode = 401;
        $message = 'Unauthorized';
    }  elseif ($exception instanceof HttpBadRequestException) {
        $statusCode = 400;
        $message = 'Bad Request';
    } elseif ($exception instanceof HttpNotFoundException) {
        $statusCode = 404;       
        $message = 'Not Found';
    }

    if ($exception->getMessage()){
        $message = $exception->getMessage();
    }

    $payload = ['error' => $message];

    $response = $restApp->getResponseFactory()->createResponse($statusCode);
    $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));

    return $response->withHeader('Content-Type', 'application/json');
};

$errorMiddleware = $restApp->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);

/*
    Authorization middleware
*/
$restApp->add(function (Request $request, RequestHandler $handler) use ($restApp) {
    $apiKey = $request->getHeaderLine('X-API-KEY');

    if ($apiKey == REST_API_TOKEN) {
        return $handler->handle($request);
    } else {
        $payload = ['error' => 'Unauthorized, check your API KEY please'];

        $response = $restApp->getResponseFactory()->createResponse();        
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
        return $response->withStatus(401);
    }
});


/*
    Point to get product by uuid
*/
$restApp->get('/product-id/{uuid}', function (Request $request, Response $response, array $args) use ($modelProduct) {
    if ($product_id = $modelProduct->getProductIdByUUID($args['uuid'])){
        $payload = ['success' => true, 'product_id' => $product_id];
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    } else {
        throw new HttpNotFoundException($request, 'Product not found with uuid ' . $args['uuid']);
    }   

    return $response;
});

/*
    Point to get products by uuids ['uuid1', 'uuid2']
*/
$restApp->post('/products-ids/', function (Request $request, Response $response, array $args) use ($modelProduct) {
    $body = $request->getBody()->getContents();
    $data = json_decode($body, true);
    if (!is_array($data)) {
        throw new HttpBadRequestException($request, "Invalid JSON body");
    }

    if ($products = $modelProduct->getProductIdsByUUID($data)){
        $payload = ['success' => true, 'data' => $products];
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    } else {
        throw new HttpNotFoundException($request);
    }   

    return $response;
});

/*
    Point to get full product data by id
*/
foreach (languages as $code => $key) {
    $restApp->get('/products/{id}/' . $code, function (Request $request, Response $response, array $args) use ($modelProduct, $key) {
        if ($product = $modelProduct->getProductByID($args['id'], $key)){
            $payload = ['success' => true, 'data' => $product];
            $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            throw new HttpNotFoundException($request, 'Product not found with id ' . $args['id']);
        }   

        return $response;
    });
}

/*
    Point to add or modify some product data (this adds product to queue)
*/
$restApp->post('/products/', function (Request $request, Response $response, array $args) use ($modelProduct) {
    $body = $request->getBody()->getContents();
    $data = json_decode($body, true);
    if (!is_array($data)) {
        throw new HttpBadRequestException($request, "Invalid JSON body");
    }

    $fileid     = date('Y-m-d-H-i-s') . mt_rand(0,10000) . '.json';
    $filename   = __DIR__ . '/queue/product/' . $fileid;
    file_put_contents($filename, json_encode($data));

    $payload = ['success' => true, 'message' => 'Added data to queue at ' . $fileid];
    $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));

    return $response->withHeader('Content-Type', 'application/json');
});





foreach (languages as $code => $key) {
    $restApp->get('/drugstores/' . $code, function (Request $request, Response $response, array $args) use ($modelDrugstore, $key) {
        if ($drugstores = $modelDrugstore->getDrugStores($key)){
            $payload = ['success' => true, 'data' => $drugstores];
            $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            throw new HttpNotFoundException($request, 'No drugstores available now');
        }   

        return $response;
    });
}

$restApp->run();

