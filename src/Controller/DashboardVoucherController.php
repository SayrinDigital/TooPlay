<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Voucher;
use App\Entity\Sale;

class DashboardVoucherController extends Controller
{
    /**
     * @Route("/panel/voucher", name="dashboard_voucher")
     */
    public function index()
    {

          $repository = $this->getDoctrine()->getRepository(Voucher::class);

          $vouchers = $repository->findBy(array(), array('id' => 'DESC'));

        return $this->render('dashboard/vouchers.html.twig', [
            'controller_name' => 'Comprobantes de Pago',
            'vouchers' => $vouchers
        ]);
    }


    /**
     * @Route("/panel/webpay", name="dashboard_webpay")
     */
     public function showWebpaySales(){

       $orders = $this->getDoctrine()
     ->getRepository(Sale::class)
     ->findAll();

       return $this->render('dashboard/sales/webpay.html.twig', [
           'controller_name' => 'Controls de Ventas por Webpay',
           'orders' => $orders
       ]);
     }

}
