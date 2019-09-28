<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\City;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class CityController extends AbstractController
{

    /**
     * @Route("/city", name="create_city")
     */
    public function createCity(): Response
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $city = new City();
        $city->setName('Berlin');
        $city->setTimezone("Europe/Berlin");
        $city->setCountry('DE');
        $city->setData("{}");

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($city);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new city with id '.$city->getId());
    }
}
