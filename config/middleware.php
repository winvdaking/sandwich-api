<?php

namespace config;

use Slim\App;

return function (App $app) {
    $app->addBodyParsingMiddleware();

    $app->addRoutingMiddleware();

    $app->addErrorMiddleware(true, true, true);
};
