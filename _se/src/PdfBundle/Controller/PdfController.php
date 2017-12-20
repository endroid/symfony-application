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
     * @Route("/rebuild")
     *
     * @param bool $force
     *
     * @return Response
     */
    public function rebuildAction($force = true)
    {
        $this->coverAction($force);
        $this->tocAction($force);
        $this->contentAction($force);
        $this->headerAction($force);
        $this->footerAction($force);

        return new Response('');
    }

    /**
     * @Route("/cover")
     *
     * @param bool $forceRebuild
     *
     * @return Response
     */
    public function coverAction($forceRebuild = false)
    {
        $path = $this->getPath('cover.html');

        if (!$forceRebuild && $this->isProductionEnvironment() && file_exists($path)) {
            return new Response($this->fixPaths(file_get_contents($path), true));
        }

        $response = $this->render('PdfBundle:Pdf:cover.html.twig', [
            'title' => 'PDF Document',
            'date' => strftime('%B %e, %Y', time()),
        ]);

        file_put_contents($path, $this->fixPaths($response->getContent()));

        return $response;
    }

    /**
     * @Route("/toc")
     *
     * @param bool $forceRebuild
     *
     * @return Response
     */
    public function tocAction($forceRebuild = false)
    {
        $path = $this->getPath('toc.xml');

        if (!$forceRebuild && $this->isProductionEnvironment() && file_exists($path)) {
            return new Response($this->fixPaths(file_get_contents($path), true));
        }

        $response = $this->render('PdfBundle:Pdf:toc.xml.twig');

        file_put_contents($path, $this->fixPaths($response->getContent()));

        return $response;
    }

    /**
     * @Route("/content")
     *
     * @param bool $forceRebuild
     *
     * @return Response
     */
    public function contentAction($forceRebuild = false)
    {
        $path = $this->getPath('content.html');

        if (!$forceRebuild && $this->isProductionEnvironment() && file_exists($path)) {
            return new Response($this->fixPaths(file_get_contents($path), true));
        }

        $intro = [
            'title' => 'Introduction',
            'content' => $this->generateRandomContent(5),
        ];

        $items = $this->getRandomItems(10, 5);

        $response = $this->render('PdfBundle:Pdf:content.html.twig', [
            'intro' => $intro,
            'items' => $items,
        ]);

        file_put_contents($path, $this->fixPaths($response->getContent()));

        return $response;
    }

    /**
     * @Route("/header")
     */
    public function headerAction($forceRebuild = false)
    {
        $path = $this->getPath('header.html');

        if (!$forceRebuild && $this->isProductionEnvironment() && file_exists($path)) {
            return new Response($this->fixPaths(file_get_contents($path), true));
        }

        $response = $this->render('PdfBundle:Pdf:header.html.twig');

        file_put_contents($path, $this->fixPaths($response->getContent()));

        return $response;
    }

    /**
     * @Route("/footer")
     */
    public function footerAction($forceRebuild = false)
    {
        $path = $this->getPath('footer.html');

        if (!$forceRebuild && $this->isProductionEnvironment() && file_exists($path)) {
            return new Response($this->fixPaths(file_get_contents($path), true));
        }

        $response = $this->render('PdfBundle:Pdf:footer.html.twig');

        file_put_contents($path, $this->fixPaths($response->getContent()));

        return $response;
    }

    /**
     * Generates random items.
     *
     * @param $itemCount
     * @param $subCount
     *
     * @return array
     */
    public function getRandomItems($itemCount, $subCount)
    {
        $items = [];

        for ($i = 0; $i < $itemCount; ++$i) {
            $item = [
                'id' => 'item-'.$i,
                'title' => 'Section '.($i + 1),
                'content' => $this->generateRandomContent(rand(5, 20)),
            ];
            $item['subs'] = [];
            for ($j = 0; $j < $subCount; ++$j) {
                $sub = [
                    'title' => 'Sub section '.($i + 1).'.'.($j + 1),
                    'content' => $this->generateRandomContent(rand(5, 20)),
                ];
                $sub['content'] .= $this->generateRandomTable(4, 25, 50);
                $item['subs'][] = $sub;
            }
            $items[] = $item;
        }

        return $items;
    }

    /**
     * Generates random content.
     *
     * @param $paragraphCount
     *
     * @return string
     */
    public function generateRandomContent($paragraphCount)
    {
        $paragraphs = [
            'Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits. Dramatically visualize customer directed convergence without revolutionary ROI.',
            'Phosfluorescently engage worldwide methodologies with web-enabled technology. Interactively coordinate proactive e-commerce via process-centric "outside the box" thinking. Completely pursue scalable customer service through sustainable potentialities. Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas. Dramatically maintain clicks-and-mortar solutions without functional solutions.',
            'Completely synergize resource sucking relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas. Dynamically innovate resource-leveling customer service for state of the art customer service.',
            'Collaboratively administrate turnkey channels whereas virtual e-tailers. Objectively seize scalable metrics whereas proactive e-services. Seamlessly empower fully researched growth strategies and interoperable internal or "organic" sources. Objectively innovate empowered manufactured products whereas parallel platforms. Holisticly predominate extensible testing procedures for reliable supply chains. Dramatically engage top-line web services vis-a-vis cutting-edge deliverables.',
            'Credibly innovate granular internal or "organic" sources whereas high standards in web-readiness. Energistically scale future-proof core competencies vis-a-vis impactful experiences. Dramatically synthesize integrated schemas with optimal networks. Proactively envisioned multimedia based expertise and cross-media growth strategies. Seamlessly visualize quality intellectual capital without superior collaboration and idea-sharing. Holistically pontificate installed base portals after maintainable products.',
        ];

        while (count($paragraphs) < $paragraphCount) {
            $paragraphs = array_merge($paragraphs, $paragraphs);
        }

        shuffle($paragraphs);

        $randomContent = '';
        for ($i = 0; $i < $paragraphCount; ++$i) {
            $randomContent .= '<p>'.$paragraphs[$i].'</p>';
        }

        return $randomContent;
    }

    /**
     * Generates a random table.
     *
     * @param $columnCount
     * @param $minRowCount
     * @param $maxRowCount
     *
     * @return string
     */
    public function generateRandomTable($columnCount, $minRowCount, $maxRowCount)
    {
        $randomTable = '<table>';

        $rowCount = rand($minRowCount, $maxRowCount);

        $randomTable .= '<thead>';
        $randomTable .= '<tr>';
        for ($col = 0; $col < $columnCount; ++$col) {
            $randomTable .= '<th>column '.($col + 1).'</th>';
        }
        $randomTable .= '</tr>';
        $randomTable .= '</thead>';

        $randomTable .= '<tbody>';
        for ($row = 0; $row < $rowCount; ++$row) {
            $randomTable .= '<tr>';
            for ($col = 0; $col < $columnCount; ++$col) {
                $randomTable .= '<td>'.($row + 1).' - '.($col + 1).'</td>';
            }
            $randomTable .= '</tr>';
        }
        $randomTable .= '</tbody>';

        $randomTable .= '</table>';

        return $randomTable;
    }

    /**
     * Returns the path where the file is cached.
     *
     * @param $filename
     *
     * @return string
     */
    public function getPath($filename)
    {
        return $this->get('kernel')->getCacheDir().'/'.$filename;
    }

    /**
     * Checks if we are in the production environment.
     *
     * @return bool
     */
    public function isProductionEnvironment()
    {
        $environment = $this->get('kernel')->getEnvironment();

        return $environment == 'prod';
    }

    /**
     * Fix relative paths to resources.
     *
     * @param $content
     * @param bool $reverse
     *
     * @return mixed
     */
    public function fixPaths($content, $reverse = false)
    {
        $replaces = [
            '/bundles/pdf/' => 'file://'.$this->get('kernel')->getRootDir().'/../web/bundles/pdf/',
        ];

        if ($reverse) {
            $replaces = array_combine(array_values($replaces), array_keys($replaces));
        }

        $content = str_replace(array_keys($replaces), $replaces, $content);

        return $content;
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
