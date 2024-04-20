<?php

namespace App\Controller\Admin;

use App\Entity\Salle;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Routing\Annotation\Route;

class SalleCrudController extends AbstractCrudController

{

    public static function getEntityFqcn(): string
    {
        return Salle::class;
    }
    /*
     public function configureFields(string $pageName): iterable
     {
         return [
             IdField::new('id'),
             TextField::new('title'),
             TextEditorField::new('description'),
         ];
     }
     */

}
