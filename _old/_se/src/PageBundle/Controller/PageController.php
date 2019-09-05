<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PageBundle\Controller;

use PageBundle\Entity\PageTranslation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    /**
     * @Route("/{slug}")
     * @Template()
     *
     * @param PageTranslation $pageTranslation
     *
     * @return Response|array
     */
    public function showAction(PageTranslation $pageTranslation)
    {
        return [
            'pageTranslation' => $pageTranslation,
        ];
    }
}
