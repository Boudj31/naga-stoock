<?php

namespace App\Controller;

use App\Repository\ChequeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function cash(): Response
    {
        return $this->render('compta/cash.html.twig');
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
