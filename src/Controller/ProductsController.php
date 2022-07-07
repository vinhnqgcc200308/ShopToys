<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\Type\ProductsType;
use App\Repository\ProductsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/products", name="product_page")
     */
    public function productAction(ProductsRepository $repo): Response
    {
        $products = $repo->findAll();
        
     
        return $this->render('products/index.html.twig', [
            'products' => $products
        ]);
    }


    /**
     * @Route("/addProducts", name="add_Product")
     */
    public function addProductAction(ManagerRegistry $res, Request $req): Response
    {
        $products = new Products();
        $form = $this->createForm(ProductType::class, $products);

        $form->handleRequest($req);
        $entity = $res->getManager();

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $imageFile = $form->get('Image')->getData()->getClientOriginalName();
            $products->setName($data->getName());
            $products->setQuantity($data->getQuantity());
            $products->setPrice($data->getPrice());
            $entity->persist($products);
            $entity->flush();

            return $this->redirectToRoute('pro_manager');
        }
        
        return $this->render('product/addProduct.html.twig', [
            'form' => $form->createView()
        ]);
    }
}