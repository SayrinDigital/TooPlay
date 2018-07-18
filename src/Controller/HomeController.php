<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use App\Entity\Game;
use App\Entity\SplashOffer;
use App\Entity\Menu;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {

       $repository = $this->getDoctrine()->getRepository(Game::class);
       $menurepository = $this->getDoctrine()->getRepository(Menu::class);

       $highlightgames = $repository
       ->findBy( ['Target' => 'highlight'] );

       $weekendoffergames = $repository
       ->findBy( ['Target' => 'weekendOffer'] );

       $splash = $repository
       ->findBy( ['Target' => 'splashoffer'], ['id' => 'ASC']);

       $isSplashVisible = $menurepository
       ->findOneBy( ['name' => 'splashoffer'] );

       $splash = array_values($splash);
       $quantity = count($splash) - 1;
       $finalsplash = $splash[$quantity];

       //Form search

        return $this->render('home/index.html.twig', [
            'controller_name' => 'Tooplay - Tu Área Digital',
            'highlightgames' => $highlightgames,
            'weekendoffergames' => $weekendoffergames,
            'splashoffer' => $finalsplash,
            'isSplashVisible' => $isSplashVisible
        ]);
    }

    /**
     * @Route("/buscar", name="search")
     */

     public function searchProducts(Request $request)
     {

       $defaultData = array('message' => 'Type your message here');
       $form = $this->createFormBuilder($defaultData)
       ->add('search', TextType::class)
        ->getForm();

        $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
        // data is an array with "name", "email", and "message" keys
        $data = $form->getData();

        return $this->redirectToRoute('search-response', [
            'title' => $data['search']
        ]);
       }


         return $this->render('searchform.html.twig', [
           'controller_name' => 'Tooplay - Buscar producto' ,
                       'formsearch' => $form->createView(),
         ]);
     }

}
