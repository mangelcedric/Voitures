<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Form\BrandType;
use App\Repository\BrandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/brand", name="brand_")
 */
class BrandController extends AbstractController
{
    /**
    * @Route("/", name="browse")
    */
    public function browse(BrandRepository $brandRepository): Response
    {
        return $this->render('brand/browse.html.twig', [
            'brands' => $brandRepository->findAll(),
        ]);
    }

    /**
    * @Route("/add", name="add")
    */
    public function add(Request $request): Response
    {
        $brand = new Brand();

        $form = $this->createForm(BrandType::class, $brand); 
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($brand);
            $em->flush();

            return $this->redirectToRoute('brand_browse');
        }

        return $this->render('brand/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

        /**
     * @Route("/edit/{id}", name="edit", requirements={"id":"\d+"})
     */
    public function edit(Brand $brand, Request $request)
    {
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('brand_browse');
        }

        return $this->render('brand/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", requirements={"id":"\d+"}, methods={"DELETE"})
     */
    public function delete(Brand $brand)
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($brand);
            $em->flush();

            return $this->redirectToRoute('brand_browse');
    }

    /**
    * @Route("brand_cars/{id}", name="cars_for_brand", requirements={"id":"\d+"})
    */
    public function carsForBrand(Brand $brand): Response
    {
        
        return $this->render('brand/cars_for_brand.html.twig', [
            'brands' => $brand,

        ]);
    }
}
