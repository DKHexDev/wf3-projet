<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerController extends AbstractController
{
    /**
     * @Route("recipe/email")
     */
    public function sendEmail(MailerInterface $mailer){

        $email = (new Email())
        ->from('MissionToCooking@symfony.com')
        ->to('evrard.ulrick.pro@gmail.com')
        ->subject('ça marche')
        ->text('texte')
        ->html('<p>See Twig integration for better HTML integration!</p>');

    $mailer->send($email);
    }
}
