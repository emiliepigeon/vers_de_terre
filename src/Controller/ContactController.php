<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            
            $email = (new Email())
                ->from($contactFormData['email'])
                ->to('your@email.com')
                ->subject('Nouveau message de contact')
                ->text('De : '.$contactFormData['nom'].' '.$contactFormData['prenom']."\n".
                     'Email : '.$contactFormData['email']."\n".
                     'Code Postal : '.$contactFormData['codePostal']."\n".
                     'Objet : '.$contactFormData['objet']."\n\n".
                     $contactFormData['message']);
            
            $mailer->send($email);

            $this->addFlash('success', 'Votre message a été envoyé');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }
}
