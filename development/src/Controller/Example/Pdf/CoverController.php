<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller\Example\Pdf;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class CoverController
{
    private $templating;

    public function __construct(Environment $templating)
    {
        $this->templating = $templating;
    }

    /**
     * @Route("/pdf/cover")
     */
    public function __invoke(): Response
    {
        return new Response($this->templating->render('example/pdf/cover.html.twig', [
            'title' => 'PDF Document',
            'date' => strftime('%B %e, %Y', time()),
        ]));
    }
}