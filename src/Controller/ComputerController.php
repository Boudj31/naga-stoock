<?php

namespace App\Controller;

use App\Entity\Computer;
use App\Factory\ComputerFactory;
use App\Form\ComputerBulkType;
use App\Form\ComputerType;
use App\Form\SearchComputerType;
use App\Repository\ComputerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
    public function index(ComputerRepository $computerRepository, Request $request, PaginatorInterface $paginatorInterface): Response
    {

        $computers = $paginatorInterface->paginate(
            $computerRepository->findAllPagination(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit par page*/
        );
        return $this->render('computer/index.html.twig', [
            'computers' => $computers,
        ]);
    }

    /**
     * @Route("/show/{id}", name="computer_show", methods={"GET"})
     */
    public function show(Computer $computer): Response
    {
        return $this->render('computer/show.html.twig', [
            'computer' => $computer,
        ]);
    }

    /**
     * @Route("/new", name="computer_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, ComputerFactory $factory): Response
    {
        $computer = new Computer();
        $computer->setStatus(Computer::STOCK);
       // $computer = $computer->setStatus();

        $form = $this->createForm(ComputerBulkType::class ,
           [
            'pattern' => $computer,
            'serials' => []
          ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $computers = $factory->bulkCreate($data['serials'], $data['pattern']);

            foreach ($computers as $computer) {
                $entityManager->persist($computer);

            }
            $entityManager->flush();
            $this->addFlash('success', 'Le nouveau matériel a bien été enregistré');
            return $this->redirectToRoute('computer_index');
        }

        return $this->render('computer/new.html.twig', [
            'computer' => $computer,
            'form' => $form->createView(),
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

            $this->addFlash('success', 'Le matériel '. $computer->getSerial() .' a bien été modifié');

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

    public function getSearchComputerForm()
    {
        $form = $this->createForm(SearchComputerType::class, null, [
            'method' => 'get',
            'action' => $this->generateUrl('search_computer'),
        ]);;

        return $this->render('form/_search_form.html.twig', [
            'search_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/search", name="search_computer", methods={"GET"})
     */
    public function search(Request $request, ComputerRepository $computerRepository): Response
    {
        $results = null;
        if ('GET' === $request->getMethod()) {
            $results = $computerRepository->findComputer(
                $request->query->get('search_computer')['mot']
            );
        }

        return $this->render('/computer/search.html.twig', [
            'search_computer' => $results ? $results : '',
        ]);
    }

}
