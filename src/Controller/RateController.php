<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ClientRate;

class RateController extends Controller
{
    /**
     * @Route("/calificanos", name="rate")
     */
    public function index(Request $request)
    {

      $defaultData = array('message' => 'Type your message here');
      $form = $this->createFormBuilder($defaultData)
      ->add('client_name', TextType::class)
      ->add('client_message', TextareaType::class)
      ->add('save', SubmitType::class, array('label' => 'Enviar'))
       ->getForm();

       $form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) {

$data = $form->getData();

$entityManager = $this->getDoctrine()->getManager();

$rate = new ClientRate();
$rate->setName($data['client_name']);
$rate->setMessage($data['client_message']);
$rate->setIsVisible(false);
$entityManager->persist($rate);

$entityManager->flush();

return $this->redirect($this->generateUrl('home'));

}

        return $this->render('rate/index.html.twig', [
            'controller_name' => 'Califícanos',
             'form' => $form->createView(),
             'message_result' => ""
        ]);
    }

    /**
     * @Route("/valoraciones", name="rate-comments")
     */
   public function clientRate(){

     $raterepository = $this->getDoctrine()->getRepository(ClientRate::class);

     $rates = $raterepository
     ->findBy(['isvisible' => 'true']);

     return $this->render('rate/comments.html.twig', [
       'rates' => $rates,
         'controller_name' => 'valoraciones - TooPlay'
     ]);

   }

   /**
    * @Route("panel/valoraciones", name="dashboard-rate-comments")
    */
  public function dashboardclientRate(){

    $raterepository = $this->getDoctrine()->getRepository(ClientRate::class);

    $rates = $raterepository
    ->findAll();

    return $this->render('dashboard/comments.html.twig', [
      'rates' => $rates,
        'controller_name' => 'valoraciones - TooPlay'
    ]);
  }

  /**
   * @Route("panel/valoraciones/modificar/{id}", name="dashboard-rate-comments-toggle")
   */

   public function toggleComment($id){

     $raterepository = $this->getDoctrine()->getRepository(ClientRate::class);
     $entityManager = $this->getDoctrine()->getManager();
     $rate =  $raterepository->find($id);

     $isvisiblemenu = ((bool)$rate->getisvisible() ? 0 : 1);

     $rate -> setisvisible($isvisiblemenu);
     $entityManager->flush();

     return $this->redirect($this->generateUrl('dashboard-rate-comments'));

   }

}
