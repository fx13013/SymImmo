<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{
    /**
     * @Route("/admin/property", name="admin_property_index")
     */
    public function index(PropertyRepository $repo)
    {
        $properties = $repo->findAll();

        return $this->render('admin_property/index.html.twig', [
           'properties' => $properties
        ]);
    }

    /**
     * @Route("admin/property/edit/{id}", name="admin_property_edit", methods={"GET", "POST"})
     */
    public function edit(Property $property, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->flush();
            // TODO Add flash success
            $this->addFlash('success', "Le bien a été modifié avec succès");
            return $this->redirectToRoute('admin_property_index');
        }

        return $this->render('admin_property/edit.html.twig', [
            'property' => $property,
            'propertyForm' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/property/new", name="admin_property_new")
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(PropertyType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            /** @var Property */
            $property = $form->getData();

            $manager->persist($property);
            $manager->flush();

            $this->addFlash('success', "Le bien a été créé avec succès");

            return $this->redirectToRoute('admin_property_index');
        }

        return $this->render('admin_property/new.html.twig', [
            'propertyForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/delete/{id}", name="admin_property_delete", methods="DELETE")
     */
    public function delete(Property $property, EntityManagerInterface $manager, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))){
            $manager->remove($property);
            $manager->flush();
            $this->addFlash('success', "Bien supprimé avec succès");
        }
        return $this->redirectToRoute('admin_property_index');
    }
}
