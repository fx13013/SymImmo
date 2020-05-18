<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @Route("/biens", name="property_index")
     */
    public function index(PropertyRepository $repo)
    {
        $properties = $repo->findLatest();
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property_show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(Property $property, string $slug)
    {
        if($property->getSlug() !== $slug){
            return $this->redirectToRoute('property_show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property' => $property    
        ]);
    }

}
