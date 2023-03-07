<?php

namespace config;

use Slim\App;

use orders\errors\renderer\ErrorRenderer;

return function (App $app) {
    $app->addBodyParsingMiddleware();

    $app->addRoutingMiddleware();

    $errorMiddleware = $app->addErrorMiddleware(true, true, true);
    $errorHandler = $errorMiddleware->getDefaultErrorHandler();
    $errorHandler->registerErrorRenderer('application/json', ErrorRenderer::class);
    $errorHandler->forceContentType('application/json');
};
