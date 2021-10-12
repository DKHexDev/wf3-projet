<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class MailerController extends AbstractController
{
    /**
     * @Route("recipe/email")
     */
    public function sendEmail(Request $request, MailerInterface $mailer):Response{

        $ingredients = $request->get('ingredients', 'mail liste');
        $mail=$request->get('mail');

        $email = (new TemplatedEmail())
        ->from('MissionToCooking@gmail.com')
        ->to($mail)
        ->subject('Votre liste de course est prête !')
        ->htmlTemplate('mailer/index.html.twig')

        ->context([

            'ingredients' => $ingredients,
        ]);

    $mailer->send($email);

    $response="Liste de course envoyée !";
    return $this->json($response, 200, [], ['groups' => ['public_json']]);
    }
}
