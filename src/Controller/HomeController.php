<?php

namespace App\Controller;

use App\Repository\CustomersRepository;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{
    /**
     * @Route("/home", name="home_page")
     */
    public function homeAction(ProductsRepository $repo): Response
    {
        $products = $repo->findAll();
        return $this->render('home/index.html.twig', [
            'products' => $products
        ]);
    }
}
