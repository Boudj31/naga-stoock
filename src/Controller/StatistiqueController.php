<?php

namespace App\Controller;

use App\Entity\Computer;
use App\Form\StatsType;
use App\Repository\ComputerRepository;
use App\Repository\MemberShipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatistiqueController extends AbstractController
{
    /**
     * @Route("/statistique", name="statistique")
     */
    public function index( MemberShipRepository $memberShipRepository, ComputerRepository $computerRepository): Response
    {
        
        $sumAmount = $memberShipRepository->selectAmountSum();
        $sumResidual = $memberShipRepository->selectResidualSum();
        $memberWComputer = $memberShipRepository->selectSumOfMembersWithComputer();
        $memberWoComputer = $memberShipRepository->selectSumOfMembersWithoutComputer();
        $sumComputer = $computerRepository->selectComputersCount();
        $member = $memberShipRepository->selectMemberCount();
        $computerInStock = $computerRepository->selectComputersInStock();
        $computerGiven = $computerRepository->selectGivenComputers();
        $totalPrice = $memberShipRepository->selectTotalMembershipPrice();
        $avgPrice = $memberShipRepository->selectAvgMembershipPrice();

        $form = $this->createForm(StatsType::class, null);

        return $this->render('statistique/index.html.twig', [
            'form' => $form->createView(),
            'sumAmount' => $sumAmount[1],
            'sumResidual' => $sumResidual[1],
            'member' => $member[1],
            'memberWComputer' => $memberWComputer,
            'memberWoComputer' => $memberWoComputer[1],
            'sumComputer' => $sumComputer[1],
            'computerInStock' => $computerInStock[1],
            'computerGiven' => $computerGiven[1],
            'totalPrice' => $totalPrice[1],
            'avgPrice' => $avgPrice[1]
        ]);
    }

}