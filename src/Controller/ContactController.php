<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Form\SearchContactType;
use App\Repository\ContactRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contact_index", methods={"GET"})
     */
    public function index(
        ContactRepository $contactRepository, 
        PaginatorInterface $paginatorInterface,
        Request $request
    ): Response {

        $contacts = $paginatorInterface->paginate(
            $contactRepository->findAllPagination(),
            $request->query->getInt('page', 1), /*page number*/
            4 /*limit par page*/
        );

        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * @Route("/show/{id}", name="contact_show", methods={"GET"})
     */
    public function show(Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    /**
     * @Route("/new", name="contact_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('contact_index');
        }

        return $this->render('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}/edit", name="contact_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Contact $contact): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contact_index');
        }

        return $this->render('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contact_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Contact $contact): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contact_index');
    }


    public function getSearchForm()
    {
        $form = $this->createForm(SearchContactType::class, null, [
            'method' => 'get',
            'action' => $this->generateUrl('search_contact'),
        ]);;
        return $this->render('contact/_search_form.html.twig', [
            'search_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/search", name="search_contact", methods={"GET"})
     */
    public function search(Request $request, ContactRepository $contactRepository): Response
    {
        $results = null;
        if ('GET' === $request->getMethod()) {
            $results = $contactRepository->findContact(
                $request->query->get('search_contact')['mot']
            );
        }

        return $this->render('/contact/search.html.twig', [
            'search_contact' => $results ? $results : $contactRepository->findAll(),
        ]);
    }

}
