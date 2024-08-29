<?php

namespace App\Controller\Admin;

use App\Entity\About;
use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Vers De Terre');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Accueil WWF', 'fa fa-home', 'app_home');

        yield MenuItem::subMenu('À Propos', 'fas fa-info-circle')
            ->setSubItems([
                MenuItem::linkToCrud('Liste du contenu à propos', 'fas fa-list', About::class),
                MenuItem::linkToCrud('Ajouter un article à propos', 'fas fa-plus', About::class)
                    ->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Modifier un article à propos', 'fas fa-edit', About::class)
                    ->setAction(Crud::PAGE_EDIT),
            ]);

        yield MenuItem::subMenu('Articles', 'fas fa-newspaper')
            ->setSubItems([
                MenuItem::linkToCrud('Liste des articles', 'fas fa-list', Article::class),
                MenuItem::linkToCrud('Ajouter un article', 'fas fa-plus', Article::class)
                    ->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Modifier un article', 'fas fa-edit', Article::class)
                    ->setAction(Crud::PAGE_EDIT),
            ]);

        yield MenuItem::subMenu('Catégories', 'fas fa-tags')
            ->setSubItems([
                MenuItem::linkToCrud('Liste des catégories', 'fas fa-list', Category::class),
                MenuItem::linkToCrud('Ajouter une catégorie', 'fas fa-plus', Category::class)
                    ->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Modifier une catégorie', 'fas fa-edit', Category::class)
                    ->setAction(Crud::PAGE_EDIT),
            ]);
    }
}
