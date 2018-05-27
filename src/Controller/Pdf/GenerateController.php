<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller\Pdf;

use Endroid\Asset\CacheAsset;
use Endroid\Asset\Factory\AssetFactory;
use Endroid\Pdf\Builder\PdfBuilder;
use Endroid\Pdf\Response\InlinePdfResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenerateController
{
    private $pdfBuilder;
    private $assetFactory;

    public function __construct(PdfBuilder $pdfBuilder, AssetFactory $assetFactory)
    {
        $this->pdfBuilder = $pdfBuilder;
        $this->assetFactory = $assetFactory;
    }

    /**
     * @Route("/pdf")
     */
    public function __invoke(): Response
    {
        $this->pdfBuilder
            ->setCover([
                'cache_key' => 'cover',
                'controller' => CoverController::class,
            ])
            ->setTableOfContents([
                'cache_key' => 'toc',
                'template' => 'pdf/table_of_contents.xml.twig',
            ])
            ->setHeader([
                'template' => 'pdf/header.html.twig',
                'cache_key' => 'header',
            ])
            ->setFooter([
                'template' => 'pdf/footer.html.twig',
                'cache_key' => 'footer',
            ])
            ->setContent([
                'controller' => ContentController::class,
                'cache_key' => 'content',
            ])
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
