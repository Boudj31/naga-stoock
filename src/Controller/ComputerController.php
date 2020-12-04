<?php

namespace App\Controller;

use App\Entity\Computer;
use App\Form\ComputerType;
use App\Repository\ComputerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/computer")
 */
class ComputerController extends AbstractController
{
    /**
     * @Route("/", name="computer_index", methods={"GET"})
     */
    public function index(ComputerRepository $computerRepository): Response
    {
        return $this->render('computer/index.html.twig', [
            'computers' => $computerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="computer_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $computer = new Computer();
        $form = $this->createForm(ComputerType::class, $computer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($computer);
            $entityManager->flush();

            return $this->redirectToRoute('computer_index');
        }

        return $this->render('computer/new.html.twig', [
            'computer' => $computer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="computer_show", methods={"GET"})
     */
    public function show(Computer $computer): Response
    {
        return $this->render('computer/show.html.twig', [
            'computer' => $computer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="computer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Computer $computer): Response
    {
        $form = $this->createForm(ComputerType::class, $computer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('computer_index');
        }

        return $this->render('computer/edit.html.twig', [
            'computer' => $computer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="computer_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Computer $computer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$computer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($computer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('computer_index');
    }
}
