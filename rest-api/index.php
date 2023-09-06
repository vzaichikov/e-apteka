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

define('SELF_REST_PATH', dirname(__FILE__));

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';
require_once DIR_SYSTEM . '/library/db/mysqli_rest.php';
require_once DIR_SYSTEM . '/helper/general.php';
require_once DIR_SYSTEM . '/helper/json.php';
require_once DIR_SYSTEM . '/library/log.php';

require_once __DIR__ . '/models/hoboModel.php';
require_once __DIR__ . '/models/hoboModelProduct.php';
require_once __DIR__ . '/models/hoboModelStocks.php';
require_once __DIR__ . '/models/hoboModelOrder.php';
require_once __DIR__ . '/models/hoboModelDrugstore.php';
require_once __DIR__ . '/models/hoboModelPrice.php';

$dbObject = new \DB\MySQLiRest(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);

$modelProduct   = new \hobotix\hoboModelProduct($dbObject);
$modelStocks    = new \hobotix\hoboModelStocks($dbObject);
$modelOrder     = new \hobotix\hoboModelOrder($dbObject);
$modelDrugstore = new \hobotix\hoboModelDrugstore($dbObject);
$modelPrice     = new \hobotix\hoboModelPrice($dbObject);

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
    } elseif ($exception instanceof HttpNotImplementedException) {
        $statusCode = 500;       
        $message = 'Not Implemented';
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

 //   return $handler->handle($request);
    
    if ($apiKey == REST_API_TOKEN) {
        return $handler->handle($request);
    } else {
        $payload = ['error' => 'Unauthorized, check your API KEY please'];

        $response = $restApp->getResponseFactory()->createResponse();        
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
        return $response->withStatus(401);
    }
});


/*************************************************************************************
 * 
 * PRODUCTS
 * 
 /*********************************************************************************/

/*
    Point to get product by uuid
*/
$restApp->get('/product-id/{uuid}', function (Request $request, Response $response, array $args) use ($modelProduct) {
    if ($product_id = $modelProduct->getProductIdByUUID($args['uuid'])){
        $payload = ['success' => true, 'productID' => $product_id];
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    } else {
        throw new HttpNotFoundException($request, 'Product not found with uuid ' . $args['uuid']);
    }   

    return $response;
});

/*
    Point to get product ids by uuids ['uuid1', 'uuid2']
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
    Point to get full products id - uuid table
*/
$restApp->get('/products/', function (Request $request, Response $response, array $args) use ($modelProduct) {
    if ($products = $modelProduct->getAllIdToUUIDTable()){
        $payload = ['success' => true, 'data' => $products];
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    } else {
        throw new HttpNotFoundException($request, 'No products available');
    }   

    return $response;
});

/*
    Point to get full product data by id
*/
$restApp->get('/products/{id}', function (Request $request, Response $response, array $args) use ($modelProduct) {
    if ($product = $modelProduct->getProductByID($args['id'])){
        $payload = ['success' => true, 'data' => $product];
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    } else {
        throw new HttpNotFoundException($request, 'Product not found with id ' . $args['id']);
    }   

    return $response;
});


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


/*************************************************************************************
 * 
 * DRUGSTORES
 * 
 /*********************************************************************************/

/*
    Point to get all drugstore list
*/
$restApp->get('/drugstores/', function (Request $request, Response $response, array $args) use ($modelDrugstore) {
    if ($drugstores = $modelDrugstore->getDrugStores()){
        $payload = ['success' => true, 'data' => $drugstores];
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    } else {
        throw new HttpNotFoundException($request, 'No drugstores available now');
    }   

    return $response;
});

$restApp->get('/drugstores/{id}', function (Request $request, Response $response, array $args) use ($modelDrugstore) {        
    if ($drugstore = $modelDrugstore->getDrugStore($args['id'])){
        $payload = ['success' => true, 'data' => $drugstore];
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    } else {
        throw new HttpNotFoundException($request, 'No drugstores available now');
    }   

    return $response;
});

$restApp->post('/drugstores/', function (Request $request, Response $response, array $args) use ($modelDrugstore) {
    $body = $request->getBody()->getContents();
    $data = json_decode($body, true);
    if (!is_array($data)) {
        throw new HttpBadRequestException($request, "Invalid JSON body");
    }       

    $fields = [
        'drugstoreClosed', 
        'drugstoreName_RU', 
        'drugstoreName_UA', 
        'drugstoreAddress_RU', 
        'drugstoreAddress_UA', 
        'drugstoreTelephone', 
        'drugstoreFax', 
        'drugstoreGeoCode', 
        'drugstoreUUID', 
        'drugstoreGmapsLink', 
        'drugstoreOpen', 
        'drugstoreOpenStruct', 
        'drugstoreSortOrder', 
        'drugstoreCanSellDrugs'
    ];

    foreach ($fields as $field){
        if (!isset($data[$field])){
             throw new HttpBadRequestException($request, "No $field field provided");
        }
    }

    if ($drugstore = $modelDrugstore->addDrugstore($data)){
        $payload = ['success' => true, 'data' => $drugstore];
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    } else {
        throw new HttpNotImplementedException($request, "Drugstore not added");
    }
});

$restApp->patch('/drugstores/{id}', function (Request $request, Response $response, array $args) use ($modelDrugstore) {
    $body = $request->getBody()->getContents();
    $data = json_decode($body, true);
    if (!is_array($data)) {
        throw new HttpBadRequestException($request, "Invalid JSON body");
    }       

    $fields = [
        'drugstoreClosed', 
        'drugstoreName_RU', 
        'drugstoreName_UA', 
        'drugstoreAddress_RU', 
        'drugstoreAddress_UA', 
        'drugstoreTelephone', 
        'drugstoreFax', 
        'drugstoreGeoCode',         
        'drugstoreGmapsLink', 
        'drugstoreOpen', 
        'drugstoreOpenStruct', 
        'drugstoreSortOrder', 
        'drugstoreCanSellDrugs'
    ];

    foreach ($fields as $field){
        if (!isset($data[$field])){
             throw new HttpBadRequestException($request, "No $field field provided");
        }
    }

    if ($drugstore = $modelDrugstore->editDrugstore($args['id'], $data)){
        $payload = ['success' => true, 'data' => $drugstore];
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    } else {
        throw new HttpNotImplementedException($request, "Drugstore not exist");
    }
});

$restApp->delete('/drugstores/{id}', function (Request $request, Response $response, array $args) use ($modelDrugstore) {
    if ($drugstore = $modelDrugstore->deleteDrugstore($args['id'])){
        $payload = ['success' => true, 'data' => $drugstore];
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    } else {
        throw new HttpNotImplementedException($request, "Drugstore not deleted");
    }
});


/*************************************************************************************
* 
* PRICES
* 
/*********************************************************************************/

/*********************************************************************************/
/*
    Point to set prices for any
*/
$restApp->put('/prices/', function (Request $request, Response $response, array $args) use ($modelPrice) {
    $body = $request->getBody()->getContents();
    $data = json_decode($body, true);
    if (!is_array($data)) {
        throw new HttpBadRequestException($request, "Invalid JSON body");
    }

    if ($prices = $modelPrice->updatePrices($data)){        
        $payload = ['success' => true, 'data' => $prices];
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
    } else {
        throw new HttpNotFoundException($request, 'Fail happened');
    }

    return $response;
});

/*************************************************************************************
 * 
 * STOCKS
 * 
 /*********************************************************************************/
/*
    Point to get stocks for product
*/

$restApp->get('/stocks/{id}', function (Request $request, Response $response, array $args) use ($modelStocks) {
    if ($product_stocks = $modelStocks->getProductStocks($args['id'])){
         $payload = ['success' => true, 'data' => $product_stocks];
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    } else {
        throw new HttpNotFoundException($request, 'No product ' . $args['id'] . ' stocks available now');
    }   

    return $response;
});

 /*********************************************************************************/
/*
    Point to set stocks for any
*/
$restApp->put('/stocks/', function (Request $request, Response $response, array $args) use ($modelStocks) {
    $log = new \Log('rest-api/put-batch-stocks.log');
    $body = $request->getBody()->getContents();
    $log->write($body);

    $data = json_decode($body, true);
    if (!is_array($data)) {
        throw new HttpBadRequestException($request, "Invalid JSON body");
    }

    if ($stocks = $modelStocks->updateStocks($data)){        
        $payload = ['success' => true, 'data' => $stocks];
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
    } else {
        throw new HttpNotFoundException($request, 'Fail happened');
    }

    return $response;
});

 /*********************************************************************************/
/*
    Point to set stocks for product
*/
$restApp->put('/stocks/{id}', function (Request $request, Response $response, array $args) use ($modelStocks) {
    $log = new \Log('rest-api/put-id-stocks.log');
    $body = $request->getBody()->getContents();
    $log->write($body);

    $data = json_decode($body, true);
    if (!is_array($data)) {
        throw new HttpBadRequestException($request, "Invalid JSON body");
    }

    if ($stocks = $modelStocks->updateProductStocks($args['id'], $data)){        
        $payload = ['success' => true, 'data' => $stocks];
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
    } else {
        throw new HttpNotFoundException($request, 'Product ' . $args['id'] . ' not found');
    }

    return $response;
});



/*************************************************************************************
 * 
 * ORDER STATUSES
 * 
 /*********************************************************************************/

/*
    Point to get order status list
*/
$restApp->get('/order-statuses/', function (Request $request, Response $response, array $args) use ($modelOrder) {
    if ($order_statuses = $modelOrder->getOrderStatuses()){
        $payload = ['success' => true, 'data' => $order_statuses];
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    } else {
        throw new HttpNotFoundException($request, 'No order statuses available now');
    }   

    return $response;
});


/*************************************************************************************
 * 
 * ORDERS 
 * 
 /*********************************************************************************/

/*
    Point to get unpassed or modified orders
*/
$restApp->get('/orders/{location_uuid}', function (Request $request, Response $response, array $args) use ($modelOrder) {
    if ($orders = $modelOrder->getOrders($args['location_uuid'])){
        $payload = ['success' => true, 'data' => $orders];
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    } else {
        throw new HttpNotFoundException($request, 'No orders available now');
    }   

    return $response;
});


/*
    Point to add order
*/
$restApp->post('/orders/', function (Request $request, Response $response, array $args) use ($modelOrder) {
    
});

/*
    Point to modify order
*/
$restApp->patch('/orders/{order_id}', function (Request $request, Response $response, array $args) use ($modelOrder) {
   
});

/*
    Point to add any order history
*/
$restApp->patch('/orders/{order_id}/history', function (Request $request, Response $response, array $args) use ($modelOrder) {
    $body = $request->getBody()->getContents();
    $data = json_decode($body, true);
    if (!is_array($data)) {
        throw new HttpBadRequestException($request, "Invalid JSON body");
    }

    if ($order = $modelOrder->getOrder($args['order_id'])){
        if (empty($data['orderStatusID'])){
            throw new HttpBadRequestException($request, "No orderUUID field provided");
        }    

        $updated_order = $modelOrder->addOrderHistory($args['order_id'], $data);

        if ($updated_order){
            $payload = ['success' => true, 'data' => $updated_order];
            $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
        } else {
            throw new HttpException($request, "Nothing updated");
        }
    } else {
        throw new HttpNotFoundException($request, 'Order with ID ' . $args['order_id'] . ' not found');
    }

    return $response;
});

/*
    Point to confirm of getting order
*/
$restApp->patch('/orders/{order_id}/confirm', function (Request $request, Response $response, array $args) use ($modelOrder) {
    $log = new \Log('rest-api/patch-confirm-id-order.log');
    $body = $request->getBody()->getContents();
    $log->write($body);
    
    $data = json_decode($body, true);
    if (!is_array($data)) {
        throw new HttpBadRequestException($request, "Invalid JSON body");
    }

    if ($order = $modelOrder->getOrder($args['order_id'])){
        if (empty($data['orderUUID'])){
            throw new HttpBadRequestException($request, "No orderUUID field provided");
        }

        if (empty($data['orderMSID'])){
            throw new HttpBadRequestException($request, "No orderMSID field provided");
        }

        $updated_order = $modelOrder->confirmOrder($args['order_id'], $data);

        if ($updated_order){
            $payload = ['success' => true, 'data' => $updated_order];
            $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
        } else {
            throw new HttpException($request, "Nothing updated");
        }
    } else {
        throw new HttpNotFoundException($request, 'Order with ID ' . $args['order_id'] . ' not found');
    }

    return $response;
});


$restApp->run();

