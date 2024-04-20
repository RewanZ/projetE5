<?php

namespace App\Controller\Admin;

use App\Entity\Demande;
use App\Repository\CompetenceRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\RequestStack;


class DemandeCrudController extends AbstractCrudController
{

   public function __construct(private CompetenceRepository $competenceRepository, private UserRepository $userRepository,RequestStack $requestStack)
   {
       $this->requestStack = $requestStack;

       $competenceRepository=$this->competenceRepository;
   }

    public static function getEntityFqcn(): string
    {
        return Demande::class;
    }
    public function configureFields(string $pageName): iterable
    {
        $request = $this->requestStack->getCurrentRequest();
        $sousMatiereChoisie = $request->query->get('sous_matiere');
        $lesCompetenceParSousMatiere=$this->competenceRepository->findBy(['sous_matiere'=>'Verbes Irréguliers']);
        //dd($sousMatiereChoisie);
        $lesAssistants=[];
        $lesNomsDesAssistants=[];
        foreach ($lesCompetenceParSousMatiere as $competence ){
            //dd($competence);
            foreach ($competence->getLesAssistants() as $assistant){
                $idAssistant=$this->userRepository->findBy(['id'=>$assistant]);
                //dd($idAssistant[0]->getId());
                array_push($lesAssistants,$idAssistant[0]->getId());
            }

    }



        return [
            IdField::new('id')->setDisabled(),
            DateField::new('dateUpdated')->setFormat('dd-MM-YYYY')->hideOnForm(),
            IdField::new('id_matiere')->setDisabled()->setColumns(3)->setLabel('Matière'),
            TextField::new('sous_matiere')->setDisabled()->setColumns(3)->setLabel('Sous-Matière'),
            IdField::new('id_user')->setDisabled()->setColumns(3)->setLabel('Nom du demandeur'),
            ChoiceField::new('status')
                ->setLabel('Statut')
                ->setChoices([
                    'En attente' => 1,
                    'Répondu par un tuteur' => 2,
                    'Assignée une salle' => 3,
                    'Terminée' => 4,
                    'Expirée' => 5,
                    'Refusée' => 6,
                    'Annulation par l’étudiant' => 7,
                    'Modifier' => 8,
                    'Supprimer' => 9,

                ]),

            DateField::new('dateFinDemande')->setFormat('dd-MM-YYYY')->setColumns(2),
            //ChoiceField::new('assistant')
               // ->setLabel('Assistant')
            //->setChoices($lesAssistants)

        ];


    }

}
