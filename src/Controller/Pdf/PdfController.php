<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller\Pdf;

use Endroid\Pdf\Pdf;
use Endroid\Pdf\Response\InlinePdfResponse;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PdfController
{
    private $pdf;

    public function __construct(Pdf $pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * @Route("/pdf")
     */
    public function __invoke(): Response
    {
        // Tweak margin and spacing
        $this->pdf->setOptions([
            'margin-top' => 17,
            'margin-bottom' => 16,
            'header-spacing' => 5,
            'footer-spacing' => 5,
        ]);

        $this->pdf->setCover(CoverController::class);
        $this->pdf->setTableOfContents('pdf/table_of_contents.xml.twig');
        $this->pdf->setHeader('pdf/header.html.twig');
        $this->pdf->setFooter('pdf/footer.html.twig');
        $this->pdf->setContent(ContentController::class);

        return new InlinePdfResponse($this->pdf);
    }
}
