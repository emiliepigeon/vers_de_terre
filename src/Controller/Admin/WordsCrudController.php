<?php

namespace App\Controller\Admin;

use App\Entity\Words;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class WordsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Words::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), // Ne pas afficher l'ID dans le formulaire
            TextField::new('content', 'Contenu'), // Champ pour le contenu
        ];
    }
}
