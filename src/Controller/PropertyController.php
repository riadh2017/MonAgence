<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{

    public function __construct(propertyRepository $repo, ObjectManager $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }
    /**
     * @Route("/biens", name="property.index")
     */
    public function index(): Response
    {
  
        $this->repo->findBySold();
  
        return $this->render('property/index.html.twig', [
            'controller_name' => 'PropertyController',
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug":"[a-z0-9\-]*"})
     * return Response
     */

     public function show(property $property,string $slug):Response
     {
       
        if( $property->getSlug() !== $slug){
           return $this->redirectToRoute('property.show',[
                'id'=> $property->getId(),
                'slug'=>$property->getSlug() 
            ], 301);        }
        return $this->render('property/show.html.twig',[
            'current_menu'=> 'property',
            'property'=>$property
        ]);
     }
}
