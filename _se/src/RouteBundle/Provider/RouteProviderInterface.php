<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace RouteBundle\Provider;

interface RouteProviderInterface
{
    /**
     * Returns the available routes.
     *
     * @return array
     */
    public function getRoutes();
}
