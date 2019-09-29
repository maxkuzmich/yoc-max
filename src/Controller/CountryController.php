<?php

namespace App\Controller;

use App\Entity\Country;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Product controller.
 * @Route("/api", name="api_")
 */
class CountryController extends FOSRestController
{
    /**
     * Lists all Countries.
     * @Rest\Get("/")
     *
     * @param Request $request
     * @return Response
     */
    public function defaultAction(Request $request)
    {
        return '{"hello":"word!"}';
    }
    /**
     * Lists all Countries.
     * @Rest\Get("/country")
     *
     * @param Request $request
     * @return Response
     */
    public function getCitiesAction(Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(Country::class);
        $cities = $repository->findall();
        return $this->handleView($this->view($cities));
    }

    /**
     * @Rest\Post("/country/")
     * @param Request $request
     * @return Response
     */
    public function postAction(Request $request)
    {
        $name = $request->get('name');
        $code = $request->get('code');
        if(empty($name) || empty($code))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $country = new Country();
        $country->setName($name);
        $country->setCode($code);


        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($country);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new View("Country was added Successfully", Response::HTTP_OK);
    }

}
