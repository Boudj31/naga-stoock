<?php

namespace App\Controller;

use App\Repository\ComputerRepository;
use App\Repository\MemberShipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ComputerRepository $computerRepository): Response
    {
        return $this->render('default/index.html.twig', [
            'computers' => $computerRepository->findLast()
        ]);
    }

}
