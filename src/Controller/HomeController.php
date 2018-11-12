<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use  App\Repository\RepositoryProperty;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
 
        return $this->render('home/index.html.twig');
    }


    /**
     * @Route("/Acheter", name="property.index")
     */
    public function indexProperty(PropertyRepository $repo){


        return $this->render("property/index.html.twig",[
            'current_menu' => "property"
        ]);
    }
}
