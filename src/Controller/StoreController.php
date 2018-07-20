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
   * @Route("/tienda/ps/preorden/{page}", name="store-pspreorder", requirements={"page"="\d+"})
   */
  public function showpspreorder($page = 1)
  {


 $repository = $this->getDoctrine()->getRepository(Game::class);

 $newgames = $repository
 ->findBy( ['status' => 'new', 'Target' => 'po_playstation'],['id' => 'DESC']);

 $allgames = $repository
->findBy(['Target' => 'po_playstation'],['id' => 'DESC']);

$limit = 20;
$productsQuantity = count($allgames);
$offset = ($page - 1) * $limit;
$pagesQuantity = ceil($productsQuantity / $limit);

$pagination_games = array_slice($allgames, $offset, $limit);

      return $this->render('store/index.html.twig', [
          'controller_name' => 'Tienda -  Juegos PS4 - TooPlay Tu Área Digital',
          'game_console' => 'Pre Orden',
          'newgames' => $newgames,
          'allgames' => $pagination_games,
          "pagesQuantity" => $pagesQuantity,
          'currentPage' => $page,
          'route' => 'store-pspreorder'

      ]);

      //return $this-> redirectToRoute('store-ps3games');
  }

  /**
   * @Route("/tienda/steam/preorden", name="store-steampreorder")
   * @Route("/tienda/steam/preorden/{page}", name="store-steampreorder", requirements={"page"="\d+"})
   */
  public function showsteampreorder($page = 1)
  {

 $repository = $this->getDoctrine()->getRepository(Game::class);

 $newgames = $repository
 ->findBy( ['status' => 'new', 'Target' => 'po_windows'],['id' => 'DESC']);

 $allgames = $repository
->findBy( ['Target' => 'po_windows'],['id' => 'DESC']);

$limit = 20;
$productsQuantity = count($allgames);
$offset = ($page - 1) * $limit;
$pagesQuantity = ceil($productsQuantity / $limit);

$pagination_games = array_slice($allgames, $offset, $limit);

      return $this->render('store/index.html.twig', [
          'controller_name' => 'Tienda -  Steam Preórdenes - TooPlay Tu Área Digital',
          'game_console' => 'Pre Orden - Steam',
          'newgames' => $newgames,
          'allgames' => $pagination_games,
          "pagesQuantity" => $pagesQuantity,
          'currentPage' => $page,
          'route' => 'store-steampreorder'

      ]);

      //return $this-> redirectToRoute('store-ps3games');
  }

  /**
   * @Route("/tienda/ps3/juegos", name="store-ps3games")
   * @Route("/tienda/ps3/juegos/{page}", name="store-ps3games", requirements={"page"="\d+"})
   */
  public function showpsthreegames($page = 1)
  {

 $repository = $this->getDoctrine()->getRepository(Game::class);

 $newgames = $repository
 ->findBy( ['status' => 'new', 'Target' => 'juegos_ps3'],['id' => 'DESC']);

 $allgames = $repository
 ->findBy( ['Target' => 'juegos_ps3'] ,['id' => 'DESC']);

 $limit = 20;
 $productsQuantity = count($allgames);
 $offset = ($page - 1) * $limit;
 $pagesQuantity = ceil($productsQuantity / $limit);

 $pagination_games = array_slice($allgames, $offset, $limit);

      return $this->render('store/index.html.twig', [
          'controller_name' => 'Tienda -  Juegos PS3 - TooPlay Tu Área Digital',
          'game_console' => 'PS3',
          'newgames' => $newgames,
          'allgames' => $pagination_games,
          "pagesQuantity" => $pagesQuantity,
          'currentPage' => $page,
          'route' => 'store-ps3games'
      ]);
  }

  /**
   * @Route("/tienda/ps3/packs", name="store-ps3packs")
   * @Route("/tienda/ps3/packs/{page}", name="store-ps3packs", requirements={"page"="\d+"})
   */
  public function showpsthreepacks($page = 1)
  {

 $repository = $this->getDoctrine()->getRepository(Game::class);

 $newgames = $repository
 ->findBy( ['status' => 'new', 'Target' => 'pack_ps3'],['id' => 'DESC']);

 $allgames = $repository
 ->findBy( ['Target' => 'pack_ps3'] ,['id' => 'DESC']);

 $limit = 20;
 $productsQuantity = count($allgames);
 $offset = ($page - 1) * $limit;
 $pagesQuantity = ceil($productsQuantity / $limit);

 $pagination_games = array_slice($allgames, $offset, $limit);

      return $this->render('store/index.html.twig', [
          'controller_name' => 'Tienda -  Packs PS3 - TooPlay Tu Área Digital',
          'game_console' => 'Pack PS3',
          'newgames' => $newgames,
          'allgames' => $pagination_games,
          "pagesQuantity" => $pagesQuantity,
          'currentPage' => $page,
          'route' => 'store-ps3packs'
      ]);
  }

  /**
   * @Route("/tienda/ps4/primarias", name="store-primaryps4games")
   * @Route("/tienda/ps4/primarias/{page}", name="store-primaryps4games", requirements={"page"="\d+"})
   */
  public function showpsfourprimarygames($page = 1)
  {

 $repository = $this->getDoctrine()->getRepository(Game::class);

 $newgames = $repository
 ->findBy( ['status' => 'new', 'Target' => 'primarias_ps4'],['id' => 'DESC']);

 $allgames = $repository
 ->findBy( ['Target' => 'primarias_ps4'],['id' => 'DESC'] );

          $limit = 20;
          $productsQuantity = count($allgames);
          $offset = ($page - 1) * $limit;
          $pagesQuantity = ceil($productsQuantity / $limit);

          $pagination_games = array_slice($allgames, $offset, $limit);

      return $this->render('store/index.html.twig', [
          'controller_name' => 'Tienda -  Primarias PS4 - TooPlay Tu Área Digital',
          'game_console' => 'Primarias PS4',
          'newgames' => $newgames,
          'allgames' => $pagination_games,
          "pagesQuantity" => $pagesQuantity,
          'currentPage' => $page,
          'route' => 'store-primaryps4games'
      ]);
  }


   /**
    * @Route("/tienda/ps4/secundarias", name="store-secondaryps4games")
    * @Route("/tienda/ps4/secundarias/{page}", name="store-secondaryps4games", requirements={"page"="\d+"})
    */
  public function showpsfoursecondarygames($page = 1)
  {

 $repository = $this->getDoctrine()->getRepository(Game::class);

 $newgames = $repository
 ->findBy( ['status' => 'new', 'Target' => 'secundarias_ps4'],['id' => 'DESC']);

 $allgames = $repository
 ->findBy( ['Target' => 'secundarias_ps4'],['id' => 'DESC'] );

 $limit = 20;
 $productsQuantity = count($allgames);
 $offset = ($page - 1) * $limit;
 $pagesQuantity = ceil($productsQuantity / $limit);

 $pagination_games = array_slice($allgames, $offset, $limit);

      return $this->render('store/index.html.twig', [
          'controller_name' => 'Tienda -  Secundarias PS4 - TooPlay Tu Área Digital',
          'game_console' => 'Secundarias PS4',
          'newgames' => $newgames,
          'allgames' => $pagination_games,
          "pagesQuantity" => $pagesQuantity,
          'currentPage' => $page,
          'route' => 'store-secondaryps4games'
      ]);
  }

     /**
      * @Route("/tienda/ps/primarias-offline", name="store-psofflineprimary")
      * @Route("/tienda/ps/primarias-offline/{page}", name="store-psofflineprimary", requirements={"page"="\d+"})
      */
    public function showpsofflineprimary($page = 1)
    {

   $repository = $this->getDoctrine()->getRepository(Game::class);

   $newgames = $repository
   ->findBy( ['status' => 'new', 'Target' => 'primarias_offline_ps'],['id' => 'DESC']);

   $allgames = $repository
   ->findBy( ['Target' => 'primarias_offline_ps'] ,['id' => 'DESC']);

   $limit = 20;
   $productsQuantity = count($allgames);
   $offset = ($page - 1) * $limit;
   $pagesQuantity = ceil($productsQuantity / $limit);

   $pagination_games = array_slice($allgames, $offset, $limit);

        return $this->render('store/index.html.twig', [
            'controller_name' => 'Tienda -  Primarias Offline - TooPlay Tu Área Digital',
            'game_console' => 'Primarias Offline',
            'newgames' => $newgames,
            'allgames' => $pagination_games,
            "pagesQuantity" => $pagesQuantity,
            'currentPage' => $page,
            'route' => 'store-psofflineprimary'
        ]);
    }

     /**
      * @Route("/tienda/pc/steam", name="store-steamgames")
      * @Route("/tienda/pc/steam/{page}", name="store-steamgames", requirements={"page"="\d+"})
      */
    public function showsteamgames($page = 1)
    {

//Show all new PS4 games in a slider

   $repository = $this->getDoctrine()->getRepository(Game::class);

   $newgames = $repository
   ->findBy( ['status' => 'new', 'Target' => 'juegos_steam'],['id' => 'DESC']);

   $allgames = $repository
   ->findBy( ['Target' => 'juegos_steam'] ,['id' => 'DESC']);

   $limit = 20;
   $productsQuantity = count($allgames);
   $offset = ($page - 1) * $limit;
   $pagesQuantity = ceil($productsQuantity / $limit);

   $pagination_games = array_slice($allgames, $offset, $limit);

        return $this->render('store/index.html.twig', [
            'controller_name' => 'Tienda -  Juegos de Steam - TooPlay Tu Área Digital',
            'game_console' => 'PC',
            'newgames' => $newgames,
            'allgames' => $pagination_games,
            "pagesQuantity" => $pagesQuantity,
            'currentPage' => $page,
            'route' => 'store-steamgames'
        ]);
    }

     /**
      * @Route("/tienda/xboxone/juegos", name="store-xboxonegames")
      * @Route("/tienda/xboxone/juegos/{page}", name="store-xboxonegames", requirements={"page"="\d+"})
      */
    public function showxboxonegames($page = 1)
    {

//Show all new PS4 games in a slider

   $repository = $this->getDoctrine()->getRepository(Game::class);

   $newgames = $repository
   ->findBy( ['status' => 'new', 'Target' => 'juegos_xbox'],['id' => 'DESC']);

   $allgames = $repository
   ->findBy( ['Target' => 'juegos_xbox'],['id' => 'DESC'] );

   $limit = 20;
   $productsQuantity = count($allgames);
   $offset = ($page - 1) * $limit;
   $pagesQuantity = ceil($productsQuantity / $limit);

   $pagination_games = array_slice($allgames, $offset, $limit);

        return $this->render('store/index.html.twig', [
            'controller_name' => 'Tienda -  Juegos PC - TooPlay Tu Área Digital',
            'game_console' => 'PC',
            'newgames' => $newgames,
            'allgames' => $pagination_games,
            "pagesQuantity" => $pagesQuantity,
            'currentPage' => $page,
            'route' => 'store-xboxonegames'
        ]);
    }

}
