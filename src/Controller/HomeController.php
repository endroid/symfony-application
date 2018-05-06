<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller;

use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Twig\Environment;

class HomeController
{
    private $session;
    private $templating;

    public function __construct(SessionInterface $session, Environment $templating)
    {
        $this->session = $session;
        $this->templating = $templating;
    }

    /**
     * @Route("/", name="home")
     */
    public function __invoke(Request $request, UserManagerInterface $userManager): Response
    {
//        $token = unserialize($this->session->get('_security_main'));
//        echo serialize($token);
//        die;

//        $email = 'info@endroid.nl';
//
//        $user = $userManager->findUserBy(['email' => $email]);
//
//        $newToken = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
//        dump(serialize($newToken));
//        die;
//
//        die;
//
//        $string = 'C:74:"Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken":609:{a:3:{i:0;N;i:1;s:4:"main";i:2;s:569:"a:4:{i:0;C:15:"App\Entity\User":238:{a:8:{i:0;s:60:"$2y$13$1cNWHgjbg7xJv.idT4GVHuu7xWVd5PrDC8M.PV3fYX9/SJVb0fKYe";i:1;N;i:2;s:10:"superadmin";i:3;s:10:"superadmin";i:4;b:1;i:5;s:36:"2c65cb56-1c62-11e8-b5db-0242ac130002";i:6;s:15:"info@endroid.nl";i:7;s:15:"info@endroid.nl";}}i:1;b:1;i:2;a:2:{i:0;O:41:"Symfony\Component\Security\Core\Role\Role":1:{s:47:"\x00Symfony\Component\Security\Core\Role\Role\x00role";s:16:"ROLE_SUPER_ADMIN";}i:1;O:41:"Symfony\Component\Security\Core\Role\Role":1:{s:47:"\x00Symfony\Component\Security\Core\Role\Role\x00role";s:9:"ROLE_USER";}}i:3;a:0:{}}";}}';

        return new Response($this->templating->render('home.html.twig'));
    }
}
