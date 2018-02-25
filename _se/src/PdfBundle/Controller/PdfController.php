<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PdfBundle\Controller;

use iio\libmergepdf\Merger;
use iio\libmergepdf\Pages;
use Knp\Bundle\SnappyBundle\Snappy\LoggableGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PdfController extends Controller
{
    /**
     * @Route("/")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $this->rebuildAction(false);

        /** @var $snappy LoggableGenerator */
        $snappy = $this->get('knp_snappy.pdf');
        $cover = $snappy->getOutput($this->getPath('cover.html'));

        $snappy->setOption('margin-top', '20');
        $snappy->setOption('margin-right', '0');
        $snappy->setOption('margin-bottom', '16');
        $snappy->setOption('margin-left', '0');
        $snappy->setOption('header-html', $this->getPath('header.html'));
        $snappy->setOption('header-spacing', '5');
        $snappy->setOption('footer-html', $this->getPath('footer.html'));
        $snappy->setOption('footer-spacing', '5');
        $snappy->setOption('xsl-style-sheet', $this->getPath('toc.xml'));

        $html = file_get_contents($this->getPath('content.html'));

        if ($request->query->get('ids')) {
            $html = $this->addFilters($html, explode(',', $request->query->get('ids')));
        }

        $contents = $snappy->getOutputFromHtml($html, ['toc' => true]);

        $pdfMerger = new Merger();
        $pdfMerger->addRaw($cover, new Pages('1'));
        $pdfMerger->addRaw($contents);
        $contents = $pdfMerger->merge();

        return new Response($contents, 200, ['Content-Type' => 'application/pdf']);
    }

    /**
     * Filters the HTML to only show the given IDs.
     *
     * @param string $html
     * @param array  $ids
     *
     * @return mixed
     */
    public function addFilters($html, $ids = [])
    {
        $filters = ['.item { display: none; }'];

        foreach ($ids as $id) {
            $filters[] = '#item-'.$id.' { display: block; }';
        }

        return str_replace('<!-- FILTERS_PLACEHOLDER -->', '<style>'.implode(' ', $filters).'</style>', $html);
    }
}
