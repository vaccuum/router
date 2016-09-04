<?php namespace Vaccuum\Router;

use Closure;
use Vaccuum\Contracts\Router\IRoute;

class Route implements IRoute
{
    /** @var array */
    protected $methods;

    /** @var string */
    protected $path;

    /** @var array */
    protected $handler;

    /**
     * Route constructor.
     *
     * @param string|array  $methods
     * @param string        $path
     * @param Closure|array $handler
     */
    public function __construct($methods, $path, $handler)
    {
        $this->methods = (is_array($methods)) ? $methods : [$methods];
        $this->path = $path;
        $this->handler = $handler;
    }

    /** @inheritdoc */
    public function methods()
    {
        return $this->methods;
    }

    /** @inheritdoc */
    public function path()
    {
        return $this->path;
    }

    /** @inheritdoc */
    public function data()
    {
        return $this->handler;
    }
}