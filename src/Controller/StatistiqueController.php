<?php

namespace App\Controller;

use App\Entity\Computer;
use App\Entity\MemberShip;
use App\Form\StatsType;
use App\Repository\ComputerRepository;
use App\Repository\MemberShipRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatistiqueController extends AbstractController
{  

    /**
     * @Route("/statistique", name="statistique", methods={"GET", "POST"})
     */
    public function index(MemberShipRepository $memberShipRepository, ComputerRepository $computerRepository, Request $request): Response
    {
 
        $data = [];
        $form = $this->createForm(StatsType::class, $data);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            //$mbGem = $memberShipRepository->selectMembershipsByMonth($data['year'], $data['month'], MemberShip::MEMBERSHIP_GEM);

    
            return $this->render('statistique/years.html.twig', [
                'data' => $data,
                'memberShipGem' => $memberShipRepository->selectMembershipsByMonth($data['year'], $data['month'], MemberShip::MEMBERSHIP_GEM)[1],
                'memberShipRSA' => $memberShipRepository->selectMembershipsByMonth($data['year'], $data['month'], MemberShip::MEMBERSHIP_RSA)[1],
                'memberShipSMIC' => $memberShipRepository->selectMembershipsByMonth($data['year'], $data['month'], MemberShip::MEMBERSHIP_SMIC)[1],
                'memberShipLinux' => $memberShipRepository->selectMembershipsByMonth($data['year'], $data['month'], MemberShip::MEMBERSHIP_LINUX)[1],
                'memberShipBenevole' => $memberShipRepository->selectMembershipsByMonth($data['year'], $data['month'], MemberShip::MEMBERSHIP_BENEVOLE)[1],
                'memberShipSup' => $memberShipRepository->selectMembershipsByMonth($data['year'], $data['month'], MemberShip::MEMBERSHIP_SUP)[1],
                'sales' => $memberShipRepository->selectMembershipsByMonth($data['year'], $data['month'], MemberShip::SALES)[1],
                'computerGive' => $computerRepository->selectComputerByMonth($data['year'], $data['month'], Computer::GIVEN)[1],
                'form' => $form->createView(),

            ]);
        }

        return $this->render('statistique/index.html.twig', [
            'form' => $form->createView(),
            // total
            'sumAmount' => $memberShipRepository->selectAmountSum()[1],
            'sumResidual' => $memberShipRepository->selectResidualSum()[1],
            'avgPrice' => $memberShipRepository->selectAvgMembershipPrice()[1],
            'memberTotal' => $memberShipRepository->selectMemberTotalCount()[1],
            //member with and without computer
            'member' => $memberShipRepository->selectMemberCount()[1],
            'memberWComputer' => $memberShipRepository->selectSumOfMembersWithComputer()[1],
            'memberWoComputer' => $memberShipRepository->selectSumOfMembersWithoutComputer()[1],
            //computer fixe stats
            'sumComputer' => $computerRepository->selectComputersCount(Computer::FIXE)[1],
            'computerInStock' => $computerRepository->selectComputers(Computer::STOCK, Computer::FIXE)[1],
            'computerGiven' => $computerRepository->selectComputers(Computer::GIVEN, Computer::FIXE)[1],
            'computerAsso' => $computerRepository->selectComputers(Computer::ASSO, Computer::FIXE)[1],
            'computerBreak' => $computerRepository->selectComputers(Computer::BREAK, Computer::FIXE)[1],
            //computer laptop stats
            'sumLComputer' => $computerRepository->selectComputersCount(Computer::LAPTOP)[1],
            'computerLInStock' => $computerRepository->selectComputers(Computer::STOCK, Computer::LAPTOP)[1],
            'computerLGiven' => $computerRepository->selectComputers(Computer::GIVEN, Computer::LAPTOP)[1],
            'computerLAsso' => $computerRepository->selectComputers(Computer::ASSO, Computer::LAPTOP)[1],
            'computerLBreak' => $computerRepository->selectComputers(Computer::BREAK, Computer::LAPTOP)[1],
            // GEM 3 MOIS
            'totalPriceGem' => $memberShipRepository->selectTotalMembershipPrice(MemberShip::MEMBERSHIP_GEM)[1],
            'avgPriceGem' => $memberShipRepository->selectAvgMembership(MemberShip::MEMBERSHIP_GEM)[1],
            'totalMemberGem' => $memberShipRepository->selectTotalMembers(MemberShip::MEMBERSHIP_GEM)[1],
             // RSA
            'totalPriceRSA' => $memberShipRepository->selectTotalMembershipPrice(MemberShip::MEMBERSHIP_RSA)[1],
            'avgPriceRSA' => $memberShipRepository->selectAvgMembership(MemberShip::MEMBERSHIP_RSA)[1],
            'totalMemberRSA' => $memberShipRepository->selectTotalMembers(MemberShip::MEMBERSHIP_RSA)[1],
             // SMIC
            'totalPriceSMIC' => $memberShipRepository->selectTotalMembershipPrice(MemberShip::MEMBERSHIP_SMIC)[1],
            'avgPriceSMIC' => $memberShipRepository->selectAvgMembership(MemberShip::MEMBERSHIP_SMIC)[1],
            'totalMemberSMIC' => $memberShipRepository->selectTotalMembers(MemberShip::MEMBERSHIP_SMIC)[1],
            // BENEVOLE
            'totalPriceBenevole' => $memberShipRepository->selectTotalMembershipPrice(MemberShip::MEMBERSHIP_BENEVOLE)[1],
            'avgPriceBenevole' => $memberShipRepository->selectAvgMembership(MemberShip::MEMBERSHIP_BENEVOLE)[1],
            'totalMemberBenevole' => $memberShipRepository->selectTotalMembers(MemberShip::MEMBERSHIP_BENEVOLE)[1],
            // LINUX
            'totalPriceLinux' =>  $memberShipRepository->selectTotalMembershipPrice(MemberShip::MEMBERSHIP_LINUX)[1],
            'avgPriceLinux' => $memberShipRepository->selectAvgMembership(MemberShip::MEMBERSHIP_LINUX)[1],
            'totalMemberLinux' => $memberShipRepository->selectTotalMembers(MemberShip::MEMBERSHIP_LINUX)[1],  
            // SUP SMIC
            'totalPriceSup' =>  $memberShipRepository->selectTotalMembershipPrice(MemberShip::MEMBERSHIP_SUP)[1],
            'avgPriceSup' => $memberShipRepository->selectAvgMembership(MemberShip::MEMBERSHIP_SUP)[1],
            'totalMemberSup' => $memberShipRepository->selectTotalMembers(MemberShip::MEMBERSHIP_SUP)[1], 
            // DON
            'totalPriceDon' => $memberShipRepository->selectTotalMembershipPrice(MemberShip::GIFT)[1],
            'avgPriceDon' => $memberShipRepository->selectAvgMembership(MemberShip::GIFT)[1],
            'totalMemberDon' => $memberShipRepository->selectTotalMembers(MemberShip::GIFT)[1],  
            // Vente
            'totalPriceSales' => $memberShipRepository->selectTotalMembershipPrice(MemberShip::SALES)[1],
            'avgPriceSales' => $memberShipRepository->selectAvgMembership(MemberShip::SALES)[1],
            'totalMemberSales' => $memberShipRepository->selectTotalMembers(MemberShip::SALES)[1],                       
        ]);
    }

}