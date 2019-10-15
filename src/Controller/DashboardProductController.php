<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Game;
use App\Form\GameType;
use Symfony\Component\HttpFoundation\JsonResponse;

class DashboardProductController extends AbstractController
{

    /**
     * @Route("/panel/agregar-producto", name="dashboard-addproduct")
     */
    public function index(Request $request)
    {

      $product = new Game();
      $form = $this->createForm(GameType::class, $product);
      $form->handleRequest($request);
      $entityManager = $this->getDoctrine()->getManager();

                if ($form->isSubmitted() && $form->isValid()) {
                    $file = $form->get('cover')->getData();
                    $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                    $file->move(
                        $this->getParameter('productcovers_directory'),
                        $fileName
                    );

                    $finalNameProduct = str_replace("'", "", $form->get('title')->getData() );
                    $finalCategories = implode(" ", $form->get('genre')->getData());
                    $product->setCover($fileName);
                    $product->setTitle($finalNameProduct);
                    $product->setDiscountPercentage($this->generateDiscountPercentage($product));
                    $product->setIsVisible(1);
                    $entityManager->persist($product);

                    $entityManager->flush();

                    return $this->redirect($this->generateUrl('dashboard-home'));
    }




      return $this->render('dashboard/productmanagement.html.twig', [
          'controller_name' => 'Agregar Producto - Panel de Administración - TooPlay',
          'title' => 'Agregar Producto',
          'form' =>  $form->createView(),
      ]);
    }

    /**
     * @Route("/panel/modificar-producto/{id}", name="dashboard-modifyproduct")
     */
    public function modifyProduct(Request $request, $id)
    {

      $product = new Game();

      $entityManager = $this->getDoctrine()->getManager();
          $producttomodify = $entityManager->getRepository(Game::class)->find($id);
      $form = $this->createForm(GameType::class, $product);
      $form->get('title')->setData($producttomodify->getTitle());
      $form->get('status')->setData($producttomodify->getStatus());
      $form->get('target')->setData($producttomodify->getTarget());
      $form->get('target')->setData($producttomodify->getTarget());
      $form->get('originalprice')->setData($producttomodify->getOriginalPrice());
      $form->get('finalprice')->setData($producttomodify->getFinalPrice());
      $form->get('genre')->setData($producttomodify->getGenre());
      $form->get('description')->setData($producttomodify->getDescription());
      $form->get('console')->setData($producttomodify->getconsole());
      $form->get('size')->setData($producttomodify->getsize());
      $form->get('sizeinconsole')->setData($producttomodify->getsizeinconsole());
      $form->handleRequest($request);



      if ($form->isSubmitted() && $form->isValid()) {
          $file = $form->get('cover')->getData();

          if($file!=null){
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('productcovers_directory'),
                $fileName
            );
            $producttomodify->setCover($fileName);
          }

          $finalNameProduct = str_replace("'", "", $form->get('title')->getData() );

          $producttomodify->setTitle($finalNameProduct);
          $producttomodify->setStatus($form->get('status')->getData());
          $producttomodify->setTarget($form->get('target')->getData());
          $producttomodify->setOriginalPrice($form->get('originalprice')->getData());
          $producttomodify->setFinalPrice($form->get('finalprice')->getData());
          $producttomodify->setGenre($form->get('genre')->getData());
          $producttomodify->setDescription($form->get('description')->getData());
          $producttomodify->setSize($form->get('size')->getData());
          $producttomodify->setConsole($form->get('console')->getData());
          $producttomodify->setSizeinconsole($form->get('sizeinconsole')->getData());
          $producttomodify->setDiscountPercentage($this->generateDiscountPercentage($producttomodify));

          $entityManager->flush();

          return $this->redirect($request->getUri());
      }



      return $this->render('dashboard/productmanagement.html.twig', [
          'controller_name' => 'Modificar Producto - Panel de Administración - TooPlay',
          'title' => 'Modificar Producto',
          'form' =>  $form->createView(),
      ]);
    }

    /**
     * @Route("/panel/eliminar-producto/{id}", name="dashboard-deleteproduct")
     */
    public function removeProduct($id)
    {

                    $entityManager = $this->getDoctrine()->getManager();
                    $product = $entityManager->getRepository(Game::class)->findOneById($id);

                    $entityManager->remove($product);

                    $entityManager->flush();

          return $this->redirect($this->generateUrl('dashboard-home'));

    }

    /**
     * @Route("/panel/buscar-producto/{id}", name="dashboard-searchproduct")
     */
    public function searchProduct($id)
    {

                    $entityManager = $this->getDoctrine()->getManager();
                    $product = $entityManager->getRepository(Game::class)->findOneById($id);


                    return $this->render('dashboard/product.html.twig', [
                       'controller_name' => 'Búsqueda de Producto',
                       'product' => $product
                    ]);

    }

    /**
     * @Route("/panel/buscar-producto-nombre/{name}", name="dashboard-searchproduct")
     */
    public function searchProductByName($name)
    {

                    $entityManager = $this->getDoctrine()->getManager();
                    $products = $entityManager->getRepository(Game::class)->findByTitlePart($name);


                    return $this->render('dashboard/listproduct.html.twig', [
                       'controller_name' => 'Búsqueda de Producto',
                       'products' => $products
                    ]);

    }

  /**
  *@Route("panel/producto/ocultar/{id}", name="dashboard-toggleproduct")
  */

  public function toggleProduct($id){

        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Game::class)->findOneById($id);

        $isvisible = ((bool) $product->getisvisible() ? 0 : 1);
        $product->setIsVisible($isvisible);

        $entityManager->persist($product);

        $entityManager->flush();

      return $this->redirect($this->generateUrl('dashboard-home'));

  }

  /**
  *@Route("panel/producto/toggle", name="dashboard-toggleproductrequest")
  */
    public function toggleProductRequest(Request $request){

      if($productId = $request->request->get('productId')){
            //make something curious, get some unbelieveable data

            $entityManager = $this->getDoctrine()->getManager();
            $product = $entityManager->getRepository(Game::class)->findOneById($productId);
            $isvisible = ((bool) $product->getisvisible() ? 0 : 1);
            $arrData = array('id' => $productId,'isvisible' => $isvisible);

            $product->setIsVisible($isvisible);

            $entityManager->persist($product);

            $entityManager->flush();


            return new JsonResponse($arrData);
        }

      return $this->redirect($this->generateUrl('dashboard-home'));

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
        return (100 - (($product->getFinalPrice() * 100) / $product->getOriginalPrice()));
    }

  }

  ?>
