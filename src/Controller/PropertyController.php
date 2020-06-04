<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\ContactType;
use App\Form\PropertySearchType;
use App\MailerNotification\MailerNotification;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @Route("/biens", name="property_index")
     */
    public function index(PropertyRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        // X Créer une entité qui va représenter notre recherche => PropertySearch
        // X Créer un formulaire => PropertySearchType
        // Gérer le traitement dans le controller
        $search = new PropertySearch;
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);

        $query = $repo->findAllVisibleQuery($search);
        $properties = $paginator->paginate($query, $request->query->getInt('page', 1), 12);
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties,
            'searchForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property_show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(Property $property, string $slug, Request $request, MailerNotification $notification)
    {
        if($property->getSlug() !== $slug){
            return $this->redirectToRoute('property_show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        $contact = new Contact();
        $contact->setProperty($property);
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $notification->notify($contact);
            $this->addFlash('success', "Votre message a été envoyé avec succès");
            
            return $this->redirectToRoute('property_show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ]);
        }

        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property' => $property,
            'contactForm' => $form->createView()    
        ]);
    }

}
