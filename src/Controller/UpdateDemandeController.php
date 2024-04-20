<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\AutreDemande;
use App\Form\DemandeFormType;
use App\Repository\DemandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/update/demande')]
class UpdateDemandeController extends AbstractController
{
    #[Route('/', name: 'app_update_demande_index', methods: ['GET'])]
    public function index(DemandeRepository $demandeRepository): Response
    {
        $statutTab=[1=>'En attente de confirmation',2=>'Répondu par un tuteur',  3=>'Salle assignée',4=>'Terminée',5=>'Expirée',6=>'Refusée',7=>'Annulation par l\'étudiant' ,8=>'Modifier',9=>'Supprimée' ];
        return $this->render('update_demande/index.html.twig', [
            'demandes' => $demandeRepository->findBy(['id_user'=>$this->getUser()]),
            'statutTab'=>$statutTab
        ]);
    }

    #[Route('/new', name: 'app_update_demande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $statutTab=[1=>'En attente de confirmation',2=>'Répondu par un tuteur',  3=>'Salle assignée',4=>'Terminée',5=>'Expirée',6=>'Refusée',7=>'Annulation par l\'étudiant' ,8=>'Modifier',9=>'Supprimée' ];
        return $this->redirectToRoute('app_home',[
        'statutTab'=>$statutTab]);
    }

    #[Route('/{id}', name: 'app_update_demande_show', methods: ['GET'])]
    public function show(Demande $demande): Response
    {
        $statutTab=[1=>'En attente de confirmation',2=>'Répondu par un tuteur',  3=>'Salle assignée',4=>'Terminée',5=>'Expirée',6=>'Refusée',7=>'Annulation par l\'étudiant' ,8=>'Modifier',9=>'Supprimée' ];

        return $this->render('update_demande/show.html.twig', [
            'demande' => $demande,
            'statutTab'=>$statutTab
        ]);
    }

    #[Route('/{id}/edit', name: 'app_update_demande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Demande $demande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DemandeFormType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_update_demande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('update_demande/edit.html.twig', [
            'demande' => $demande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_update_demande_delete', methods: ['POST'])]
    public function delete(Request $request, Demande $demande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($demande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_update_demande_index', [], Response::HTTP_SEE_OTHER);
    }
}
