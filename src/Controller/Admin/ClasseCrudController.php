<?php

namespace App\Controller\Admin;

use App\Entity\Classe;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use SebastianBergmann\CodeCoverage\Report\Text;

class ClasseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Classe::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
            // AssociationField::new('matieres'),
            ChoiceField::new('code')
                ->setLabel('Niveau d\'année')
                ->setChoices([
                    'Seconde du Lycée' => 1,
                    'Première du Lycée' => 2,
                    'Terminale' => 3,
                    'Première année' => 4,
                    'Deuxième année' => 5,
                    'Troisème année' => 6,
                    'Quatrième année' => 7,
                    'Cinquième année' => 8,

                ]),
        ];
    }

}
