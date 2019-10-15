<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Game;
use App\Entity\Menu;
use App\Entity\Configuration;
use App\Entity\PaymentInstructions;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Form\GameType;

class DashboardController extends AbstractController
{
    /**
     * @Route("/panel", name="dashboard-home")
     */
    public function index(Request $request)
    {

       $repository = $this->getDoctrine()->getRepository(Game::class);
       $configrepository = $this->getDoctrine()->getRepository(Configuration::class);
       $highlightgames = $repository
       ->findBy( ['Target' => 'Highlight'] );

       $weekendoffergames = $repository
       ->findBy( ['Target' => 'WeekendOffer'] );

       $splash = $repository
       ->findOneBy( ['Target' => 'splashoffer']);

       $preorderbackground = $configrepository
       ->findOneBy(['name' => 'preorder_background']);

       $horarios = $configrepository
       ->findOneBy(['name' => 'horarios']);

       $menurepository = $this->getDoctrine()->getRepository(Menu::class);
       $splashcontainer = $menurepository
       ->findOneBy( ['name' => 'splashoffer']);

       //Preorder Banner

       if ($file = $request->files->get('file')) {
      $fileName = md5(uniqid()).'.'.$file->guessExtension();
      $file->move(
          $this->getParameter('productcovers_directory'),
          $fileName
      );

      $preorderbackground->setValue($fileName);
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($preorderbackground);
      $entityManager->flush();

       return new JsonResponse(array('bg' => $fileName));
  }


        if($newtime = $request->request->get('horarios')){

        $horarios->setValue($newtime);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($horarios);
        $entityManager->flush();

         return new JsonResponse(array('newdate' => 'owo' . $newtime));
        }

        if($splashfile = $request->files->get('splashfile')){
           $splashtitle = $request->get('splashtitle');
           $splashprice = $request->get('splashprice');

           $splashfileName = md5(uniqid()).'.'.$splashfile->guessExtension();
           $splashfile->move(
               $this->getParameter('productcovers_directory'),
               $splashfileName
           );

           $splash->setCover($splashfileName);
           $splash->setOriginalPrice($splashprice);
           $splash->setFinalPrice($splashprice);
           $splash->setTitle($splashtitle);

           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($splash);
           $entityManager->flush();

         return new JsonResponse(array(
           'splashtitle' => $splashtitle,
           'splashprice' => $splashprice,
           'splashcover' => $splashfileName
         ));
        }

        return $this->render('dashboard/home.html.twig', [
            'controller_name' => 'Panel de Administración - TooPlay',
            'highlightproducts' => $highlightgames,
            'weekendofferproducts' => $weekendoffergames,
            'finalsplash' => $splash,
            'splashcontainer' => $splashcontainer,
            'preorderbackground' => $preorderbackground,
            'workdates' => $horarios,
        ]);

    }

        /**
         * @Route("/panel/servicios", name="dashboard-services")
         */
        public function servicesdashboard()
        {


          $repository = $this->getDoctrine()->getRepository(Game::class);
          $netflixproducts = $repository
          ->findBy( ['Target' => 'se_netflix'] );

          $spotifyproducts = $repository
          ->findBy( ['Target' => 'se_spotify'] );

          $iptvproducts = $repository
          ->findBy( ['Target' => 'se_iptv'] );

          $crunchyrollproducts = $repository
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

            return $this->render('dashboard/services.html.twig', [
                'controller_name' => 'Panel de Administración - Servicios - TooPlay',
                'netflixproducts' => $netflixproducts,
                'spotifyproducts' => $spotifyproducts,
                'iptvproducts' => $iptvproducts,
                'crunchyrollproducts' => $crunchyrollproducts,
                'netflixcontainer' => $netflixcontainer,
                'spotifycontainer' => $spotifycontainer,
                'iptvcontainer' => $iptvcontainer,
                'crunchyrollcontainer' => $crunchyrollcontainer
            ]);
        }

        /**
         * @Route("/panel/ofertas", name="dashboard-offers")
         */
        public function offersdashboard()
        {
          $repository = $this->getDoctrine()->getRepository(Game::class);
          $dailyoffers = $repository
          ->findBy( ['Target' => 'dailyoffer'] );
          $psfouroffers = $repository
          ->findBy( ['Target' => 'ps4offer'] );
          $psthreeoffers = $repository
          ->findBy( ['Target' => 'ps3offer'] );

          $menurepository = $this->getDoctrine()->getRepository(Menu::class);
          $dailyofferscontainer = $menurepository
          ->findOneBy( ['name' => 'offers_dailyoffer']);

          $psfourofferscontainer = $menurepository
          ->findOneBy( ['name' => 'offers_ps4offer']);

          $psthreeofferscontainer = $menurepository
          ->findOneBy( ['name' => 'offers_ps3offer']);

            return $this->render('dashboard/offers.html.twig', [
                'controller_name' => 'Panel de Administración - Ofertas - TooPlay',
                'dailyoffers' => $dailyoffers,
                'psfouroffers' => $psfouroffers,
                'psthreeoffers' => $psthreeoffers,
                'dailyofferscontainer' => $dailyofferscontainer,
                'psfourofferscontainer' => $psfourofferscontainer,
                'psthreeofferscontainer' => $psthreeofferscontainer
            ]);
        }

        /**
         * @Route("/panel/tienda/fortnite", name="dashboard-store-fortnite")
         */
        public function fortnitedashboard(Request $request)
        {

         $menurepository = $this->getDoctrine()->getRepository(Menu::class);
         $container = $menurepository->findOneBy([ 'name' => 'store-fortnite' ]);

          $repository = $this->getDoctrine()->getRepository(Game::class);
          $products = $repository
          ->findBy( ['Target' => 'store-fortnite'] );

            return $this->render('dashboard/storeproducts.html.twig', [
                'controller_name' => 'Panel de Administración - Fortnite - TooPlay',
                'section' => 'Tienda',
                'target' => 'Fortnite',
                'products' => $products,
                'container' => $container,
            ]);
        }

        /**
         * @Route("/panel/tienda/ps/preorden", name="dashboard-store-pspreorder")
         */
        public function pspreorderdashboard(Request $request)
        {

         $menurepository = $this->getDoctrine()->getRepository(Menu::class);
         $container = $menurepository->findOneBy([ 'name' => 'po_playstation' ]);

          $repository = $this->getDoctrine()->getRepository(Game::class);
          $products = $repository
          ->findBy( ['Target' => 'po_playstation'] );

            return $this->render('dashboard/storeproducts.html.twig', [
                'controller_name' => 'Panel de Administración - Pre Orden PS - TooPlay',
                'section' => 'Tienda',
                'target' => 'Pre Orden PS',
                'products' => $products,
                'container' => $container,
            ]);
        }

        /**
         * @Route("/panel/tienda/ps3/juegos", name="dashboard-store-ps3games")
         */
        public function psthreedashboard(Request $request)
        {

          $repository = $this->getDoctrine()->getRepository(Game::class);
          $products = $repository
          ->findBy( ['Target' => 'juegos_ps3'] );

          $menurepository = $this->getDoctrine()->getRepository(Menu::class);
          $container = $menurepository->findOneBy([ 'name' => 'juegos_ps3' ]);


            return $this->render('dashboard/storeproducts.html.twig', [
                'controller_name' => 'Panel de Administración - Juegos PS3 - TooPlay',
                'section' => 'Tienda',
                'target' => 'Juegos PS3',
                'products' => $products,
                'container' => $container,
            ]);
        }

        /**
         * @Route("/panel/tienda/ps3/packs", name="dashboard-store-ps3packs")
         */
        public function psthreepacksdashboard(Request $request)
        {

          $menurepository = $this->getDoctrine()->getRepository(Menu::class);
          $container = $menurepository->findOneBy([ 'name' => 'pack_ps3' ]);


                  $repository = $this->getDoctrine()->getRepository(Game::class);
                  $products = $repository
                  ->findBy( ['Target' => 'pack_ps3'] );
            return $this->render('dashboard/storeproducts.html.twig', [
                'controller_name' => 'Panel de Administración - Pack PS3 - TooPlay',
                'section' => 'Tienda',
                'target' => 'Pack PS3',
                'products' => $products,
                'container' => $container,
            ]);
        }

        /**
         * @Route("panel/tienda/ps4/primarias", name="dashboard-store-primaryps4games")
         */
        public function psfourprimarydashboard(Request $request)
        {

          $menurepository = $this->getDoctrine()->getRepository(Menu::class);
          $container = $menurepository->findOneBy([ 'name' => 'primarias_ps4' ]);


                  $repository = $this->getDoctrine()->getRepository(Game::class);
                  $products = $repository
                  ->findBy( ['Target' => 'primarias_ps4'] );
            return $this->render('dashboard/storeproducts.html.twig', [
                'controller_name' => 'Panel de Administración - Primarias PS4 - TooPlay',
                'section' => 'Tienda',
                'target' => 'Primarias PS4',
                'products' => $products,
                'container' => $container,
            ]);
        }

        /**
         * @Route("panel/tienda/ps4/secundarias", name="dashboard-store-secondaryps4games")
         */
        public function psfoursecondarydashboard(Request $request)
        {

          $menurepository = $this->getDoctrine()->getRepository(Menu::class);
          $container = $menurepository->findOneBy([ 'name' => 'secundarias_ps4' ]);


                  $repository = $this->getDoctrine()->getRepository(Game::class);
                  $products = $repository
                  ->findBy( ['Target' => 'secundarias_ps4'] );
            return $this->render('dashboard/storeproducts.html.twig', [
                'controller_name' => 'Panel de Administración - Secundarias PS4 - TooPlay',
                'section' => 'Tienda',
                'target' => 'Secundarias PS4',
                'products' => $products,
                'container' => $container,
            ]);
        }

        /**
         * @Route("panel/tienda/ps/primarias-offline", name="dashboard-store-psofflineprimary")
         */
        public function psofflineprimarydashboard(Request $request)
        {



          $menurepository = $this->getDoctrine()->getRepository(Menu::class);
          $container = $menurepository->findOneBy([ 'name' => 'primarias_offline_ps' ]);


                  $repository = $this->getDoctrine()->getRepository(Game::class);
                  $products = $repository
                  ->findBy( ['Target' => 'primarias_offline_ps'] );
            return $this->render('dashboard/storeproducts.html.twig', [
                'controller_name' => 'Panel de Administración - Primarias Offline - TooPlay',
                'section' => 'Tienda',
                'target' => 'Primarias Offline',
                'products' => $products,
                'container' => $container,
            ]);
        }

        /**
         * @Route("panel/tienda/ps/tarjetas", name="dashboard-store-pscards")
         */
        public function pscardsdashboard(Request $request)
        {



          $menurepository = $this->getDoctrine()->getRepository(Menu::class);
          $container = $menurepository->findOneBy([ 'name' => 'cd_ps' ]);


                  $repository = $this->getDoctrine()->getRepository(Game::class);
                  $products = $repository
                  ->findBy( ['Target' => 'cd_ps'] );
            return $this->render('dashboard/storeproducts.html.twig', [
                'controller_name' => 'Panel de Administración - Tarjetas PlayStation - TooPlay',
                'section' => 'Tienda',
                'target' => 'Tarjetas PlayStation',
                'products' => $products,
                'container' => $container,
            ]);
        }

        /**
         * @Route("panel/tienda/steam/preorden", name="dashboard-store-steampreorder")
         */
        public function steampreorderdashboard(Request $request)
        {



          $menurepository = $this->getDoctrine()->getRepository(Menu::class);
          $container = $menurepository->findOneBy([ 'name' => 'po_windows' ]);


                  $repository = $this->getDoctrine()->getRepository(Game::class);
                  $products = $repository
                  ->findBy( ['Target' => 'po_windows'] );
            return $this->render('dashboard/storeproducts.html.twig', [
                'controller_name' => 'Panel de Administración - PreOrden Steam - TooPlay',
                'section' => 'Tienda',
                'target' => 'PreOrden Steam',
                'products' => $products,
                'container' => $container,
            ]);
        }

        /**
         * @Route("panel/tienda/pc/steam", name="dashboard-store-steamgames")
         */
        public function steamgamesdashboard(Request $request)
        {



          $menurepository = $this->getDoctrine()->getRepository(Menu::class);
          $container = $menurepository->findOneBy([ 'name' => 'juegos_steam' ]);

                  $repository = $this->getDoctrine()->getRepository(Game::class);
                  $products = $repository
                  ->findBy( ['Target' => 'juegos_steam'] );
            return $this->render('dashboard/storeproducts.html.twig', [
                'controller_name' => 'Panel de Administración - Juegos Steam - TooPlay',
                'section' => 'Tienda',
                'target' => 'Juegos Steam',
                'products' => $products,
                'container' => $container,
            ]);
        }

        /**
         * @Route("panel/tienda/xboxone/juegos", name="dashboard-store-xboxonegames")
         */
        public function xboxonegamesdashboard(Request $request)
        {



          $menurepository = $this->getDoctrine()->getRepository(Menu::class);
          $container = $menurepository->findOneBy([ 'name' => 'juegos_xbox' ]);


                  $repository = $this->getDoctrine()->getRepository(Game::class);
                  $products = $repository
                  ->findBy( ['Target' => 'juegos_xbox'] );
            return $this->render('dashboard/storeproducts.html.twig', [
                'controller_name' => 'Panel de Administración - Juegos XBOX One - TooPlay',
                'section' => 'Tienda',
                'target' => 'Juegos XBOX One',
                'products' => $products,
                'container' => $container,
            ]);
        }

        /**
         * @Route("panel/tienda/xboxone/tarjetas", name="dashboard-store-xboxonecards")
         */
        public function xboxonecardsdashboard(Request $request)
        {


          $menurepository = $this->getDoctrine()->getRepository(Menu::class);
          $container = $menurepository->findOneBy([ 'name' => 'cd_windows' ]);


                  $repository = $this->getDoctrine()->getRepository(Game::class);
                  $products = $repository
                  ->findBy( ['Target' => 'cd_windows'] );
            return $this->render('dashboard/storeproducts.html.twig', [
                'controller_name' => 'Panel de Administración - Tarjetas XBOX - TooPlay',
                'section' => 'Tienda',
                'target' => 'Tarjetas XBOX',
                'products' => $products,
                'container' => $container,
            ]);
        }

        /**
         * @Route("panel/tienda/giftcard/itunes", name="dashboard-store-giftcard-itunes")
         */
        public function giftcarditunesdashboard(Request $request)
        {


          $menurepository = $this->getDoctrine()->getRepository(Menu::class);
          $container = $menurepository->findOneBy([ 'name' => 'gf_itunes' ]);


                  $repository = $this->getDoctrine()->getRepository(Game::class);
                  $products = $repository
                  ->findBy( ['Target' => 'gf_itunes'] );
            return $this->render('dashboard/storeproducts.html.twig', [
                'controller_name' => 'Panel de Administración - Giftcard Itunes - TooPlay',
                'section' => 'Tienda',
                'target' => 'Giftcard Itunes',
                'products' => $products,
                'container' => $container,
            ]);
        }

        /**
         * @Route("panel/tienda/giftcard/googleplay", name="dashboard-store-giftcard-googleplay")
         */
        public function giftcardgoogleplaydashboard(Request $request)
        {


          $menurepository = $this->getDoctrine()->getRepository(Menu::class);
          $container = $menurepository->findOneBy([ 'name' => 'gf_googleplay' ]);

                    $repository = $this->getDoctrine()->getRepository(Game::class);
                    $products = $repository
                    ->findBy( ['Target' => 'gf_googleplay'] );
            return $this->render('dashboard/storeproducts.html.twig', [
                'controller_name' => 'Panel de Administración - Giftcard Google Play - TooPlay',
                'section' => 'Tienda',
                'target' => 'Giftcard Google Play',
                'products' => $products,
                'container' => $container,
            ]);
        }

        /**
         * @Route("panel/tienda/giftcard/psn", name="dashboard-store-giftcard-psn")
         */
        public function giftcardpsnsdashboard(Request $request)
        {


          $menurepository = $this->getDoctrine()->getRepository(Menu::class);
          $container = $menurepository->findOneBy([ 'name' => 'gf_psn' ]);


                  $repository = $this->getDoctrine()->getRepository(Game::class);
                  $products = $repository
                  ->findBy( ['Target' => 'gf_psn'] );
            return $this->render('dashboard/storeproducts.html.twig', [
                'controller_name' => 'Panel de Administración - Giftcard PSN - TooPlay',
                'section' => 'Tienda',
                'target' => 'Giftcard PSN',
                'products' => $products,
                'container' => $container,
            ]);
        }

        /**
         * @Route("panel/tienda/giftcard/amazon", name="dashboard-store-giftcard-amazon")
         */
        public function giftcardamazondashboard(Request $request)
        {

          $menurepository = $this->getDoctrine()->getRepository(Menu::class);
          $container = $menurepository->findOneBy([ 'name' => 'gf_amazon' ]);


                  $repository = $this->getDoctrine()->getRepository(Game::class);
                  $products = $repository
                  ->findBy( ['Target' => 'gf_amazon'] );
            return $this->render('dashboard/storeproducts.html.twig', [
                'controller_name' => 'Panel de Administración - Giftcard Amazon - TooPlay',
                'section' => 'Tienda',
                'target' => 'Giftcard Amazon',
                'products' => $products,
                'container' => $container,
            ]);
        }

        /**
         * @Route("panel/tienda/giftcard/paypal", name="dashboard-store-giftcard-paypal")
         */
        public function giftcardpaypaldashboard(Request $request)
        {

          $menurepository = $this->getDoctrine()->getRepository(Menu::class);
          $container = $menurepository->findOneBy([ 'name' => 'gf_paypal' ]);


                  $repository = $this->getDoctrine()->getRepository(Game::class);
                  $products = $repository
                  ->findBy( ['Target' => 'gf_paypal'] );
            return $this->render('dashboard/storeproducts.html.twig', [
                'controller_name' => 'Panel de Administración - Giftcard Paypal - TooPlay',
                'section' => 'Tienda',
                'target' => 'Giftcard Paypal',
                'products' => $products,
                'container' => $container,
            ]);
        }

        /**
         * @Route("panel/tienda/giftcard/steam", name="dashboard-store-giftcard-steam")
         */
        public function giftcardsteamdashboard(Request $request)
        {

          $menurepository = $this->getDoctrine()->getRepository(Menu::class);
          $container = $menurepository->findOneBy([ 'name' => 'gf_steam' ]);


                  $repository = $this->getDoctrine()->getRepository(Game::class);
                  $products = $repository
                  ->findBy( ['Target' => 'gf_steam'] );
            return $this->render('dashboard/storeproducts.html.twig', [
                'controller_name' => 'Panel de Administración - Giftcard Steam - TooPlay',
                'section' => 'Tienda',
                'target' => 'Giftcard Steam',
                'products' => $products,
                'container' => $container,
            ]);
        }

        /**
         * @Route("panel/tienda/giftcard/xbox", name="dashboard-store-giftcard-xbox")
         */
        public function giftcardxboxdashboard(Request $request)
        {

          $menurepository = $this->getDoctrine()->getRepository(Menu::class);
          $container = $menurepository->findOneBy([ 'name' => 'gf_xbox' ]);


                  $repository = $this->getDoctrine()->getRepository(Game::class);
                  $products = $repository
                  ->findBy( ['Target' => 'gf_xbox'] );
            return $this->render('dashboard/storeproducts.html.twig', [
                'controller_name' => 'Panel de Administración - Giftcard XBOX - TooPlay',
                'section' => 'Tienda',
                'target' => 'Giftcard XBOX',
                'products' => $products,
                'container' => $container,
            ]);
        }

        /**
         * @Route("panel/tienda/giftcard/nintendoeshop", name="dashboard-store-giftcard-nintendoeshop")
         */
        public function giftcardnintendoeshopdashboard(Request $request)
        {

          $menurepository = $this->getDoctrine()->getRepository(Menu::class);
          $container = $menurepository->findOneBy([ 'name' => 'gf_nintendoeshop' ]);


                  $repository = $this->getDoctrine()->getRepository(Game::class);
                  $products = $repository
                  ->findBy( ['Target' => 'gf_nintendoeshop'] );
            return $this->render('dashboard/storeproducts.html.twig', [
                'controller_name' => 'Panel de Administración - Giftcard Nintendo EShop - TooPlay',
                'section' => 'Tienda',
                'target' => 'Giftcard Nintendo EShop',
                'products' => $products,
                'container' => $container,
            ]);
        }

        /**
         * @Route("panel/metodos-de-pago", name="dashboard-paymentmethods")
         */
        public function paymentmethodsdashboard(Request $request)
        {

          $instructionsrepository = $this->getDoctrine()->getRepository(PaymentInstructions::class);

          $ins_cajavecina = $instructionsrepository
          ->findOneBy( ['name' => 'ins_cajavecina'] );

          $ins_transferencia = $instructionsrepository
          ->findOneBy( ['name' => 'ins_transferencia'] );

          $ins_webpay = $instructionsrepository
          ->findOneBy( ['name' => 'ins_webpay'] );

          $ins_paypal = $instructionsrepository
          ->findOneBy( ['name' => 'ins_paypal'] );


            return $this->render('dashboard/payment_methods.html.twig', [
                'controller_name' => 'Panel de Administración - Métodos de Pago - TooPlay',
                'section' => 'Métodos de Pago',
                'ins_cajavecina' => $ins_cajavecina,
                'ins_transferencia' => $ins_transferencia,
                'ins_webpay' => $ins_webpay,
                'ins_paypal' => $ins_paypal,
            ]);
        }

        /**
        * @Route("panel/metodos-de-pago/toggle", name="dashboard-togglepaymentmethods")
        */
        public function togglepaymentmethodsdashboard(Request $request){

        if($paymentmethodId = $request->request->get('paymentmethodid')){
                 $instructionsrepository = $this->getDoctrine()->getRepository(PaymentInstructions::class);
                 $paymentMethod = $instructionsrepository->findOneById($paymentmethodId);

                 $isvisible = ((bool) $paymentMethod->getisvisible() ? 0 : 1);

                 $paymentMethod->setIsVisible($isvisible);
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($paymentMethod);
                 $entityManager->flush();


                 return new JsonResponse( array(
                      'id' => $paymentmethodId,
                      'isvisible' => $isvisible
                 ));

        }

        }

        /**
        * @Route("panel/metodos-de-pago/editar/{id}", name="dashboard-paymentmethods-edit")
        */

        public function editpaymentmethodsdashboard(Request $request, $id){

          $instructions = $this->getDoctrine()->getRepository(PaymentInstructions::class)->find($id);

          $form = $this->createFormBuilder($instructions)
          ->add('instructions', TextareaType::class)
          ->add('voucherexample', FileType::class, array('data_class' => null))
          ->add('save', SubmitType::class, array('label' => 'Guardar'))
           ->getForm();

           $form->handleRequest($request);

           if ($form->isSubmitted() && $form->isValid()) {

             $file = $form->get('voucherexample')->getData();


             if($file!=null){
               $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
               $file->move(
                   $this->getParameter('productcovers_directory'),
                   $fileName
               );

               $instructions->setVoucherexample($fileName);
             }


             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($instructions);
             $entityManager->flush();

             return $this->redirect($this->generateUrl('dashboard-paymentmethods'));

           }


          return $this->render('dashboard/payment_methodsmanagement.html.twig', [
            'controller_name' => 'Edición',
            'form' => $form->createView(),
          ]);

        }


        /**
         * @return string
         */
        private function generateUniqueFileName()
        {
            // md5() reduces the similarity of the file names generated by
            // uniqid(), which is based on timestamps
            return md5(uniqid());
        }

        /**
         * @return string
         */
        private function generateDiscountPercentage($product)
        {
            // md5() reduces the similarity of the file names generated by
            // uniqid(), which is based on timestamps
            return 100 - ($product->getFinalPrice() * 100) / $product->getOriginalPrice();
        }

        /**
         * @return void
         */
        private function storeintoDatabase($fileName, $product, $type, $target)
        {
            // md5() reduces the similarity of the file names generated by
            // uniqid(), which is based on timestamps
            $product->setCover($fileName);

            $product->setDiscountPercentage($this->generateDiscountPercentage($product));

            if($type!=""){
            $product->setType($type);
          }
            $product->setTarget($target);
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($product);

            $entityManager->flush();
        }

  }
