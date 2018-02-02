<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

final class HomeController
{
    /**
     * @Route("/", name="home")
     */
    public function __invoke(Environment $twig): Response
    {
//        $platinumBlonde = Board::createFromString('
//            000000012
//            000000003
//            002300400
//            001800005
//            060070800
//            000009000
//            008500000
//            900040500
//            470006000
//        ');
//
//        $solveWithoutGuessing = Board::createFromString('
//            003020600
//            900305001
//            001806400
//            008102900
//            700000008
//            006708200
//            002609500
//            800203009
//            005010300
//        ');
//
//        $sudoku = $platinumBlonde;
//        $solver = new Solver($sudoku);
//        $solver->solve(true);
//
//        echo $sudoku->toHtmlString();
//        die;
//
//        $boardBuilder = new BoardBuilder();



        return new Response($twig->render('home.html.twig'));
    }
}
