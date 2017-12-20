<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $pageTranslations = $this->getDoctrine()->getRepository('PageBundle:PageTranslation')->findAll();

        return [
            'pageTranslations' => $pageTranslations,
        ];
    }

    /**
     * @Route("/cached")
     * @Template()
     * @Cache(smaxage="15")
     */
    public function cachedAction()
    {
        return [
            'time' => time(),
        ];
    }

    /**
     * @Route("/pages")
     * @Template()
     */
    public function pagesAction()
    {
        $pageTranslations = $this->getDoctrine()->getRepository('PageBundle:PageTranslation')->findAll();

        return [
            'pageTranslations' => $pageTranslations,
        ];
    }
}
