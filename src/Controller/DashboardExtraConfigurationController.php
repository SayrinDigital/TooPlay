<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Game;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DashboardExtraConfigurationController extends Controller
{
    /**
     * @Route("/panel/extra/configuracion", name="dashboard_extra_configuration")
     */
    public function index(Request $request)
    {
      return $this->redirect($this->generateUrl('dashboard-home'));

    }



}
