<?php
/**
 * Gabyfle
 * index.php
 *
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */
session_start();
define('DOCUMENT_ROOT', '../');
require_once DOCUMENT_ROOT . 'vendor/autoload.php';

use Gabyfle\Core\Language;
use Gabyfle\Core\Router;
use Gabyfle\Core\Configuration;
use Gabyfle\Core\Database;

try {
    $config = Configuration::build(DOCUMENT_ROOT . 'config.php');
    $database = $config->get('database');
    Database::build($database['host'], $database['dbname'], $database['dbuser'], $database['dbpass']);
    Language::build($config->get('site')['language']);
} catch (Exception $e) {
    echo 'An error occurred while trying to init the app : ' . $e;
}

$router = new Router();

/* Setting up the routes and controllers which will be used */
$routes = [
    'home',
    'login',
    'logout',
    'admin'
];

$controllers = [
    'HomeController',
    'LoginController',
    'LogoutController',
    'AdminController'
];

$router->setRoutes($routes, $controllers);
$router->handle();
