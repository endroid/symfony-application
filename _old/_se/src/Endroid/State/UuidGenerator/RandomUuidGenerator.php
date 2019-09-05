<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\State\UuidGenerator;

use Ramsey\Uuid\Uuid;

class RandomUuidGenerator implements UuidGeneratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        return (string) Uuid::uuid4();
    }
}
