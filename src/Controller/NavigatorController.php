<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Menu;
use App\Entity\Configuration;
use Symfony\Component\HttpFoundation\Request;

class NavigatorController extends Controller
{

    public function navigator()
    {
        $menurepository = $this->getDoctrine()->getRepository(Menu::class);
        $menu = $menurepository->findAll();

        return $this->render('navigator.html.twig', [
          'menu' => $menu
        ]);
    }

    public function footer(){
      $menurepository = $this->getDoctrine()->getRepository(Configuration::class);
      $times = $menurepository->findOneBy(['name' => 'horarios']);

      return $this->render('footer.html.twig', [
        'times' => $times
      ]);
    }
    /**
     * @Route("/panel/menu/toggle/{id}", name="tooglemenu")
     */

     public function toogleMenu(Request $request, $id){
       $entityManager = $this->getDoctrine()->getManager();
       $menu = $entityManager->getRepository(Menu::class)->find($id);

       $isvisiblemenu = ((bool)$menu->getisvisible() ? 0 : 1);

       $menu -> setisvisible($isvisiblemenu);
       $entityManager->flush();

         return $this->redirect($this->generateUrl('dashboard-home'));

     }

}
