<?php

namespace App\Controller;

use App\Entity\Data;
use App\Form\DataType;
use App\Repository\DataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/data")
 */
class DataController extends AbstractController
{
    /**
     * @Route("/", name="data_index", methods={"GET"})
     */
    public function index(DataRepository $dataRepository): Response
    {
        return $this->render('data/index.html.twig', [
            'data' => $dataRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="data_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $data = new Data();
        $form = $this->createForm(DataType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();

            return $this->redirectToRoute('data_index');
        }

        return $this->render('data/new.html.twig', [
            'data' => $data,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="data_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Data $data): Response
    {
        $form = $this->createForm(DataType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('data_index');
        }

        return $this->render('data/edit.html.twig', [
            'data' => $data,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="data_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Data $data): Response
    {
        if ($this->isCsrfTokenValid('delete'.$data->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($data);
            $entityManager->flush();
        }

        return $this->redirectToRoute('data_index');
    }
}
