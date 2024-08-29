<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField; // Importation de BooleanField
use Doctrine\ORM\EntityManagerInterface;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), // Ne pas afficher l'ID dans le formulaire
            TextField::new('title', 'Titre'), // Champ pour le titre
            SlugField::new('slug') // Champ pour le slug
                ->setTargetFieldName('title') // Générer le slug à partir du titre
                ->onlyOnForms(), // Afficher uniquement dans le formulaire
            TextEditorField::new('texte', 'Contenu'), // Champ pour le contenu
            ImageField::new('imageFeatured', 'Image Principale') // Champ pour l'image
                ->setBasePath('assets/images') // Chemin de base pour les images
                ->setUploadDir('public/assets/images') // Répertoire où les images sont stockées
                ->setRequired(false), // Si l'image est optionnelle
            AssociationField::new('category', 'Catégorie'), // Champ pour la catégorie
            TextField::new('author', 'Auteur'), // Champ pour l'auteur
            TextField::new('metaDescription', 'Description Meta'), // Champ pour la description meta
            TextField::new('metaKeywords', 'Mots-clés Meta'), // Champ pour les mots-clés meta
            BooleanField::new('isPublished', 'Publié'), // Champ pour l'état de publication
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Article) {
            // Initialiser la date de création et de mise à jour
            $entityInstance->setCreatedAt(new \DateTime());
            $entityInstance->setUpdatedAt(new \DateTime());
            // Assurez-vous que isPublished a une valeur par défaut
            if ($entityInstance->getIsPublished() === null) {
                $entityInstance->setIsPublished(true); // Valeur par défaut
            }
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Article) {
            // Mettre à jour la date de mise à jour
            $entityInstance->setUpdatedAt(new \DateTime());
        }

        parent::updateEntity($entityManager, $entityInstance);
    }
}

