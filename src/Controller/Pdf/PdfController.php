<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller\Pdf;

use Endroid\Pdf\Builder\PdfBuilder;
use Endroid\Pdf\Response\InlinePdfResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PdfController
{
    private $pdfBuilder;

    public function __construct(PdfBuilder $pdfBuilder)
    {
        $this->pdfBuilder = $pdfBuilder;
    }

    /**
     * @Route("/pdf")
     */
    public function __invoke(): Response
    {
        $this->pdfBuilder
            ->setCover(['controller' => CoverController::class, 'cache' => 'cover'])
            ->setTableOfContents(['template' => 'pdf/table_of_contents.xml.twig', 'cache' => 'toc'])
            ->setHeader(['template' => 'pdf/header.html.twig', 'cache' => 'header'])
            ->setFooter(['template' => 'pdf/footer.html.twig', 'cache' => 'footer'])
            ->setContent(['controller' => ContentController::class, 'cache' => 'content'])
            ->setOptions([
                'margin-top' => 16,
                'margin-bottom' => 16,
                'header-spacing' => 5,
                'footer-spacing' => 5,
            ])
        ;

        return new InlinePdfResponse($this->pdfBuilder->getPdf());
    }
}
