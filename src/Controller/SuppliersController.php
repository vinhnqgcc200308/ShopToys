<?php

namespace App\Controller;

use App\Entity\Suppliers;
use App\Form\Type\SupplierType;
use App\Repository\SuppliersRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SupplierController extends AbstractController
{
    /**
     * @Route("/supplier", name="app_supplier")
     */
    public function index(SuppliersRepository $repo): Response
    {
        $suppliers = $repo->findAll();
        return $this->render('supManager/index.html.twig', [
            'suppliers' => $suppliers
        ]);
    }

    /**
     * @Route("/addSupplier", name="add_supplier")
     */
    public function addAction(ManagerRegistry $res, Request $req): Response
    {
        $suppliers = new Suppliers();
        $form = $this->createForm(SupplierType::class, $suppliers);

        $form->handleRequest($req);
        $entity = $res->getManager();

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $suppliers->setName($data->getName());
            // $suppliers->setEmail($data->getEmail());

            $entity->persist($suppliers);
            $entity->flush();

            return $this->redirectToRoute('app_supplier');
        }
        return $this->render('supplier/index.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/editSupplier/{id}", name="edit_supplier")
     */
    public function editAction(ManagerRegistry $res, Request $req, SuppliersRepository $repo, $id): Response
    {
        $supplier = $repo->find($id);
        $form = $this->createForm(SupplierType::class, $supplier);

        $form->handleRequest($req);
        $entity = $res->getManager();

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $supplier->setName($data->getName());
            // $supplier->setEmail($data->getEmail());

            $entity->persist($supplier);
            $entity->flush();

            return $this->json([
                'id' => $supplier->getId()
            ]);
        }
        return $this->render('supplier/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
    * @Route("/deleteSupplier/{id}", name="deleteSupplier")
    */
    public function deleteAction(ManagerRegistry $res, Request $req, SuppliersRepository $repo, $id): Response
    {
        $entity = $res->getManager();
        $supplier = $repo->find($id);
        if(!$supplier){
            return $this->json("No project found");
        }

        $entity->remove($supplier);
        $entity->flush();

        return $this->json("Delete a project successfully with id". $id);
    }
}