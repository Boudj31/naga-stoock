<?php

namespace App\Controller;

use App\Entity\Cash;
use App\Entity\Cheque;
use App\Entity\Tranfert;
use App\Entity\MemberShip;
use App\Form\MemberShipType;
use App\Repository\ChequeRepository;
use App\Form\SearchMemberShipType;
use App\Repository\CashRepository;
use App\Repository\MemberShipRepository;
use App\Repository\TranfertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Dompdf\Dompdf;
use Dompdf\Options;


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
            10 /*limit par page*/
        );
        return $this->render('member_ship/index.html.twig', [
            'member_ships' => $memberShips,
        ]);
    }

    /**
     * @Route("/search", name="search_member_ship", methods={"GET"})
     */
    public function search(Request $request, MemberShipRepository $memberShipRepository): Response
    {
        $results = null;
        if ('GET' === $request->getMethod()) {
            $results = $memberShipRepository->findMemberSearch(
                $request->query->get('search_member_ship')['mot']
            );
        }

        return $this->render('/member_ship/search.html.twig', [
            'search_member_ship' => $results ? $results : $memberShipRepository->findAll(),
        ]);
    }

    public function getSearchMemberForm()
    {
        $form = $this->createForm(SearchMemberShipType::class, null, [
            'method' => 'get',
            'action' => $this->generateUrl('search_member_ship'),
        ]);

        return $this->render('form/_search_form.html.twig', [
            'search_form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/new", name="member_ship_new", methods={"GET","POST"})
     */
    public function new(Request $request, ChequeRepository $chequeRepository, CashRepository $cashRepository, TranfertRepository $tranfertRepository): Response
    {
        $memberShip = new MemberShip();
        $form = $this->createForm(MemberShipType::class, $memberShip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // Compta Remboursement
            if ($memberShip->getMode() === MemberShip::TRANSFERT) {   
                $total = $cashRepository->selectLastTotal();
                $transfert = new Cash();
                $transfert->setFirstname($memberShip->getMember()->getFirstname());
                $transfert->setLastname($memberShip->getMember()->getLastname());
                $transfert->setDate(new \DateTime);
                $transfert->setAmountIn(0);
                $transfert->setAmountOut($memberShip->getAmount());
                $transfert->setTotal($total['total'] - $transfert->getAmountOut());
                $transfert->setType($memberShip->getType());
                $entityManager->persist($transfert);
                
            }
            // Compta Cash
            if($memberShip->getMode() === MemberShip::CASH) {
                $total = $cashRepository->selectLastTotal();
                $cash = new Cash();
                $cash->setFirstname($memberShip->getMember()->getFirstname());
                $cash->setLastname($memberShip->getMember()->getLastname());
                $cash->setDate(new \DateTime);
                $cash->setAmountIn($memberShip->getAmount());
                $cash->setAmountOut(0);
                $cash->setTotal($total['total'] + $cash->getAmountIn());
                $cash->setType($memberShip->getType());
                $entityManager->persist($cash);
            }
            // Compta Cheque
            if ($memberShip->getMode() === MemberShip::CHEQUE) {
                    
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

            $this->addFlash('success', 'L\'action sur l\'adhésion a été correctement réalisée');

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
    public function delete(Request $request, 
                           MemberShip $memberShip, 
                           CashRepository $cashRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$memberShip->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($memberShip);
            $entityManager->flush();
        }

        return $this->redirectToRoute('member_ship_index');
    }

    /**
     * @Route("/facture/{id}", name="member_ship_facture", methods={"GET"})
     */
    public function facture(MemberShip $memberShip): Response
    {
        // On définit les options du PDF
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        // On instancie Dompdf
        $dompdf = new Dompdf($pdfOptions);
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $dompdf->setHttpContext($context);

        // On génère le html
        $html = $this->renderView('member_ship/facture.html.twig', [
            'member_ship' => $memberShip,
        ]);
        
        $html .= '<link type="text/css" href="https://bootswatch.com/4/materia/bootstrap.min.css" rel="stylesheet" />';
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // On génère un nom de fichier
        $fichier = 'Facture-'. $memberShip->getId().'.pdf';

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => false
        ]);

        return new Response();
    }

}
