<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller\Pdf;

use Endroid\Pdf\Factory\AssetFactory;
use Endroid\Pdf\Pdf;
use Endroid\Pdf\Response\InlinePdfResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PdfController
{
    private $assetFactory;
    private $pdf;

    public function __construct(AssetFactory $assetFactory, Pdf $pdf)
    {
        $this->assetFactory = $assetFactory;
        $this->pdf = $pdf;
    }

    /**
     * @Route("/pdf")
     */
    public function __invoke(): Response
    {
        $this->pdf->setCover($this->assetFactory->create([
            'controller' => CoverController::class,
            'cache' => 'cover',
        ]));
        $this->pdf->setTableOfContents($this->assetFactory->create([
            'template' => 'pdf/table_of_contents.xml.twig',
            'cache' => 'toc',
        ]));
        $this->pdf->setHeader($this->assetFactory->create([
            'template' => 'pdf/header.html.twig',
            'cache' => 'header',
        ]));
        $this->pdf->setFooter($this->assetFactory->create([
            'template' => 'pdf/footer.html.twig',
            'cache' => 'footer',
        ]));
        $this->pdf->setContent($this->assetFactory->create([
            'controller' => ContentController::class,
            'cache' => 'content',
        ]));
        $this->pdf->setOptions([
            'margin-top' => 16,
            'margin-bottom' => 16,
            'header-spacing' => 5,
            'footer-spacing' => 5,
        ]);

        return new InlinePdfResponse($this->pdf);
    }
}
