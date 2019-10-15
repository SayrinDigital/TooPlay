<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Game;


class ProductExtraController extends AbstractController
{

  /**
   * @Route("/buscar/{title}", name="search-response")
   */
  public function searchproductsresult($title)
  {

    $repository = $this->getDoctrine()->getRepository(Game::class);
    $products = $repository
    ->findByTitlePart($title);

      return $this->render('product_extra/index.html.twig', [
          'controller_name' => 'Resultados de búsqueda: ' . $title,
          'cards' => $products
      ]);
  }

    /**
     * @Route("/tienda/ps/tarjetas", name="store-pscards")
     */
    public function pscards()
    {

      $repository = $this->getDoctrine()->getRepository(Game::class);

      $products = $repository
      ->findBy( ['Target' => 'cd_ps'],['id' => 'DESC'] );

        return $this->render('product_extra/index.html.twig', [
            'controller_name' => 'Tarjetas PlayStation',
            'cards' => $products
        ]);
    }

    /**
     * @Route("/tienda/xboxone/tarjetas", name="store-xboxonecards")
     */
    public function xboxcards()
    {
      $repository = $this->getDoctrine()->getRepository(Game::class);

      $products = $repository
      ->findBy( ['Target' => 'cd_xbox'],['id' => 'DESC'] );

        return $this->render('product_extra/index.html.twig', [
            'controller_name' => 'Tarjetas XBOX',
            'cards' => $products
        ]);
    }

    /**
     * @Route("/tienda/giftcard/steam", name="store-giftcard-steam")
     */
    public function steamgiftcard()
    {
      $repository = $this->getDoctrine()->getRepository(Game::class);

      $products = $repository
      ->findBy( ['Target' => 'gf_steam'],['id' => 'DESC'] );

        return $this->render('product_extra/index.html.twig', [
            'controller_name' => 'Tarjetas Steam',
            'cards' => $products
        ]);
    }

    /**
     * @Route("/tienda/giftcard/itunes", name="store-giftcard-itunes")
     */
    public function itunegiftcard()
    {
      $repository = $this->getDoctrine()->getRepository(Game::class);

      $products = $repository
      ->findBy( ['Target' => 'gf_itunes'],['id' => 'DESC'] );

        return $this->render('product_extra/index.html.twig', [
            'controller_name' => 'Gift Card iTunes',
            'cards' => $products
        ]);
    }

    /**
     * @Route("/tienda/giftcard/googleplay", name="store-giftcard-googleplay")
     */
    public function googleplaygiftcard()
    {
      $repository = $this->getDoctrine()->getRepository(Game::class);

      $products = $repository
      ->findBy( ['Target' => 'gf_googleplay'] ,['id' => 'DESC']);

        return $this->render('product_extra/index.html.twig', [
            'controller_name' => 'Gift Card Google Play',
            'cards' => $products
        ]);
    }

    /**
     * @Route("/tienda/giftcard/psn", name="store-giftcard-psn")
     */
    public function psngiftcard()
    {
      $repository = $this->getDoctrine()->getRepository(Game::class);

      $products = $repository
      ->findBy( ['Target' => 'gf_psn'],['id' => 'DESC'] );

        return $this->render('product_extra/index.html.twig', [
            'controller_name' => 'Gift Card PSN',
            'cards' => $products
        ]);
    }

    /**
     * @Route("/tienda/giftcard/amazon", name="store-giftcard-amazon")
     */
    public function amazongiftcard()
    {
      $repository = $this->getDoctrine()->getRepository(Game::class);

      $products = $repository
      ->findBy( ['Target' => 'gf_amazon'],['id' => 'DESC'] );

        return $this->render('product_extra/index.html.twig', [
            'controller_name' => 'Gift Card Amazon',
            'cards' => $products
        ]);
    }

    /**
     * @Route("/tienda/giftcard/paypal", name="store-giftcard-paypal")
     */
    public function paypalgiftcard()
    {
      $repository = $this->getDoctrine()->getRepository(Game::class);

      $products = $repository
      ->findBy( ['Target' => 'gf_paypal'],['id' => 'DESC'] );

        return $this->render('product_extra/index.html.twig', [
            'controller_name' => 'Gift Card Paypal',
            'cards' => $products
        ]);
    }

    /**
     * @Route("/tienda/giftcard/xbox", name="store-giftcard-xbox")
     */
    public function xboxgiftcard()
    {
      $repository = $this->getDoctrine()->getRepository(Game::class);

      $products = $repository
      ->findBy( ['Target' => 'gf_xbox'],['id' => 'DESC'] );

        return $this->render('product_extra/index.html.twig', [
            'controller_name' => 'Gift Card XBOX',
            'cards' => $products
        ]);
    }

    /**
     * @Route("/tienda/giftcard/nintendoeshop", name="store-giftcard-nintendoeshop")
     */
    public function nintendoeshopgiftcard()
    {
      $repository = $this->getDoctrine()->getRepository(Game::class);

      $products = $repository
      ->findBy( ['Target' => 'gf_nintendoeshop'],['id' => 'DESC'] );

        return $this->render('product_extra/index.html.twig', [
            'controller_name' => 'Gift Card Nintendo EShop',
            'cards' => $products
        ]);
    }

}
