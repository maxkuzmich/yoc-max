<?php

namespace App\Controller;

use App\Entity\Country;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends AbstractController
{
    /**
     * @Route("/country", name="country")
     */
//    public function index()
//    {
//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/CountryController.php',
//        ]);
//    }

    /**
     * @Route("/country", name="create_country")
     */
    public function createCountry(): Response
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $country = new Country();
        $country->setName('Spain');
        $country->setCode("ES");


        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($country);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new country with id '.$country->getId());
    }

    /**
     * @Route("/country/{id}", name="country_show")
     */
//    public function show($id)
//    {
//        $country = $this->getDoctrine()
//            ->getRepository(Country::class)
//            ->find($id);
//
//        if (!$country) {
//            throw $this->createNotFoundException(
//                'No country found for id '.$id
//            );
//        }
//
//        return new Response('Check out this great country: '.$country->getName());
//
//        // or render a template
//        // in the template, print things with {{ country.name }}
//        // return $this->render('country/show.html.twig', ['country' => $country]);
//    }

    /**
     * @Route("/country/all", name="country_show_all")
     */
    public function getListOfCounties():Response
    {
        $repository = $this->getDoctrine()->getRepository(Country::class);

        $countries = $repository->findAll();
        print_r($countries);die;
        $response = new Response(serialize($countries));
        $response->headers->set('Content-Type', 'application/json');

    }
}
