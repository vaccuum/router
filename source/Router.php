<?php namespace Vaccuum\Router;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Vaccuum\Contracts\Config\IConfig;
use Vaccuum\Contracts\Router\IRoute;
use Vaccuum\Contracts\Router\IRouter;
use Vaccuum\Contracts\Router\RouterException;
use Vaccuum\Router\Traits\TRouterConfiguration;
use Vaccuum\Router\Traits\TRouterMapping;
use function FastRoute\simpleDispatcher;

class Router implements IRouter
{
    use TRouterMapping;
    use TRouterConfiguration;

    /** @var IRoute[] */
    protected $routes = [];

    /** @var Dispatcher */
    protected $dispatcher;

    /**
     * Router constructor.
     *
     * @param IConfig $config
     *
     * @throws RouterException
     */
    public function __construct(IConfig $config)
    {
        $this->configure($config);
    }

    /** @inheritdoc */
    public function match()
    {
        $this->prepareDispatcher();

        $data = $this->dispatcher->dispatch(
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['REQUEST_URI']
        );

        return new RouteInfo($data);
    }

    /**
     * Prepare route dispatcher.
     */
    protected function prepareDispatcher()
    {
        $this->dispatcher = simpleDispatcher(function (RouteCollector $r)
        {
            foreach ($this->routes as $route)
            {
                $r->addRoute(
                    $route->methods(),
                    $route->path(),
                    $route->data()
                );
            }
        });
    }
}