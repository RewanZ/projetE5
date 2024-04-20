<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom')->setColumns(6),
            TextField::new('prenom')->setLabel('Prénom'),
            AssociationField::new('classe')->setColumns(6),
            TextField::new('email'),
            TextField::new('niveau')->setColumns(6),
            IntegerField::new('sexe'),
            TextField::new('telephone')->setColumns(6),
            TextField::new('username')->setLabel('Nom d\'utilisateur'),
            ArrayField::new('roles')->setLabel('Rôles'),




            //TextEditorField::new('description'),
        ];
    }

}
