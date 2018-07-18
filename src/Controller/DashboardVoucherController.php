<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Voucher;

class DashboardVoucherController extends Controller
{
    /**
     * @Route("/dashboard/voucher", name="dashboard_voucher")
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
}
