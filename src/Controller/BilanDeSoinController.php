<?php

namespace App\Controller;

use App\Entity\BilanDeSoin;
use App\Form\BilanDeSoinType;
use App\Repository\BilanDeSoinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bilan/de/soin')]
class BilanDeSoinController extends AbstractController
{
    #[Route('/Bilans', name: 'app_bilan_de_soin_index', methods: ['GET'])]
    public function findall(BilanDeSoinRepository $repository): Response
    {
        $bilans = $repository->findAll();
        return $this->render('admin/Bilans.html.twig', [
            'bilans' => $bilans,
        ]);
    }


    // #[Route('/listBilans', name: 'listbilans', methods: ['GET'])]
    // public function list(BilanDeSoinRepository $repository)
    // {
    //     $bilans= $repository->findAll();
    //     return $this->renderForm("bilan_de_soin/Bilans.html.twig",array("tabbilans"=>$bilans));
        
    // }

    #[Route('/newBilanClient', name: 'app_bilan_de_soin_new', methods: ['GET', 'POST'])]
    public function newBC(Request $request, BilanDeSoinRepository $bilanDeSoinRepository): Response
    {
        $bilanDeSoin = new BilanDeSoin();
        $form = $this->createForm(BilanDeSoinType::class, $bilanDeSoin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bilanDeSoinRepository->save($bilanDeSoin, true);

            return $this->redirectToRoute('app_bilan_de_soin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Client/NewBilan.html.twig', [
            'bilan_de_soin' => $bilanDeSoin,
            'form' => $form,
        ]);
    }


    #[Route('/newBilanAdmin', name: 'app_bilan_de_soin_new2', methods: ['GET', 'POST'])]
    public function newBA(Request $request, BilanDeSoinRepository $bilanDeSoinRepository): Response
    {
        $bilanDeSoin = new BilanDeSoin();
        $form = $this->createForm(BilanDeSoinType::class, $bilanDeSoin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bilanDeSoinRepository->save($bilanDeSoin, true);

            return $this->redirectToRoute('app_bilan_de_soin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bilan_de_soin/new.html.twig', [
            'bilan_de_soin' => $bilanDeSoin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/showReclamation', name: 'app_bilan_de_soin_showA', methods: ['GET'])]
    public function showA(BilanDeSoin $bilanDeSoin): Response
    {
        return $this->render('bilan_de_soin/show.html.twig', [
            'bilan_de_soin' => $bilanDeSoin,
        ]);
    }

    

    #[Route('/{id}/show', name: 'app_bilan_de_soin_show', methods: ['GET'])]
    public function show(BilanDeSoin $bilanDeSoin): Response
    {
        return $this->render('Client/BilanDeSoin.html.twig', [
            'bilan_de_soin' => $bilanDeSoin,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bilan_de_soin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BilanDeSoin $bilanDeSoin, BilanDeSoinRepository $bilanDeSoinRepository): Response
    {
        $form = $this->createForm(BilanDeSoinType::class, $bilanDeSoin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bilanDeSoinRepository->save($bilanDeSoin, true);

            return $this->redirectToRoute('app_bilan_de_soin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bilan_de_soin/edit.html.twig', [
            'bilan_de_soin' => $bilanDeSoin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_bilan_de_soin_delete', methods: ['POST'])]
    public function delete(Request $request, BilanDeSoin $bilanDeSoin, BilanDeSoinRepository $bilanDeSoinRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bilanDeSoin->getId(), $request->request->get('_token'))) {
            $bilanDeSoinRepository->remove($bilanDeSoin, true);
        }

        return $this->redirectToRoute('app_bilan_de_soin_index', [], Response::HTTP_SEE_OTHER);
    }



    
}
