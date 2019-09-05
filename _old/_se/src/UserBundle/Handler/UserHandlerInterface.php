<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace UserBundle\Handler;

interface UserHandlerInterface
{
    /**
     * Get a User given the identifier.
     *
     * @api
     *
     * @param mixed $id
     *
     * @return UserInterface
     */
    public function get($id);
}
