<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\FrequentQuestionType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\FrequentQuestion;

class FrequentQuestionsController extends Controller
{



    /**
     * @Route("/preguntas/frecuentes", name="frequent_questions")
     */
    public function index()
    {

      $repository = $this->getDoctrine()->getRepository(FrequentQuestion::class);

      $questions = $repository->findAll();

        return $this->render('frequent_questions/index.html.twig', [
            'controller_name' => 'Preguntas Frecuentes - TooPlay Tu Área Digital',
            'questions' => $questions
        ]);
    }

    /**
     * @Route("panel/preguntas/frecuentes", name="dashboard-frequent_questions")
     */
     public function dashboardfrequent(Request $request)
     {

       $repository = $this->getDoctrine()->getRepository(FrequentQuestion::class);

       $questions = $repository->findAll();

         return $this->render('dashboard/frequent_questions.html.twig', [
             'controller_name' => 'Panel de Administración - Preguntas Frecuentes - TooPlay',
             'questions' => $questions
         ]);
     }

    /**
     * @Route("panel/preguntas/frecuentes/edicion", name="dashboard-frequent_questions_management")
     */
     public function dashboardfrequentadd(Request $request)
     {

       $fQuestion = new FrequentQuestion();
       $form = $this->createForm(FrequentQuestionType::class, $fQuestion);
       $form->handleRequest($request);
                 if ($form->isSubmitted() && $form->isValid()) {

                     $entityManager = $this->getDoctrine()->getManager();
                     $entityManager->persist($fQuestion);
                     $entityManager->flush();

                     return $this->redirect($this->generateUrl('dashboard-frequent_questions'));
                 }

         return $this->render('dashboard/frequent_questions_management.html.twig', [
             'controller_name' => 'Panel de Administración - Preguntas Frecuentes - TooPlay',
             'form' => $form->createView()
         ]);
     }

     /**
      * @Route("panel/preguntas/frecuentes/edicion/{id}", name="dashboard-frequent_questions_edit")
      */
      public function dashboardfrequentedit(Request $request, $id)
      {
$entityManager = $this->getDoctrine()->getManager();
       $fQuestion = $entityManager->getRepository(FrequentQuestion::class)->find($id);
        $form = $this->createForm(FrequentQuestionType::class, $fQuestion);
        $form->handleRequest($request);
                  if ($form->isSubmitted() && $form->isValid()) {

                      $entityManager = $this->getDoctrine()->getManager();

                      $entityManager->flush();

                      return $this->redirect($this->generateUrl('dashboard-frequent_questions'));
                  }

          return $this->render('dashboard/frequent_questions_management.html.twig', [
              'controller_name' => 'Panel de Administración - Preguntas Frecuentes - TooPlay',
              'form' => $form->createView()
          ]);
      }

      /**
       * @Route("panel/preguntas/frecuentes/eliminar/{id}", name="dashboard-frequent_questions_delete")
       */
       public function dashboardfrequentdelete(Request $request, $id)
       {
          $entityManager = $this->getDoctrine()->getManager();
                    $fQuestion = $entityManager->getRepository(FrequentQuestion::class)->find($id);

                       $entityManager->remove($fQuestion);
                       $entityManager->flush();

                       return $this->redirect($this->generateUrl('dashboard-frequent_questions'));

       }

}

?>
