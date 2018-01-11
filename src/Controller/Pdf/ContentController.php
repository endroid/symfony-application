<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller\Pdf;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

final class ContentController
{
    private $templating;

    public function __construct(Environment $templating)
    {
        $this->templating = $templating;
    }

    /**
     * @Route("/pdf/content")
     */
    public function __invoke(): Response
    {
        $intro = [
            'title' => 'Introduction',
            'content' => $this->generateRandomContent(5),
        ];

        $items = $this->getRandomItems(10, 5);

        return new Response($this->templating->render('pdf/content.html.twig', [
            'intro' => $intro,
            'items' => $items,
        ]));
    }

    private function getRandomItems(int $itemCount, int $subCount): array
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

    private function generateRandomContent(int $paragraphCount): string
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

    public function generateRandomTable(int $columnCount, int $minRowCount, int $maxRowCount): string
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
}