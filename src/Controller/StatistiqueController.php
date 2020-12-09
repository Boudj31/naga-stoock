<?php

namespace App\Controller;

use App\Entity\Computer;
use App\Form\StatsType;
use App\Repository\ComputerRepository;
use App\Repository\MemberShipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatistiqueController extends AbstractController
{  

    /**
     * @Route("/statistique", name="statistique", methods={"GET", "POST"})
     */
    public function index( MemberShipRepository $memberShipRepository, ComputerRepository $computerRepository, HttpFoundationRequest $request): Response
    {
        //total
        $sumAmount = $memberShipRepository->selectAmountSum();
        $sumResidual = $memberShipRepository->selectResidualSum();
        $member = $memberShipRepository->selectMemberCount();
        $avgPrice = $memberShipRepository->selectAvgMembershipPrice();
        $memberWComputer = $memberShipRepository->selectSumOfMembersWithComputer();
        $memberWoComputer = $memberShipRepository->selectSumOfMembersWithoutComputer();
        $sumComputer = $computerRepository->selectComputersCount();

        //computer
        $computerInStock = $computerRepository->selectComputersInStock();
        $computerGiven = $computerRepository->selectGivenComputers();
        $computerAsso = $computerRepository->selectComputersAsso();
        $computerBreak = $computerRepository->selectComputersBreak();

       // adhésion gem 3 mois
        $totalPriceGem = $memberShipRepository->selectTotalMembershipPriceGem();
        $avgPriceGem = $memberShipRepository->selectAvgMembershipPriceGem();
        $totalMemberGem = $memberShipRepository->selectTotalMembersGem();

       // adhésion rsa
         $totalPriceRSA = $memberShipRepository->selectTotalMembershipPriceRSA();
         $avgPriceRSA = $memberShipRepository->selectAvgMembershipPriceRSA();
         $totalMemberRSA = $memberShipRepository->selectTotalMembersRSA();

       // adhésion smic
         $totalPriceSMIC = $memberShipRepository->selectTotalMembershipPriceSMIC();
         $avgPriceSMIC = $memberShipRepository->selectAvgMembershipPriceSMIC();
         $totalMemberSMIC = $memberShipRepository->selectTotalMembersSMIC();

       // adhésion bénévole
       $totalPriceBenevole = $memberShipRepository->selectTotalMembershipPriceBenevole();
       $avgPriceBenevole = $memberShipRepository->selectAvgMembershipPriceBenevole();
       $totalMemberBenevole = $memberShipRepository->selectTotalMembersBenevole();

       // adhésion linux
       $totalPriceLinux = $memberShipRepository->selectTotalMembershipPriceLinux();
       $avgPriceLinux = $memberShipRepository->selectAvgMembershipPriceLinux();
       $totalMemberLinux = $memberShipRepository->selectTotalMembersLinux();

       // adhésion sup smic
       $totalPriceSup = $memberShipRepository->selectTotalMembershipPriceSup();
       $avgPriceSup = $memberShipRepository->selectAvgMembershipPricesSup();
       $totalMemberSup = $memberShipRepository->selectTotalMembersSup();

       // don
       $totalPriceDon = $memberShipRepository->selectTotalMembershipPriceGift();
       $avgPriceDon = $memberShipRepository->selectAvgMembershipPriceGift();
       $totalMemberDon = $memberShipRepository->selectTotalMembersGift();

        // vente
        $totalPriceSales = $memberShipRepository->selectTotalMembershipPriceSales();
        $avgPriceSales = $memberShipRepository->selectAvgMembershipPriceSales();
        $totalMemberSales = $memberShipRepository->selectTotalMembersSales();
        
        // form years/month
        $data = [];
        $form = $this->createForm(StatsType::class, $data,[
            'method' => 'POST'
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $sales = $memberShipRepository->selectSalesByMonth($data['year'], $data['month']);
            $computerGive = $computerRepository->selectComputerByMonth($data['year'], $data['month']);

            return $this->render('statistique/years.html.twig', [
                'data' => $data,
                'sales' => $sales[1],
                'computerGive' => $computerGive[1],
                'form' => $form->createView(),

            ]);
        }

        return $this->render('statistique/index.html.twig', [
            'form' => $form->createView(),
            // total
            'sumAmount' => $sumAmount[1],
            'sumResidual' => $sumResidual[1],
            'avgPrice' => $avgPrice[1],
            //member with and without computer
            'member' => $member[1],
            'memberWComputer' => $memberWComputer[1],
            'memberWoComputer' => $memberWoComputer[1],
            'sumComputer' => $sumComputer[1],
            //computer stats
            'computerInStock' => $computerInStock[1],
            'computerGiven' => $computerGiven[1],
            'computerAsso' => $computerAsso[1],
            'computerBreak' => $computerBreak[1],
            // GEM 3 MOIS
            'totalPriceGem' => $totalPriceGem[1],
            'avgPriceGem' => $avgPriceGem[1],
            'totalMemberGem' => $totalMemberGem[1],
             // RSA
            'totalPriceRSA' => $totalPriceRSA[1],
            'avgPriceRSA' => $avgPriceRSA[1],
            'totalMemberRSA' => $totalMemberRSA[1],
             // SMIC
            'totalPriceSMIC' => $totalPriceSMIC[1],
            'avgPriceSMIC' => $avgPriceSMIC[1],
            'totalMemberSMIC' => $totalMemberSMIC[1],
            // BENEVOLE
            'totalPriceBenevole' => $totalPriceBenevole[1],
            'avgPriceBenevole' => $avgPriceBenevole[1],
            'totalMemberBenevole' => $totalMemberBenevole[1],
            // LINUX
            'totalPriceLinux' => $totalPriceLinux[1],
            'avgPriceLinux' => $avgPriceLinux[1],
            'totalMemberLinux' => $totalMemberLinux[1],   
            // SUP SMIC
            'totalPriceSup' => $totalPriceSup[1],
            'avgPriceSup' => $avgPriceSup[1],
            'totalMemberSup' => $totalMemberSup[1],   
            // DON
            'totalPriceDon' => $totalPriceDon[1],
            'avgPriceDon' => $avgPriceDon[1],
            'totalMemberDon' => $totalMemberDon[1],   
            // Vente
            'totalPriceSales' => $totalPriceSales[1],
            'avgPriceSales' => $avgPriceSales[1],
            'totalMemberSales' => $totalMemberSales[1],                         
        ]);
    }

}