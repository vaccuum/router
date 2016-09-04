<?php namespace Vaccuum\Router\Traits;

use Vaccuum\Contracts\Config\IConfig;
use Vaccuum\Contracts\Router\RouterException;

trait TRouterConfiguration
{
    /**
     * Create routes from config.
     *
     * @param IConfig $config
     *
     * @throws RouterException
     * @return void
     */
    protected function configure(IConfig $config)
    {
        $configuration = $config->get('routes');

        foreach ($configuration as $route)
        {
            $this->map($route);
        }
    }
}