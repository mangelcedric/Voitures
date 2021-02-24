<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/car", name="car_")
 */
class CarController extends AbstractController
{
    /**
    * @Route("/", name="browse")
    */
    public function browse(CarRepository $carRepository): Response
    {
        return $this->render('car/browse.html.twig', [
            'cars' => $carRepository->findAllWithBrands(),
        ]);
    }

    /**
    * @Route("/add", name="add")
    */
    public function add(Request $request): Response
    {
        $car = new Car();

        $form = $this->createForm(CarType::class, $car); 
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush();

            return $this->redirectToRoute('car_browse');
        }

        return $this->render('car/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", requirements={"id":"\d+"})
     */
    public function edit(Car $car, Request $request)
    {
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('car_browse');
        }

        return $this->render('car/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", requirements={"id":"\d+"}, methods={"DELETE"})
     */
    public function delete(Car $car)
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($car);
            $em->flush();
            return $this->redirectToRoute('car_browse');
    }
}
