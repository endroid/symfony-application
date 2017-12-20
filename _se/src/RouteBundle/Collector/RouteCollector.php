<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace RouteBundle\Collector;

use RouteBundle\Provider\RouteProviderInterface;

class RouteCollector
{
    /**
     * @var RouteProviderInterface[]
     */
    protected $providers;

    /**
     * @var array
     */
    protected $routes;

    /**
     * @var bool
     */
    protected $routesLoaded = false;

    /**
     * Creates a new instance.
     */
    public function __construct()
    {
        $this->providers = [];
        $this->routes = [];
    }

    /**
     * Adds a provider.
     *
     * @param RouteProviderInterface $provider
     */
    public function addProvider(RouteProviderInterface $provider)
    {
        $this->providers[] = $provider;
    }

    /**
     * Returns the routes.
     *
     * @return array
     */
    public function getRoutes()
    {
        $this->loadRoutes();

        return $this->routes;
    }

    /**
     * Returns the route with the corresponding key.
     *
     * @param $key
     */
    public function getRouteByKey($key)
    {
        $this->loadRoutes();

        if (!array_key_exists($key, $this->routes)) {
            return;
        }

        return $this->routes[$key];
    }

    /**
     * Loads the routes.
     */
    public function loadRoutes()
    {
        if ($this->routesLoaded) {
            return;
        }

        foreach ($this->providers as $provider) {
            $this->routes = array_merge($this->routes, $provider->getRoutes());
        }
        $this->routesLoaded = true;
    }
}
