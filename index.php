<?php
use App\Container\Container;
use App\Config\Config;
use App\Database\Database;
use App\Controller\HomeController;


require_once __DIR__ . '/vendor/autoload.php';

$container = new Container;
/* $container->singleTon(Config::class,function($container){
    return new Config;
}); */

dump($container->get(HomeController::class)->index());