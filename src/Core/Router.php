<?php
/**
 * Gabyfle
 * index.php
 *
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */

namespace Gabyfle\Core;

use Gabyfle\Controllers\ErrorController;

/**
 * Class Router
 * A very (very [very]) light router class to handle some requests from an user
 * @package Gabyfle\Core
 */
class Router
{
    private $requestUrl;
    private $routes;
    private $controllers;

    public function __construct()
    {
        $request = $_SERVER['REQUEST_URI'];
        $uri = explode('?', $request)[0];
        $this->requestUrl = $uri;
    }

    /**
     * setRoutes
     * Sets up the routes and the controllers associated to the routes.
     * @param array $routes
     * @param array $controllers
     */
    public function setRoutes(array $routes, array $controllers)
    {
        $this->routes = $routes;
        $this->controllers = $controllers;
    }

    /**
     * handle
     * Launch a controller if the request url is matching with the route's name.
     * @param string $name
     * @param string $controller
     */
    public function handle()
    {
        foreach ($this->routes as $id => $route) {
            if ('/' . $route === $this->requestUrl) {
                $className = 'Gabyfle\Controllers\\' . $this->controllers[$id];
                $controller = new $className();
                $controller->run();

                return;
            }
        }

        $controller = new ErrorController();
        $controller->run();
    }
}