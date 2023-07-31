<?php

namespace App\Controller;

use App\Entity\TypeContrat;
use App\Form\TypeContratType;
use App\Repository\TypeContratRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/type/contrat')]
class TypeContratController extends AbstractController
{
    #[Route('/', name: 'app_typecontrat_index', methods: ['GET'])]
    public function index(TypeContratRepository $typeContratRepository): Response
    {
        return $this->render('Admin/Typecontrat.html.twig', [
            'typecontrats' => $typeContratRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_typecontrat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeContratRepository $typeContratRepository): Response
    {
        $typeContrat = new TypeContrat();
        $form = $this->createForm(TypeContratType::class, $typeContrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeContratRepository->save($typeContrat, true);

            return $this->redirectToRoute('app_typecontrat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_contrat/new.html.twig', [
            'typecontrat' => $typeContrat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_typecontrat_show', methods: ['GET'])]
    public function show(TypeContrat $typeContrat): Response
    {
        return $this->render('type_contrat/show.html.twig', [
            'typecontrat' => $typeContrat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_typecontrat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeContrat $typeContrat, TypeContratRepository $typeContratRepository): Response
    {
        $form = $this->createForm(TypeContratType::class, $typeContrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeContratRepository->save($typeContrat, true);

            return $this->redirectToRoute('app_typecontrat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_contrat/edit.html.twig', [
            'typecontrat' => $typeContrat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_typecontrat_delete', methods: ['POST'])]
    public function delete(Request $request, TypeContrat $typeContrat, TypeContratRepository $typeContratRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeContrat->getId(), $request->request->get('_token'))) {
            $typeContratRepository->remove($typeContrat, true);
        }

        return $this->redirectToRoute('app_typecontrat_index', [], Response::HTTP_SEE_OTHER);
    }
}
