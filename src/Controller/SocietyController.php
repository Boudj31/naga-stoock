<?php

namespace App\Controller;

use App\Entity\Society;
use App\Form\SearchSocietyType;
use App\Form\SocietyType;
use App\Repository\SocietyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/society")
 */
class SocietyController extends AbstractController
{
    /**
     * @Route("/", name="society_index", methods={"GET"})
     */
    public function index(SocietyRepository $societyRepository, PaginatorInterface $paginatorInterface, Request $request ): Response
    {

        $societies = $paginatorInterface->paginate(
            $societyRepository->findAllPagination(),
            $request->query->getInt('page', 1), /*page number*/
            4 /*limit par page*/
        );
        return $this->render('society/index.html.twig', [
            'societies' => $societies
        ]);
    }

    /**
     * @Route("/show/{id}", name="society_show", methods={"GET"})
     */
    public function show(Society $society): Response
    {
        return $this->render('society/show.html.twig', [
            'society' => $society,
        ]);
    }

    /**
     * @Route("/new", name="society_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $society = new Society();
        $form = $this->createForm(SocietyType::class, $society);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($society);
            $entityManager->flush();

            return $this->redirectToRoute('society_index');
        }

        return $this->render('society/new.html.twig', [
            'society' => $society,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="society_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Society $society): Response
    {
        $form = $this->createForm(SocietyType::class, $society);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('society_index');
        }

        return $this->render('society/edit.html.twig', [
            'society' => $society,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="society_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Society $society): Response
    {
        if ($this->isCsrfTokenValid('delete'.$society->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($society);
            $entityManager->flush();
        }

        return $this->redirectToRoute('society_index');
    }

    public function getSearchSocietyForm()
    {
        $form = $this->createForm(SearchSocietyType::class, null, [
            'method' => 'get',
            'action' => $this->generateUrl('search_society'),
        ]);;

        return $this->render('form/_search_form.html.twig', [
            'search_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/search", name="search_society", methods={"GET"})
     */
    public function search(Request $request, SocietyRepository $societyRepository): Response
    {
        $results = null;
        if ('GET' === $request->getMethod()) {
            $results = $societyRepository->findSociety(
                $request->query->get('search_society')['mot']
            );
        }

        return $this->render('/society/search.html.twig', [
            'search_society' => $results ? $results : $societyRepository->findAll(),
        ]);
    }

}
