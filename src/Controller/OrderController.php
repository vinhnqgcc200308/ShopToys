<?php

namespace App\Controller;

use App\Entity\Orderdetails;
use App\Entity\Orders;
use App\Repository\OrderdetailsRepository;
use App\Repository\OrdersRepository;
use App\Repository\ProductsRepository;
use App\Repository\CustomersRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

date_default_timezone_set("Asia/Ho_Chi_Minh");
class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="app_order")
     */
    public function index(): Response
    {
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }


    /**
     * @Route("/addOrder", name="add_order")
     */
    public function addOrderAction(ManagerRegistry $res, CustomersRepository $uRepo,
     $contRepo, OrdersRepository $orderRepo, ProductsRepository $proRepo): Response
    {
        $order = new Orders();
        $entity = $res->getManager();

        $user = $this->getUser();

        $curDate = new \DateTime();
        $curDate->format('H:i:s \O\n Y-m-d');


        $get = $uRepo->get($user);

        $address = $get[0]['address'];
        $phone = $get[0]['phone'];
        $client = $get[0]['Client'];

        // $orders->setOrdersDate($curDate);
        // $orders->setAddress($address);
        // $orders->setPhone($phone);
        // $orders->setCustomers($user);
        // $orders->setClient($client);


        $entity->persist($order);
        $entity->flush();

        //add to orderdetails
        $cont = $contRepo->countContain();
        $get = $cont[0]['CountCart'];

        $OrderID = $orderRepo->getOrderID($user);
        $getOrder = $OrderID[0]['OrderID'];

        $n = $orderRepo->find($getOrder);



        if($get != 0){
            for($i = 0; $i < $get; $i++){
                $orderdetails = new Orderdetails();

                $quantity = $get[$i]['quantity'];
        
                $proID = $get[$i]['ProductID'];
                $m = $proRepo->find($proID);

                // $orderdetails->setQtyPro($quantity);
                // $orderdetails->setOrderID($n);
                // $orderdetails->setProduct($m);

                $entity->persist($orderdetails);
                $entity->flush();

            
                $k = $get[$i]['ProQty'];

                $m->setQuantity($k - $quantity);

                $entity->persist($m);
                $entity->flush();
            }
        }
        else{
            return $this->json('No product to order!');
        }

        return  $this->redirectToRoute('product_page');
    }



    /**
     * @Route("/orderDetail/{id}", name="Show_OrderDetail")
     */
    public function OrderDetailAction(OrderdetailsRepository $repo, $id): Response
    {
        $show = $repo->showOrderdetail($id);
        // $orderID = $show[0]['Order_ID'];
        // $proID = $show[0]['Pro_ID'];

        return $this->render('OrderManager/OrderDetail.html.twig', [
            'order' => $show
            // 'orderID' => $orderID,
            // 'proID' => $proID
        ]);
    }

}