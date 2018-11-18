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
     * @Route("/admin/new", name="admin.property.new")
     */
    public function new(Request $request){

        $property = new Property();

        $form =$this->createForm(PropertyType::class,$property);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'Ajouté avec succès');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin_property/add.html.twig',[
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/admin/{id}",name="admin.property.edit", methods="GET|POST")
     */

    public function edit(Property $property, Request $request)
    {
     
        $form =$this->createForm(PropertyType::class,$property);
        
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid()){
       
            $this->em->flush();
            $this->addFlash('success', 'Modifié avec succès');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin_property/edit.html.twig',[
            'property'=>$property,
            'form'=> $form->createView()
        ]);
    }
    

    /**
     * @Route("admin/{id}", name="admin.property.delete", methods="DELETE")
     */

    public function delete(Property $property, Request $request)
    {
        
        if($this->isCsrfTokenValid('delete'.$property->getId(), $request->get('_token')))
        {
        $this->em->remove($property);
        $this->em->flush();
        $this->addFlash('success', 'supprimé avec succès');
       }
   
    return $this->redirectToRoute('admin.property.index');
 
    }
}
