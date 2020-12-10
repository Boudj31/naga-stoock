<?php

namespace App\Controller;

use App\Entity\Cheque;
use App\Entity\MemberShip;
use App\Form\MemberShipType;
use App\Repository\ChequeRepository;
use App\Repository\MemberShipRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/member/ship")
 */
class MemberShipController extends AbstractController
{
    /**
     * @Route("/", name="member_ship_index", methods={"GET"})
     */
    public function index(MemberShipRepository $memberShipRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $memberShips = $paginatorInterface->paginate(
            $memberShipRepository->findAllPagination(),
            $request->query->getInt('page', 1), /*page number*/
            4 /*limit par page*/
        );
        return $this->render('member_ship/index.html.twig', [
            'member_ships' => $memberShips,
        ]);
    }

    /**
     * @Route("/new", name="member_ship_new", methods={"GET","POST"})
     */
    public function new(Request $request, ChequeRepository $chequeRepository): Response
    {
        $memberShip = new MemberShip();
        $form = $this->createForm(MemberShipType::class, $memberShip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            if ($memberShip->getMode() === "cheques") {
                    
                //$repo = $this->getDoctrine()->getRepository('TagStockComptaBundle:Cheque');
                $total = $chequeRepository->selectLastTotal();
                $cheque = new Cheque();
                $cheque->setFirstname($memberShip->getMember()->getFirstname());
                $cheque->setLastname($memberShip->getMember()->getLastname());
                $cheque->setDate(new \DateTime);
                $cheque->setAmount($memberShip->getAmount());
                $cheque->setTotal($total['total'] + $cheque->getAmount());
                $cheque->setType($memberShip->getType());
                $entityManager->persist($cheque);
                
            }
            $entityManager->persist($memberShip);
            $entityManager->flush();

            $this->addFlash('success', 'L\'adhésion a bien été prise en compte.');

            return $this->redirectToRoute('member_ship_index');
        }

        return $this->render('member_ship/new.html.twig', [
            'member_ship' => $memberShip,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="member_ship_show", methods={"GET"})
     */
    public function show(MemberShip $memberShip): Response
    {
        return $this->render('member_ship/show.html.twig', [
            'member_ship' => $memberShip,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="member_ship_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MemberShip $memberShip): Response
    {
        $form = $this->createForm(MemberShipType::class, $memberShip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('member_ship_index');
        }

        return $this->render('member_ship/edit.html.twig', [
            'member_ship' => $memberShip,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="member_ship_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MemberShip $memberShip): Response
    {
        if ($this->isCsrfTokenValid('delete'.$memberShip->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($memberShip);
            $entityManager->flush();
        }

        return $this->redirectToRoute('member_ship_index');
    }

}
