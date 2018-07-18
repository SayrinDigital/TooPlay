<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Game;

class StoreController extends AbstractController
{



  /**
   * @Route("/tienda/ps/preorden", name="store-pspreorder")
   */
  public function showpspreorder()
  {


 $repository = $this->getDoctrine()->getRepository(Game::class);

 $newgames = $repository
 ->findBy( ['status' => 'new', 'Target' => 'po_playstation']);

 $allgames = $repository
->findBy(['Target' => 'po_playstation']);

      return $this->render('store/index.html.twig', [
          'controller_name' => 'Tienda -  Juegos PS4 - TooPlay Tu Área Digital',
          'game_console' => 'Pre Orden',
          'newgames' => $newgames,
          'allgames' => $allgames,

      ]);

      //return $this-> redirectToRoute('store-ps3games');
  }

  /**
   * @Route("/tienda/steam/preorden", name="store-steampreorder")
   */
  public function showsteampreorder()
  {

 $repository = $this->getDoctrine()->getRepository(Game::class);

 $newgames = $repository
 ->findBy( ['status' => 'new', 'Target' => 'po_windows']);

 $allgames = $repository
->findBy( ['Target' => 'po_windows']);



      return $this->render('store/index.html.twig', [
          'controller_name' => 'Tienda -  Steam Preórdenes - TooPlay Tu Área Digital',
          'game_console' => 'Pre Orden - Steam',
          'newgames' => $newgames,
          'allgames' => $allgames,

      ]);

      //return $this-> redirectToRoute('store-ps3games');
  }

  /**
   * @Route("/tienda/ps3/juegos", name="store-ps3games")
   */
  public function showpsthreegames()
  {

 $repository = $this->getDoctrine()->getRepository(Game::class);

 $newgames = $repository
 ->findBy( ['status' => 'new', 'Target' => 'juegos_ps3']);

 $allgames = $repository
 ->findBy( ['Target' => 'juegos_ps3'] );

      return $this->render('store/index.html.twig', [
          'controller_name' => 'Tienda -  Juegos PS3 - TooPlay Tu Área Digital',
          'game_console' => 'PS3',
          'newgames' => $newgames,
          'allgames' => $allgames,
      ]);
  }

  /**
   * @Route("/tienda/ps3/packs", name="store-ps3packs")
   */
  public function showpsthreepacks()
  {

 $repository = $this->getDoctrine()->getRepository(Game::class);

 $newgames = $repository
 ->findBy( ['status' => 'new', 'Target' => 'pack_ps3']);

 $allgames = $repository
 ->findBy( ['Target' => 'pack_ps3'] );

      return $this->render('store/index.html.twig', [
          'controller_name' => 'Tienda -  Packs PS3 - TooPlay Tu Área Digital',
          'game_console' => 'Pack PS3',
          'newgames' => $newgames,
          'allgames' => $allgames,
      ]);
  }

  /**
   * @Route("/tienda/ps4/primarias", name="store-primaryps4games")
   */
  public function showpsfourprimarygames()
  {

 $repository = $this->getDoctrine()->getRepository(Game::class);

 $newgames = $repository
 ->findBy( ['status' => 'new', 'Target' => 'primarias_ps4']);

 $allgames = $repository
 ->findBy( ['Target' => 'primarias_ps4'] );

      return $this->render('store/index.html.twig', [
          'controller_name' => 'Tienda -  Primarias PS4 - TooPlay Tu Área Digital',
          'game_console' => 'Primarias PS4',
          'newgames' => $newgames,
          'allgames' => $allgames,
      ]);
  }

  /**
   * @Route("/tienda/ps4/secundarias", name="store-secondaryps4games")
   */
  public function showpsfoursecondarygames()
  {

 $repository = $this->getDoctrine()->getRepository(Game::class);

 $newgames = $repository
 ->findBy( ['status' => 'new', 'Target' => 'secundarias_ps4']);

 $allgames = $repository
 ->findBy( ['Target' => 'secundarias_ps4'] );

      return $this->render('store/index.html.twig', [
          'controller_name' => 'Tienda -  Secundarias PS4 - TooPlay Tu Área Digital',
          'game_console' => 'Secundarias PS4',
          'newgames' => $newgames,
          'allgames' => $allgames,
      ]);
  }

    /**
     * @Route("/tienda/ps/primarias-offline", name="store-psofflineprimary")
     */
    public function showpsofflineprimary()
    {

   $repository = $this->getDoctrine()->getRepository(Game::class);

   $newgames = $repository
   ->findBy( ['status' => 'new', 'Target' => 'primarias_offline_ps']);

   $allgames = $repository
   ->findBy( ['Target' => 'primarias_offline_ps'] );

        return $this->render('store/index.html.twig', [
            'controller_name' => 'Tienda -  Primarias Offline - TooPlay Tu Área Digital',
            'game_console' => 'Primarias Offline',
            'newgames' => $newgames,
            'allgames' => $allgames,
        ]);
    }

    /**
     * @Route("/tienda/pc/steam", name="store-steamgames")
     */
    public function showsteamgames()
    {

//Show all new PS4 games in a slider

   $repository = $this->getDoctrine()->getRepository(Game::class);

   $newgames = $repository
   ->findBy( ['status' => 'new', 'Target' => 'juegos_steam']);

   $allgames = $repository
   ->findBy( ['Target' => 'juegos_steam'] );

        return $this->render('store/index.html.twig', [
            'controller_name' => 'Tienda -  Juegos de Steam - TooPlay Tu Área Digital',
            'game_console' => 'PC',
            'newgames' => $newgames,
            'allgames' => $allgames,
        ]);
    }

    /**
     * @Route("/tienda/xboxone/juegos", name="store-xboxonegames")
     */
    public function showxboxonegames()
    {

//Show all new PS4 games in a slider

   $repository = $this->getDoctrine()->getRepository(Game::class);

   $newgames = $repository
   ->findBy( ['status' => 'new', 'Target' => 'juegos_xbox']);

   $allgames = $repository
   ->findBy( ['Target' => 'juegos_xbox'] );

        return $this->render('store/index.html.twig', [
            'controller_name' => 'Tienda -  Juegos PC - TooPlay Tu Área Digital',
            'game_console' => 'PC',
            'newgames' => $newgames,
            'allgames' => $allgames,
        ]);
    }

}
