<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
require '../vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
use React\Socket\ConnectionInterface;
use Spatie\TwitterStreamingApi\PublicStream;
use TwittApp\Router;

//create Router
$router = Router::fromGlobals();
// Add single rule with Closure handler.
$router->add('/', function () {
  echo json_encode(['message' => 'Hello from twittAppClient!']);
});
// Or add array of routes.
$router->add([
  '/add_track/:seg'              => 'TwittApp\Controllers\MainController@addTrack',
//  '/second/:any'        => 'TwittApp\Controllers\MainController@secondAction',
]);
// Start route processing
if ($router->isFound()) {
  $router->executeHandler(
    $router->getRequestHandler(),
    $router->getParams()
  );
}
else {
  // Simple "Not found" handler
  $router->executeHandler(function () {
    http_response_code(404);
    echo '404 Not found';
  });
}
