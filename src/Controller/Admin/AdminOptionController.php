<?php
namespace App\Controller\Admin;


use App\Entity\Option;
use App\Form\OptionType;
use App\Repository\OptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminOptionController extends AbstractController
{
    /**
     * @Route("/admin/option", name="option_index", methods={"GET"})
     */
    public function index(OptionRepository $optionRepository): Response
    {
        return $this->render('admin_property/option/index.html.twig', [
            'options' => $optionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/option/new", name="option_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $option = new Option();
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($option);
            $entityManager->flush();

            return $this->redirectToRoute('option_index');
        }

        return $this->render('admin_property/option/new.html.twig', [
            'option' => $option,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/option/{id}/edit", name="option_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Option $option): Response
    {
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('option_index');
        }

        return $this->render('admin_property/option/edit.html.twig', [
            'option' => $option,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/option/{id}", name="option_delete")
     */
    public function delete(Option $option, EntityManagerInterface $manager): Response
    {
        $manager->remove($option);
        $manager->flush();

        $this->addFlash('success', "L'option a été supprimée avec succès");
        return $this->redirectToRoute('option_index');
    }
}
