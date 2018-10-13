<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Traits;

use Twig\Environment;

trait TemplatingTrait
{
    /**
     * @var Environment
     */
    private $templating;

    /**
     * @required
     *
     * @param Environment $templating
     *
     * @return self
     */
    public function setTwig(Environment $templating): self
    {
        $this->templating = $templating;

        return $this;
    }
}
