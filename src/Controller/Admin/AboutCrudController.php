<?php

namespace App\Controller\Admin;

use App\Entity\About;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Doctrine\ORM\EntityManagerInterface;

class AboutCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return About::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('À propos')
            ->setEntityLabelInPlural('À propos')
            ->setSearchFields(['title', 'content', 'title1', 'content1', 'title2', 'content2', 'title3', 'content3'])
            ->setDefaultSort(['id' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre'),
            SlugField::new('slug')->setTargetFieldName('title')->hideOnIndex(),
            TextEditorField::new('content', 'Contenu Principal'),
            TextField::new('title1', 'Titre 1'),
            TextEditorField::new('content1', 'Contenu 1'),
            TextField::new('title2', 'Titre 2'),
            TextEditorField::new('content2', 'Contenu 2'),
            TextField::new('title3', 'Titre 3'),
            TextEditorField::new('content3', 'Contenu 3'),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $about = new About();
        $about->setTitle('Nouveau titre');
        $about->setContent('Nouveau contenu');
        return $about;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof About) {
            return;
        }

        if (empty($entityInstance->getTitle())) {
            $entityInstance->setTitle('Titre par défaut');
        }
        if (empty($entityInstance->getContent())) {
            $entityInstance->setContent('Contenu par défaut');
        }

        $entityManager->flush();
    }
}
