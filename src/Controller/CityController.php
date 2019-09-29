<?php
namespace App\Controller;

use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\City;



/**
 * Product controller.
 * @Route("/api", name="api_")
 */

class CityController extends FOSRestController
{


    /**
     * Lists all Cities.
     * @Rest\Get("/cities")
     *
     * @param Request $request
     * @return Response
     */
    public function getCitiesAction(Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(City::class);
        $cities = $repository->findall();
        return $this->handleView($this->view($cities));
    }

    /**
     * @Rest\Get("/cities/{id}")
     */
    public function idAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository(City::class)->find($id);
        if ($singleresult === null) {
            return new View("City: id = ".$id." Not Found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    /**
     * @Rest\Post("/city/")
     */
    public function postAction(Request $request)
    {
        $city = new City;
        $name = $request->get('name');
        $timezone = $request->get('timezone');
        $country = $request->get('country');
        $dataTemp = $request->get('data');
        if(empty($name) || empty($timezone) || empty($country) || empty($dataTemp))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $city->setName($name);
        $city->setTimezone($timezone);
        $city->setCountry($country);
        $city->setData($dataTemp);
        $em = $this->getDoctrine()->getManager();
        $em->persist($city);
        $em->flush();
        return new View("city Added Successfully", Response::HTTP_OK);
    }
    /**
     * @Rest\Put("/city/{id}")
     */
    public function updateAction($id,Request $request)
    {

        $name = $request->get('name');
        $timezone = $request->get('timezone');
        $country = $request->get('country');
        $dataTemp = $request->get('data');

        $city = $this->getDoctrine()->getRepository(City::class)->find($id);
        if (empty($city)) {
            return new View("City not found", Response::HTTP_NOT_FOUND);
        }
        if(empty($name) || empty($timezone) || empty($country) || empty($dataTemp))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $city->setName($name);
        $city->setTimezone($timezone);
        $city->setCountry($country);
        $city->setData($dataTemp);
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new View("city Name Updated Successfully", Response::HTTP_OK);

    }

    /**
     * @Rest\Delete("/city/{id}")
     */
    public function deleteAction($id)
    {
        $data = new City();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(City::class)->find($id);
        if (empty($user)) {
            return new View("city not found", Response::HTTP_NOT_FOUND);
        }
        else {
            $em->remove($user);
            $em->flush();
        }
        return new View("City ".$id." was deleted successfully", Response::HTTP_OK);
    }

}