<?php

namespace App\Controller;

use App\Entity\Computer;
use App\Repository\ComputerRepository;
use App\Repository\MemberShipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ComputerRepository $computerRepository, MemberShipRepository $memberShipRepository): Response
    {

        return $this->render('default/index.html.twig', [
            'computers' => $computerRepository->findLast(),
            'sumAmount' => $memberShipRepository->selectAmountSum()[1],
            'computer' => $computerRepository->selectComputersCount(Computer::FIXE)[1],
            'member' => $memberShipRepository->selectMemberCount()[1]
        ]);
    }


}
