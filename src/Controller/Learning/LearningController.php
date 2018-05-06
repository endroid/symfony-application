<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller\Learning;

use Phpml\Regression\SVR;
use Phpml\SupportVectorMachine\Kernel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class LearningController
{
    /**
     * @Route("/learning")
     */
    public function __invoke(KernelInterface $kernel): Response
    {
        $url = 'https://www.cryptocompare.com/api';

        $data = [];
        $data[] = [[0.25, 0.25, 0.30, 0.25], 0.25];

        $labels = [];
        $samples = [];
        foreach ($data as $values) {
            $labels[] = $values[1];
            $samples[] = $values[0];
        }

        $classifier = new SVR(Kernel::RBF);
        $classifier->setVarPath($kernel->getCacheDir());
        $classifier->train($samples, $labels);

        $predictions = $classifier->predict([0.25, 0.25, 0.30, 0.25]);

        dump($predictions);
        die;
    }
}