<?php

namespace App\Controller;

use App\Entity\Cash;
use App\Form\CashType;
use App\Repository\CashRepository;
use App\Repository\ChequeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComptaController extends AbstractController
{
    /**
     * @Route("/compta", name="compta")
     */
    public function index(): Response
    {
        return $this->render('compta/index.html.twig');
    }


    /**
     * @Route("/cash", name="cash")
     */
    public function cash(CashRepository $cashRepository): Response
    {
        return $this->render('compta/cash.html.twig', [
           'cashs' => $cashRepository->findAll()
        ]);
    }

     /**
     * @Route("/deposit", name="deposit")
     */
    public function depositCash(Request $request): Response
    {
        $cash = new Cash();
        $form = $this->createForm(CashType::class, $cash, [
            'method' => 'PUT'
        ]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            
         $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('compta/deposit.html.twig', [
           'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/transfert", name="transfert")
     */
    public function transfert(): Response
    {
        return $this->render('compta/transfert.html.twig');
    }

     /**
     * @Route("/cheque", name="cheque")
     */
    public function cheque(ChequeRepository $chequeRepository): Response
    {

        return $this->render('compta/cheque.html.twig', [
            'cheques' => $chequeRepository->findAll()
        ]);
    }

    
}
