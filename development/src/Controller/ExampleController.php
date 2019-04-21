<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Example;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExampleController extends AbstractController
{
    /**
     * @Route("/examples", name="example_index")
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Example::class);
        $examples = $repository->findAll();

        return $this->render('example/index.html.twig', [
            'examples' => $examples,
        ]);
    }

    /**
     * @Route("/example/{id}", name="example_detail")
     */
    public function detail(Example $example): Response
    {
        return $this->render('example/detail.html.twig', [
            'example' => $example,
        ]);
    }
}
