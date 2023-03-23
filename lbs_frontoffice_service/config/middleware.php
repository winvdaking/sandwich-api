<?php

namespace config;

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use frontoffice\errors\renderer\ErrorRenderer;

return function (App $app) {
    $app->addBodyParsingMiddleware();

    $app->addRoutingMiddleware();

    $errorMiddleware = $app->addErrorMiddleware(true, true, true);
    $errorHandler = $errorMiddleware->getDefaultErrorHandler();
    $errorHandler->registerErrorRenderer('application/json', ErrorRenderer::class);
    $errorHandler->forceContentType('application/json');

    $errorMiddleware->setErrorHandler(HttpMethodNotAllowedException::class, function (Request $request, \Throwable $exception, bool $displayErrorDetails): Response
    {
        $response = new Response();
        $response->getBody()->write('405 method not allowed.');
    
        return $response->withStatus(405);
    });
};
