<?php namespace Vaccuum\Router;

use Closure;
use FastRoute\Dispatcher;
use Vaccuum\Contracts\Router\IRouteInfo;

class RouteInfo implements IRouteInfo
{
    /** @var bool */
    protected $found;

    /** @var bool */
    protected $allowed;

    /** @var array */
    protected $arguments = [];

    /** @var Closure|string */
    protected $action;

    /** @var string */
    protected $controller;

    /** @var array */
    protected $middleware;

    /** @var mixed */
    protected $extras;

    /**
     * RouteInfo constructor.
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->found = ($data[0] == Dispatcher::FOUND);
        $this->allowed = !($data[0] == Dispatcher::METHOD_NOT_ALLOWED);

        if ($this->found())
        {
            $this->arguments = $data[2];
            $this->action = $data[1]['action'];
            $this->controller = $data[1]['controller'];
            $this->middleware = $data[1]['middleware'];
            $this->extras = $data[1]['extras'];
        }
    }

    /** @inheritdoc */
    public function found()
    {
        return $this->found;
    }

    /** @inheritdoc */
    public function allowed()
    {
        return $this->allowed;
    }

    /** @inheritdoc */
    public function arguments()
    {
        return $this->arguments;
    }

    /** @inheritdoc */
    public function action()
    {
        return $this->action;
    }

    /** @inheritdoc */
    public function controller()
    {
        return $this->controller;
    }

    /** @inheritdoc */
    public function middleware()
    {
        return $this->middleware;
    }

    /** @inheritdoc */
    public function handler()
    {
        if (!is_string($this->action()))
        {
            return $this->action();
        }
        else
        {
            return [$this->controller(), $this->action()];
        }
    }
}