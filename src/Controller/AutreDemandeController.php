<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\AutreDemandeForm;
use App\Form\DemandeFormType;
use App\Repository\CompetenceRepository;
use App\Repository\DemandeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/autre/demande')]
class AutreDemandeController extends AbstractController
{
    #[Route('/', name: 'app_autre_demande')]
    public function index(CompetenceRepository $competenceRepository, DemandeRepository $demandeRepository): Response
    {
        // Nous devons rechercher les demandes qui sont en accord avec mes compétences.
        //Récuperation de nos compétences
        $userId=$this->getUser()->getId();
        $competences = $competenceRepository->findAll();

        $lesCompetences=[];
        $lesDemandes=[];
        //dd($lesCompetences);
        foreach ($competences as $competence) {
            // Récupérer les assistants pour cette compétence
            $assistants = $competence->getLesAssistants();
            if (in_array($userId,$assistants,true)){
                array_push($lesCompetences, $competence->getSousMatiere());
                //dd($lesCompetences);
            }
        }

        //Recuperons les demandes où la matiere et la sous-matière correspondent à celles de nos compétences
         $demandes=$demandeRepository->findAll();

        foreach ($demandes as $demande) {

            if (in_array($demande->getSousMatiere(),$lesCompetences,true) &&  $this->getUser()->getClasse()->getCode()-$demande->getIdUser()->getClasse()->getCode()>1)
            {
                array_push($lesDemandes, $demande);
            }
        }
        $statutTab=[1=>'En attente de confirmation',2=>'Répondu par un tuteur',  3=>'Salle assignée',4=>'Terminée',5=>'Expirée',6=>'Refusée',7=>'Annulation par l\'étudiant' ,8=>'Modifier',9=>'Supprimée' ];

        return $this->render('autre_demande/index.html.twig', [
            'controller_name' => 'AutreDemandeController',
            'statusTab'=>$statutTab,
            'demandes'=>$lesDemandes,
        ]);
    }
    #[Route('reclamer-demande/{id}',name:"reclamer_demande")]

    public function reclamerDemande(Demande $demande, EntityManagerInterface $entityManager,MailerInterface $mailer): Response
    {
        $demande->setStatus('2');
        $demande->setAssistant($this->getUser());
        //dd($demande);
        $entityManager->persist($demande);
        $entityManager->flush();
        $emailAssistant = (new TemplatedEmail())
            ->from('HelpOrt@ort-france.fr')
            ->to(new Address($this->getUser()->getEmail()))
            ->subject('Réclamation du soutien HelpOrt')
            ->htmlTemplate('emails/reclamation.html.twig')
            // pass variables (name => value) to the template
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'username' => $this->getUser()->getUsername(),
                'demande'=>$demande
            ])
        ;
        $mailer->send($emailAssistant);

        $emailAssiste = (new TemplatedEmail())
            ->from('HelpOrt@ort-france.fr')
            ->to(new Address($demande->getIdUser()->getEmail()))
            ->subject('Un étudiant de l\'Ort va t\'aider à réussir' )

            // path of the Twig template to render
            ->htmlTemplate('emails/reponseAssistant.html.twig')

            ->context([
                'assistant'=>$this->getUser()->getNom()." ".$this->getUser()->getPrenom(),
                //'expiration_date' => new \DateTime('+7 days'),
                'username' => $demande->getIdUser()->getUsername(),
                'demande'=>$demande
            ])
        ;

        $mailer->send($emailAssiste);

        return $this->redirectToRoute('app_autre_demande');
    }

}
