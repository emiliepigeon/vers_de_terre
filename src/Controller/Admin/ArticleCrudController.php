<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre'),
            SlugField::new('slug')->setTargetFieldName('title'),
            TextEditorField::new('texte', 'Contenu'),
            TextField::new('imageFile')
                ->setLabel('Image à uploader')
                ->setFormType(FileType::class)
                ->onlyOnForms(),
            ImageField::new('imageName', 'Image')
                ->setBasePath('uploads/images/articles')
                ->setUploadDir('public/uploads/images/articles')
                ->onlyOnIndex(),
            AssociationField::new('category', 'Catégorie'),
            TextField::new('author', 'Auteur'),
            TextField::new('metaDescription', 'Description Meta'),
            TextField::new('metaKeywords', 'Mots-clés Meta'),
            BooleanField::new('isPublished', 'Publié'),
            DateTimeField::new('createdAt', 'Créé le')->hideOnForm(),
            DateTimeField::new('updatedAt', 'Mis à jour le')->hideOnForm(),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $article = new Article();
        $article->setCreatedAt(new \DateTimeImmutable());
        $article->setUpdatedAt(new \DateTimeImmutable());
        $article->setIsPublished(false);
        $article->setMetaDescription('Description par défaut');
        $article->setMetaKeywords('Mots-clés par défaut');
        return $article;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Article) return;

        $entityInstance->setUpdatedAt(new \DateTimeImmutable());

        if ($entityInstance->getImageFile()) {
            $newFilename = uniqid() . '.' . $entityInstance->getImageFile()->guessExtension();
            $entityInstance->getImageFile()->move($this->getParameter('images_directory'), $newFilename);
            $entityInstance->setImageName($newFilename);
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Article) return;

        if ($entityInstance->getImageFile()) {
            $newFilename = uniqid() . '.' . $entityInstance->getImageFile()->guessExtension();
            $entityInstance->getImageFile()->move($this->getParameter('images_directory'), $newFilename);
            $entityInstance->setImageName($newFilename);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }
}
