<?php

namespace App\Controller;


use App\Entity\Competence;
use App\Entity\Demande;
use App\Form\DemandeFormType;
use App\Repository\CompetenceRepository;
use App\Repository\DemandeRepository;
use App\Repository\MatiereRepository;
use App\Repository\SousMatiereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/home')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET', 'POST'])]
    //#[IsGranted('ROLE_USER')]
    public function index(Request $request, EntityManagerInterface $em, MailerInterface $mailer): Response
    {

        $user = $this->getUser();
        $userId=$user->getId();
        $classe = $user->getClasse();
        $demande=new Demande();

        $form=$this->createForm(DemandeFormType::class, $demande);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $demande->setIdUser($user);
            $demande->setIdMatiere($form->getData()->getIdMatiere());
            $demande->setStatus(1);
            $demande->setSousMatiere($form->getData()->getSousMatiere());
            $demande->setDateUpdated(new \DateTime('now'));
            $em->persist($demande);
            //dd($demande);
            $em->flush();
            //dd($form->getData()->getSousMatiere());
            $email=(new TemplatedEmail())
                //TODO changer le mail en bas
                ->from('HelpORT@ortmontreuil.fr')
                ->to($user->getEmail())
                ->subject('Demande de soutien de cours')
                // path of the Twig template to render
                ->htmlTemplate('emails/demande.html.twig')

                // pass variables (name => value) to the template
                ->context([
                    'username' => $user->getUsername(),
                    'demande'=>$demande,
                    'date_de_demande'=>$form->getData()->getDateUpdated()->format('d-m-Y'),
                    'date_de_fin_de_demande'=>$form->getData()->getDateFinDemande()->format('d-m-Y'),
                    'matiere'=>$form->getData()->getIdMatiere()->getDesignation(),
                    'sous_matiere'=>$form->getData()->getSousMatiere(),
                ])
            ;
            $mailer->send($email);
            $this->addFlash('info',"Votre demande à été envoyé avec succès"."\n"."Vous recevrez un mail de confirmation avec l'assistant choisi d'ici peu.");
            return $this->redirectToRoute('app_home');
        }


        //return $this->renderForm('home/index.html.twig', ['user'=>$user->getPrenom(),compact('form')]);
        return $this->render('home/index.html.twig', [
            'user'=>$user->getPrenom(),
            'form'=>$form,
        ]);
    }
    #[Route('/redirect', name: 'app_redirect', methods: ['GET', 'POST'])]
    public function __redirection(MatiereRepository $matiereRepository, Request $request, EntityManagerInterface $em, MailerInterface $mailer, CompetenceRepository $competenceRepository): Response
    {
        $user = $this->getUser();
        if ($user->getRoles()[0]=="ROLE_ADMIN"){
            return $this->redirectToRoute('admin_home');
        }
        elseif ($user->getRoles()[0]=="ROLE_USER")
        {
            return $this->redirectToRoute('app_home');
        }
        else{
            return $this->redirectToRoute('app_login');
        }
    }

    // #[Route('/home/demande', name: 'app_home_demande', methods: ['GET', 'POST'])]
    #[Route('/demande', name: 'app_home_demande', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function show(DemandeRepository $demandeRepository): Response
    {
        $statutTab=[1=>'En attente de confirmation',2=>'Répondu par un tuteur',  3=>'Salle assignée',4=>'Terminée',5=>'Expirée',6=>'Refusée',7=>'Annulation par l\'étudiant' ,8=>'Modifier',9=>'Supprimée' ];

        return $this->render('home/demandes.html.twig', [
            'demandes' => $demandeRepository->findBy(['id_user'=>$this->getUser()]),
            'statutTab'=>$statutTab,
            'user'=>$this->getUser(),
        ]);
    }



}
