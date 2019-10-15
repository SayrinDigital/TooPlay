<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Game;
use App\Entity\PaymentInstructions;
use App\Entity\Sale;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

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

      $sessionCart->set('totalpurchase', $totalsumcart);

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
      * @Route("/tienda/carro/resume", name="store-resume-sale")
      */
      public function generateOrder(Request $request){

        if($mail = $request->get('cmail')){


          $sessionCart = $request->getSession();
          $arrayOfProduct = $sessionCart->get('ProductIDs');
          //$orderresume = json_encode($request->get('orderjson'), true);
          $orderresume = $arrayOfProduct;
          $currentbuyid =  $sessionCart->get('buyid');
          $name = $request->get('cname');
          $total = $sessionCart->get('totalpurchase');
          $totalToPay = $total + ((6/100) * ($total));
          $phone = $request->get('cphone');

          $currentbuyid =  $sessionCart->get('buyid');

          date_default_timezone_set('America/Santiago');
               $date = new \DateTime('now');

               $order = $this->getDoctrine()
               ->getRepository(Sale::class)
               ->findOneBy(['orderid'=> $currentbuyid]);

               if(!$order){
                 $order = new Sale();
                 $order->setOrderid($currentbuyid);
                 $order->setResume($orderresume);
                 $order->setTotal($totalToPay);
                 $order->setStatus("Orden Generada");
                 $order->setClientname($name);
                 $order->setClientmail($mail);
                 $order->setClientphone($phone);
                 $order->setDate($date);
               }else{
                 $order->setResume($orderresume);
                 $order->setTotal($totalToPay);
                 $order->setClientname($name);
                 $order->setClientmail($mail);
                 $order->setClientphone($phone);
                 $order->setDate($date);
               }


                                $entityManager = $this->getDoctrine()->getManager();
                                $entityManager->persist($order);
                                $entityManager->flush();


               return new JsonResponse(array(
                          'total' => $total
                        ));

         }

      }

      /**
     * @Route("/tienda/payment/confirmacion/{id}", name="store-confirmation")
     */
     public function confirmPayment(Request $request, $id,  \Swift_Mailer $mailer){

       $params = array(
         "commerceId" => $id,
       );
       //Define el metodo a usar
       $serviceName = "payment/getStatusByCommerceId";
       try {
         // Ejecuta el servicio
         $response = $this->send($serviceName, $params,"GET");


         $order = $this->getDoctrine()
         ->getRepository(Sale::class)
         ->findOneBy(['orderid'=> $id]);

         $orderresume = $this->getDoctrine()
         ->getRepository(Game::class)
         ->findBy(['id' => $order->getResume()]);

         $status = $response['status'];

         if($order){
           switch($status){
             case 1:
                $order->setStatus('Pendiente de Pago');
             break;
             case 2:
                $order->setStatus('Pagado');
                $sessionCart = $request->getSession();
                $sessionCart->set('ProductIDs', array());
                $sessionCart->set('buyid', "");
                $sessionCart->set('totalpurchase', 0);

                //$orderresume = json_decode($order->getResume());

                $arrayorder = json_decode($orderresume, true);

                $sendTo = $order->getClientmail();

                $message = (new \Swift_Message('Ventas Tooplay'))
                ->setSubject('Área de Ventas - TooPlay')
                ->setFrom('joscri2698@gmail.com','Área de Ventas TooPlay')
                ->setTo([$sendTo, 'ventas@tooplay.cl','johanna@tooplay.cl', 'mauricio@tooplay.cl', 'josepuma@sayrin.cl'] )
                ->setBody(
                  $this->renderView(
                    'emails/clientorder.html.twig',
                     array(
                       'resume' => $orderresume,
                       'order' => $order
                   )
                  ),
                  'text/html'
                );

                $mailer->send($message);

             break;
             case 3:
                $order->setStatus('Rechazado');
             break;
             case 4:
                $order->setStatus('Anulado');
             break;
             default:
              $order->setStatus('Orden Generada');
           }
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($order);
           $entityManager->flush();
         }



           return $this->render('cart/result/message.html.twig', [
               'status' => $status,
               'title' => 'Resumen de Compra',
               'resume' => $orderresume,
               'order' => $order
           ]);

         //header("location:$redirect");

       } catch (Exception $e) {
         echo $e->getCode() . " - " . $e->getMessage();
         throw new Exception($e->getMessage());
         //return $this->redirect("https://www.arteimpreso.cl");
       }


    }

    /**
 * @Route("panel/orden/{id}", name="store-order")
 */
 public function obtainOrder($id){

   $order = $this->getDoctrine()
   ->getRepository(Sale::class)
   ->findOneBy(['orderid'=> $id]);

   $orderresume = $this->getDoctrine()
   ->getRepository(Game::class)
   ->findBy(['id' => $order->getResume()]);

   return $this->render('cart/result/order.html.twig', [
       'order' =>  $order,
       'resume' => $orderresume,
       'title' => 'Estado de Orden',
       'controller_name' => 'Resumen de Orden'
   ]);

 }

 /**
  * @Route("/tienda/pagar/flow/{id}", name="store-checkout-flow")
  */

    public function payFlow($id){

      $order = $this->getDoctrine()
      ->getRepository(Sale::class)
      ->findOneBy(['orderid'=> $id]);

      if($order){

             //Development

             /*$APIKEY = "6E8DE1F0-CAAB-43EA-86BA-4799L42C2069"; // Registre aquí su apiKey
              $SECRETKEY = "20bad08dda5c13b497091fcb0bdc30d936c19c53"; // Registre aquí su secretKey
              $APIURL = "https://sandbox.flow.cl/api"; // Producción EndPoint o Sandbox EndPoint
              $BASEURL = "https://www.tooplay.cl/";*/

            //Production
            $APIKEY = "55992F03-7015-4E19-9573-20LA70BA0866"; // Registre aquí su apiKey
            $SECRETKEY = "6a27518feeccbbc5b2f1a7b77cad410c51cb6deb"; // Registre aquí su secretKey
            $APIURL = "https://www.flow.cl/api"; // Producción EndPoint o Sandbox EndPoint
            $BASEURL = "https://www.tooplay.cl"; //Registre aquí la URL base en su página donde instalará el cliente

            $total = $order->getTotal();
            $cmail = $order->getClientmail();

         //Para datos opcionales campo "optional" prepara un arreglo JSON
    $optional = array(
    	"Descripción" => $details
    );
    $optional = json_encode($optional);
    //Prepara el arreglo de datos
    $params = array(
    	"commerceOrder" => $id,
    	"subject" => "Pago TooPlay.cl",
    	"currency" => "CLP",
    	"amount" => $total,
    	"email" => $cmail,
    	"paymentMethod" => 1,
    	"urlConfirmation" => $BASEURL,
    	"urlReturn" => $BASEURL . 'tienda/payment/confirmacion/' . $id,
    	"optional" => $optional
    );
    //Define el metodo a usar
    $serviceName = "payment/create";
    try {
    	// Instancia la clase FlowApi
    	//$flowApi = new FlowApi;
    	// Ejecuta el servicio
    	$response = $this->send($serviceName, $params,"POST");
    	//Prepara url para redireccionar el browser del pagador
    	$redirect = $response["url"] . "?token=" . $response["token"];
    	//header("location:$redirect");
      return $this->redirect($redirect);
    } catch (Exception $e) {
    	echo $e->getCode() . " - " . $e->getMessage();
      throw new Exception($e->getMessage());
    }
}

    }

    /**
    	 * Funcion que invoca un servicio del Api de Flow
    	 * @param string $service Nombre del servicio a ser invocado
    	 * @param array $params datos a ser enviados
    	 * @param string $method metodo http a utilizar
    	 * @return string en formato JSON
    	 */
    	public function send( $service, $params, $method = "GET") {
    		$method = strtoupper($method);
        //Development
        /*$url = 'https://sandbox.flow.cl/api' . "/" . $service;
    		$params = array("apiKey" => "6E8DE1F0-CAAB-43EA-86BA-4799L42C2069") + $params;*/
        //Production
    		$url = 'https://www.flow.cl/api' . "/" . $service;
    		$params = array("apiKey" => "55992F03-7015-4E19-9573-20LA70BA0866") + $params;
    		$data = $this->getPack($params, $method);
    		$sign = $this->sign($params);
    		if($method == "GET") {
    			$response = $this->httpGet($url, $data, $sign);
    		} else {
    			$response = $this->httpPost($url, $data, $sign);
    		}

    		if(isset($response["info"])) {
    			$code = $response["info"]["http_code"];
    			$body = json_decode($response["output"], true);
    			if($code == "200") {
    				return $body;
    			} elseif(in_array($code, array("400", "401"))) {
    				throw new Exception($body["message"], $body["code"]);
    			} else {
    				throw new Exception("Unexpected error occurred. HTTP_CODE: " .$code , $code);
    			}
    		} else {
    			throw new Exception("Unexpected error occurred.");
    		}
    	}

      /**
	 * Funcion que empaqueta los datos de parametros para ser enviados
	 * @param array $params datos a ser empaquetados
	 * @param string $method metodo http a utilizar
	 */
	private function getPack($params, $method) {
		$keys = array_keys($params);
		sort($keys);
		$data = "";
		foreach ($keys as $key) {
			if($method == "GET") {
				$data .= "&" . rawurlencode($key) . "=" . rawurlencode($params[$key]);
			} else {
				$data .= "&" . $key . "=" . $params[$key];
			}
		}
		return substr($data, 1);
	}


	/**
	 * Funcion que firma los parametros
	 * @param string $params Parametros a firmar
	 * @return string de firma
	 */
	private function sign($params) {
		$keys = array_keys($params);
		sort($keys);
		$toSign = "";
		foreach ($keys as $key) {
			$toSign .= "&" . $key . "=" . $params[$key];
		}
		$toSign = substr($toSign, 1);
		if(!function_exists("hash_hmac")) {
			throw new Exception("function hash_hmac not exist", 1);
		}

     //Development
     //return hash_hmac('sha256', $toSign , "20bad08dda5c13b497091fcb0bdc30d936c19c53");

    //Production
		return hash_hmac('sha256', $toSign , "6a27518feeccbbc5b2f1a7b77cad410c51cb6deb");
	}

  /**
	 * Funcion que hace el llamado via http GET
	 * @param string $url url a invocar
	 * @param array $data datos a enviar
	 * @param string $sign firma de los datos
	 * @return string en formato JSON
	 */
	private function httpGet($url, $data, $sign) {
		$url = $url . "?" . $data . "&s=" . $sign;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$output = curl_exec($ch);
		if($output === false) {
			$error = curl_error($ch);
			throw new Exception($error, 1);
		}
		$info = curl_getinfo($ch);
		curl_close($ch);
		return array("output" =>$output, "info" => $info);
	}

  /**
	 * Funcion que hace el llamado via http POST
	 * @param string $url url a invocar
	 * @param array $data datos a enviar
	 * @param string $sign firma de los datos
	 * @return string en formato JSON
	 */
	private function httpPost($url, $data, $sign ) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data . "&s=" . $sign);
		$output = curl_exec($ch);
		if($output === false) {
			$error = curl_error($ch);
			throw new Exception($error, 1);
		}
		$info = curl_getinfo($ch);
		curl_close($ch);
		return array("output" =>$output, "info" => $info);
	}

}
