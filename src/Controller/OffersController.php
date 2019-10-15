<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Game;

class OffersController extends AbstractController
{
    /**
     * @Route("/ofertas", name="offers")
     */
    public function index()
    {

      $repository = $this->getDoctrine()->getRepository(Game::class);

      $offerproducts = $repository
      ->findBy(['Target' => ['dailyoffer', 'ps4offer', 'ps3offer']]);

      $dailyofferproducts = $repository
      ->findBy(['Target' => 'dailyoffer']);

      $psfourofferproducts = $repository
      ->findBy(['Target' => 'ps4offer']);

      $psthreeofferproducts = $repository
      ->findBy(['Target' => 'ps3offer']);


        return $this->render('offers/index.html.twig', [
            'controller_name' => 'Ofertas - TooPlay Tú Área Digital',
            'offerproducts' => $offerproducts,
            'dailyofferproducts' => $dailyofferproducts,
            'psfourofferproducts' => $psfourofferproducts,
            'psthreeofferproducts' => $psthreeofferproducts
        ]);
    }
}
