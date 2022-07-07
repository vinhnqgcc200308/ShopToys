<?php

namespace App\Controller;

use App\Repository\CustomersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

date_default_timezone_set("Asia/Ho_Chi_Minh");
class CustomersController extends AbstractController
{

    /**
     * @Route("/customers", name="app_customers")
     */
    public function customersAction(CustomersRepository $repo): Response
    {
        $customers = $repo->findAll();
        return $this->render('customers/index.html.twig', [
            'customers' => $customers
        ]);
    }
}
