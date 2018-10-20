<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller\Example;

use Swift_Mailer;
use Swift_Message;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class EmailController
{
    private $mailer;
    private $templating;
    private $session;
    private $router;

    public function __construct(Swift_Mailer $mailer, Environment $templating, SessionInterface $session, RouterInterface $router)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->session = $session;
        $this->router = $router;
    }

    /**
     * @Route("/example/email", name="example_email")
     */
    public function __invoke(): Response
    {
        $message = new Swift_Message('Example email');
        $message->setFrom('info@endroid.nl');
        $message->setBody($this->templating->render('example/email.html.twig'), 'text/html');
        $message->setTo('info@endroid.nl');

        $this->mailer->send($message);
        $this->session->getFlashBag()->add('info', 'Example email sent');

        return new RedirectResponse($this->router->generate('home'));
    }
}
