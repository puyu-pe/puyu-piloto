<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyRepresentantController extends AbstractController
{
    #[Route('/', name: 'company_representant_list')]
     public function list(){
        return new Response('lista de representantes de empresas');
    }
}