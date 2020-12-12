<?php

namespace App\Controller;

use App\Entity\Cash;
use App\Form\CashType;
use App\Repository\CashRepository;
use App\Repository\ChequeRepository;
use App\Repository\TranfertRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function depositCash(Request $request, EntityManagerInterface $entityManager, CashRepository $cashRepository): Response
    {
        $cash = new Cash();
        $form = $this->createForm(CashType::class, $cash);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

         $total = $cashRepository->selectLastTotal();
         $cash->setDate(new \DateTime);
         $cash->setAmountIn(0);
         $cash->setTotal($total['total'] - $cash->getAmountOut());
         $entityManager->persist($cash);
         $entityManager->flush();
         $this->addFlash('success', 'Le dépot a bien été enregistré');
         
         return $this->redirectToRoute('cash');
        }

        return $this->render('compta/deposit.html.twig', [
           'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/transfert", name="transfert")
     */
    public function transfert(TranfertRepository $tranfertRepository): Response
    {
        return $this->render('compta/transfert.html.twig', [
            'transferts' => $tranfertRepository->findAll()
        ]);
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
