<?php

namespace config;

require_once __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$config = parse_ini_file('config.db.ini');

$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection($config);
$db->setAsGlobal();
$db->bootEloquent();

$app = AppFactory::create();

(require __DIR__ . '/middleware.php')($app);
(require __DIR__ . '/routes.php')($app);

return $app;