<?php
use Slim\Factory\AppFactory;
require_once __DIR__ . '/../vendor/autoload.php';

//$config = parse_ini_file('config.ini');

$config = [
    'driver'    => 'mysql',
    'host'      => 'order.db',
    'database'  => 'order_lbs',
    'username'  => 'order_lbs',
    'password'  => 'order_lbs',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
];

$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection($config);
$db->setAsGlobal();
$db->bootEloquent();

$app = AppFactory::create();
(require __DIR__ . '/routes.php')($app);
(require __DIR__ . '/middleware.php')($app);

return $app;
