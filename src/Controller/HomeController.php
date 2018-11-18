<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use  App\Repository\RepositoryProperty;
use phpDocumentor\Reflection\Types\Object_;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     * @param PropertyRepository $repo
     * @return Response
     */
    public function index(PropertyRepository $repo): Response
    {

        $properties= $repo->findLatest();

 
        return $this->render("home/index.html.twig", [
            'properties'=>$properties
        ]);
    }


    
}




