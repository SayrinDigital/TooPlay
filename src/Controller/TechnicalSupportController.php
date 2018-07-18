<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TechnicalSupportController extends AbstractController
{
    /**
     * @Route("/soporte-tecnico", name="technical_support")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {



      $defaultData = array('message' => 'Type your message here');
      $form = $this->createFormBuilder($defaultData)
      ->add('client_name', TextType::class)
      ->add('client_mail', EmailType::class)
      ->add('client_phone', TelType::class)
      ->add('client_message', TextareaType::class)
       ->getForm();

       $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
       // data is an array with "name", "email", and "message" keys
       $data = $form->getData();

       $message = (new \Swift_Message('Soporte Técnico - TooPlay'))
        ->setFrom('joscri2698@gmail.com')
        ->setTo($data['client_mail'] )
        ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'emails/support.html.twig',
                array('name' => $data['client_name'], 'mail' => $data['client_mail'], 'phone' => $data['client_phone'], 'message' => $data['client_message'] )
              ),
              'text/html'
          )

      ;

$mailer->send($message);

       return $this->render('technical_support/index.html.twig', [
           'controller_name' => 'Soporte Técnico',
           'form_contact_support' => $form->createView(),
           'message_result' => 'enviado'
       ]);
      }


        return $this->render('technical_support/index.html.twig', [
            'controller_name' => 'Soporte Técnico',
            'form_contact_support' => $form->createView(),
            'message_result' => '',
        ]);
    }
}
