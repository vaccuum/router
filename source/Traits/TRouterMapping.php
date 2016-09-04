<?php namespace Vaccuum\Router\Traits;

use Vaccuum\Contracts\Router\IRoute;
use Vaccuum\Contracts\Router\RouterException;
use Vaccuum\Router\Route;

trait TRouterMapping
{
    /** @inheritdoc */
    public function map(array $data)
    {
        if (!isset($data['method']))
        {
            $message = "Missing required route method parameter.";
            throw new RouterException($message, $data);
        }

        if (!isset($data['path']))
        {
            $message = "Missing required route path parameter.";
            throw new RouterException($message, $data);
        }

        $handlerData = [];

        $handlerData['action'] =
            (isset($data['action'])) ? $data['action'] : '';

        $handlerData['controller'] =
            (isset($data['controller'])) ? $data['controller'] : '';

        $handlerData['middleware'] =
            (isset($data['middleware'])) ? $data['middleware'] : [];

        $handlerData['extras'] =
            (isset($data['extras'])) ? $data['extras'] : [];

        $this->push(
            new Route(
                $data['method'],
                $data['path'],
                $handlerData
            )
        );
    }

    /** @inheritdoc */
    public function push(IRoute $route)
    {
        $this->routes[] = $route;
    }
}