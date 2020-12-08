<?php

namespace App\Controller;

use App\Form\StatsType;
use App\Repository\MemberShipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatistiqueController extends AbstractController
{
    /**
     * @Route("/statistique", name="statistique")
     */
    public function index( MemberShipRepository $memberShipRepository): Response

    {
        $form = $this->createForm(StatsType::class, null);

        return $this->render('statistique/index.html.twig', [
            'form' => $form->createView(),
            'total_amounts' => $memberShipRepository->selectSalesByMonth('11', '2017'),
        ]);
    }

    public function findByYearsAndMonth() {

    }
}
