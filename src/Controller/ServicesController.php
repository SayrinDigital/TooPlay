<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Game;
use App\Entity\Menu;

class ServicesController extends AbstractController
{
    /**
     * @Route("/servicios", name="services")
     */
    public function index()
    {

      //Get Netflix Plans
      $repository = $this->getDoctrine()->getRepository(Game::class);

      $allnetflixplans = $repository
      ->findBy( ['Target' => 'se_netflix'] );

      $allspotifyplans = $repository
      ->findBy( ['Target' => 'se_spotify'] );

      $alliptvplans = $repository
      ->findBy( ['Target' => 'se_iptv'] );

      $allcrunchyrollplans = $repository
      ->findBy( ['Target' => 'se_crunchyroll'] );

      $menurepository = $this->getDoctrine()->getRepository(Menu::class);
      $netflixcontainer = $menurepository
      ->findOneBy( ['name' => 'se_netflix']);

      $spotifycontainer = $menurepository
      ->findOneBy( ['name' => 'se_spotify']);

      $iptvcontainer = $menurepository
      ->findOneBy( ['name' => 'se_iptv']);

      $crunchyrollcontainer = $menurepository
      ->findOneBy( ['name' => 'se_crunchyroll']);

        return $this->render('services/serviceslayout.html.twig', [
            'controller_name' => 'Servicios - TooPlay',
            'netflixplans' => $allnetflixplans,
            'spotifyplans' => $allspotifyplans,
            'iptvplans' => $alliptvplans,
            'crunchyrollplans' => $allcrunchyrollplans,
            'netflixcontainer' => $netflixcontainer,
            'spotifycontainer' => $spotifycontainer,
            'iptvcontainer' => $iptvcontainer,
            'crunchyrollcontainer' => $crunchyrollcontainer
        ]);
    }
}
