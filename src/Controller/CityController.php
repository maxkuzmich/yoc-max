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
        $data=json_decode($singleresult->getData(), true);

        $singleresult->setTemp($data[0]['temp']);
        $singleresult->setMinTemp($data[0]['min_temp']);
        $singleresult->setMaxTemp($data[0]['max_temp']);
        $singleresult->setDateTime($data[0]['datetime']);

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
    /**
     * Lists all Cities.
     * @Rest\Get("/report")
     *
     * @param Request $request
     * @return Response
     */
    public function getCitiesReportAction(Request $request)
    {
        $checkDateRange=false;
        $checkTemp=false;
        $repository = $this->getDoctrine()->getRepository(City::class);
        $cities = $repository->findall();
        $startDate=$request->get('start_date');
        $endDate=$request->get('send_date');
        if($startDate and $endDate)
           $checkDateRange=true;
        $less=$request->get('less');
        $higher=$request->get('higher');
        if($less and $higher)
            $checkTemp=true;
        foreach($cities as $key => $item)
        {
            $data=json_decode($item->getData(), true);
            if(isset($data[0])) {
                $item->setTemp($data[0]['temp']);
                $item->setMinTemp($data[0]['min_temp']);
                $item->setMaxTemp($data[0]['max_temp']);
                $item->setDateTime($data[0]['datetime']);
            }
            if($checkDateRange){
                if(strtotime($data[0]['datetime'])<strtotime($startDate) and strtotime($data[0]['datetime'])>strtotime($endDate))
                    unset($cities[$key]);
            }
            if($checkTemp){
                if($data[0]['temp']>$higher or $data[0]['temp']<$less)
                    unset($cities[$key]);
            }
        }
        return $this->handleView($this->view($cities));
    }

}