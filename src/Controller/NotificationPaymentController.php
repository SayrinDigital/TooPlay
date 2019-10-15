<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Voucher;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\VoucherType;

class NotificationPaymentController extends AbstractController
{
    /**
     * @Route("/notificacion/informatupago/{id}/{details}", name="notification_payment")
     */
    public function index(Request $request, \Swift_Mailer $mailer, $id = 0, $details = "")
    {

          $product = new Voucher();
          $form = $this->createForm(VoucherType::class, $product);
          $form->handleRequest($request);
          $sessionCart = $request->getSession();
              $currentbuyid =  $sessionCart->get('buyid');
          if ($form->isSubmitted() && $form->isValid()) {
              // $file stores the uploaded PDF file
              /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
              $file = $form->get('brochure')->getData();

              $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

              // moves the file to the directory where brochures are stored
              $file->move(
                  $this->getParameter('brochures_directory'),
                  $fileName
              );

              // updates the 'brochure' property to store the PDF file name
              // instead of its contents
              $sessionCart = $request->getSession();


              $product->setOrderId($id);
              $product->setBrochure($fileName);

              $entityManager = $this->getDoctrine()->getManager();

              $entityManager->persist($product);

              $entityManager->flush();

              $messagetouser = (new \Swift_Message('Notificación de Pago - TooPlay'))
               ->setFrom('joscri2698@gmail.com','Ventas')
               ->setTo(['ventas@tooplay.cl','johanna@tooplay.cl', 'mauricio@tooplay.cl'] )
               ->setBody(
                   $this->renderView(
                       // templates/emails/registration.html.twig
                       'emails/paymentnotification.html.twig',
                       array('purchase' => $product)
                     ),
                     'text/html'
                 )
                // ->attach(\Swift_Attachment::fromPath('uploads/productcovers/' . $product->getBrochure()))

             ;

             $message = (new \Swift_Message('Confirmación De Compra - TooPlay'))
              ->setFrom('joscri2698@gmail.com','Ventas')
              ->setTo([$product->getMail()] )
              ->setBody(
                  $this->renderView(
                      // templates/emails/registration.html.twig
                      'emails/notification-received.html.twig',
                      array('purchase' => $product)
                    ),
                    'text/html'
                )
               // ->attach(\Swift_Attachment::fromPath('uploads/productcovers/' . $product->getBrochure()))

            ;

       $mailer->send($message);
        $mailer->send($messagetouser);
       $sessionCart = $request->getSession();
       $sessionCart->get('totalproductsincart');
       $sessionCart->set('totalproductsincart', 0);
       $sessionCart->set('buyid', "");
       $sessionCart->set('ProductIDs', array());

              // ... persist the $product variable or any other work

              return $this->render('notification_payment_layout/index.html.twig', array(
                'controller_name' => 'Informa Tu Pago',
                  'form' => $form->createView(),
                  'message_result' => 'enviado',
                  'details' => $details,
                  'currentbuyid' => $id
              ));


          }

          if($form->isSubmitted() && !$form->isValid()){
            return $this->render('notification_payment_layout/index.html.twig', array(
              'controller_name' => 'Informa Tu Pago',
                'form' => $form->createView(),
                'message_result' => 'fallo',
                'details' => $details,
                'currentbuyid' => $id
            ));
          }

          return $this->render('notification_payment_layout/index.html.twig', array(
            'controller_name' => 'Informa Tu Pago',
              'form' => $form->createView(),
              'message_result' => '',
              'details' => $details,
              'currentbuyid' => $id
          ));
      }

      /**
       * @return string
       */
      private function generateUniqueFileName()
      {
          // md5() reduces the similarity of the file names generated by
          // uniqid(), which is based on timestamps
          return md5(uniqid());
      }

}
