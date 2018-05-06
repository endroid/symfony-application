<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller\Mail;

use Swift_Mailer;
use Swift_Message;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class SendController
{
    private $mailer;
    private $templating;

    public function __construct(Swift_Mailer $mailer, Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * @Route("/mail/send", name="mail_send")
     */
    public function __invoke(): Response
    {
        $message = new Swift_Message('This is the subject');
        $message->setFrom('info@endroid.nl');
        $message->setBody($this->templating->render('mail/message.html.twig'), 'text/html');
        $message->setTo('info@endroid.nl');

        $this->mailer->send($message);

        return new Response($this->templating->render('mail/send.html.twig'));
    }
}
