<?php

namespace App\Controller;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController extends AbstractController
{
    public function __construct(PropertyRepository $repo, ObjectManager $em)
    {
        $this->repo = $repo;
        $this->em =$em;
   
    }

    /**
     * @Route("/admin", name="admin.property.index")
     */
    public function index():Response
    {
       $properties= $this->repo->findAll();
        return $this->render('admin_property/index.html.twig',compact('properties'));
    }

    /**
     * @Route("/admin/{id}" , name="admin.property.edit")
     * 
     */

    public function edit(Property $property, Request $request){
     
        $form =$this->createForm(PropertyType::class,$property);
        
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid()){
       
            $this->em->flush();
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin_property/edit.html.twig',[
            'property'=>$property,
            'form'=> $form->createView()
        ]);
    }
}
