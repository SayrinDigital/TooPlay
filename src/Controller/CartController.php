<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Game;
use App\Entity\PaymentInstructions;

class CartController extends Controller
{

    /**
     * @Route("/carro", name="cart")
     */
    public function index(Request $request)
    {

      $sessionCart = $request->getSession();
      $arrayOfProduct = $sessionCart->get('ProductIDs');
      $repository = $this->getDoctrine()->getRepository(Game::class);
      $instructionsrepository = $this->getDoctrine()->getRepository(PaymentInstructions::class);

      $allgames = $repository->findById($arrayOfProduct);
      $quantitygamesincart = count($allgames);

      $totalsumcart = 0;
      $gamesOrderDescription = "";
      foreach($allgames as $value){
          $totalsumcart = $totalsumcart + $value->getFinalPrice();
          $gamesOrderDescription = $gamesOrderDescription . 'id: ' . $value->getId() . ' ' . $value->getTitle() . ' (' .$value->getTarget() . ')';
      }

      $gamesOrderDescription = ltrim($gamesOrderDescription, ',');

      unset($value);

      $sessionCart->get('totalproductsincart');
      $sessionCart->set('totalproductsincart', $quantitygamesincart);

      $currentbuyid = $sessionCart->get('buyid');

      if($currentbuyid==""){
      $sessionCart->set('buyid', hexdec(uniqid()));
      }

      $currentbuyid =  $sessionCart->get('buyid');

      $ins_cajavecina = $instructionsrepository
      ->findOneBy( ['name' => 'ins_cajavecina'] );

      $ins_transferencia = $instructionsrepository
      ->findOneBy( ['name' => 'ins_transferencia'] );

      $ins_webpay = $instructionsrepository
      ->findOneBy( ['name' => 'ins_webpay'] );

      $ins_paypal = $instructionsrepository
      ->findOneBy( ['name' => 'ins_paypal'] );

        return $this->render('cart/cartlayout.html.twig', [
           'controller_name' => 'Tienda',
            'cartitems' => $allgames,
            'quantity' => $quantitygamesincart,
            'totalsum' => $totalsumcart,
            'purchase_details' => $gamesOrderDescription,
            'ins_cajavecina' => $ins_cajavecina,
            'ins_transferencia' => $ins_transferencia,
            'ins_webpay' => $ins_webpay,
            'ins_paypal' => $ins_paypal,
            'currentbuyid' => $currentbuyid
        ]);
    }


    /**
    * @Route("/cart/add/{productid}", name="additemcart")
    */
    public function addItemToCar(Request $request, $productid){

      $sessionCart = $request->getSession();
      $arrayOfProduct = $sessionCart->get('ProductIDs');
if ($arrayOfProduct == null){
 $arrayOfProduct = [];
}

if($productid>0){
$arrayOfProduct[] = $productid;
$sessionCart->set('ProductIDs', $arrayOfProduct);
}
     return $this->redirectToRoute('cart');

    }

    /**
    *@Route("/car/delete/{productid}",name="deleteitemcart")
    */

    public function deleteItem(Request $request, $productid){

      $sessionCart = $request->getSession();
      $arrayOfProduct = $sessionCart->get('ProductIDs');

      foreach (array_keys($arrayOfProduct, $productid) as $key) {
          unset($arrayOfProduct[$key]);
      }

     $sessionCart->set('ProductIDs', $arrayOfProduct);
     return $this->redirectToRoute('cart');

    }


    /**
     *@Route("/cart/clear", name="clearcartshop")
    */

    public function clearCart(Request $request){

     $sessionCart = $request->getSession();
     $arrayOfProduct = $sessionCart->get('ProductIDs');
     $arrayOfProduct = array();
     $sessionCart->set('ProductIDs', $arrayOfProduct);

     $sessionCart->get('totalproductsincart');
     $sessionCart->set('totalproductsincart', 0);

     return $this->redirectToRoute('home');

    }

    /**
    *@Route("/carro/pagar", name="webpay")
    */

    public function payFlow(){


       return $this->redirect('http://pagos.tooplay.cl');


    }

}
