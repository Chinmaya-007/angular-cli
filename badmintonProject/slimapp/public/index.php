<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header('Content-Type: application/json; charset=UTF-8');
header("Access-Control-Allow-Headers: origin, x-requested-with, content-type, authorization");


require __DIR__ . '/../vendor/autoload.php';
require '../src/config/connection.php';
use \Firebase\JWT\JWT;





$app = new \Slim\App(['settings' => ['displayErrorDetails' => true]]);

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

//routes
require '../src/routes/student.php';
$app->run();
?>