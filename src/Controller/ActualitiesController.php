<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActualitiesController extends AbstractController
{
    #[Route('/actualites', name: 'app_actualities')]
    public function index(ArticleRepository $articleRepository, CategoryRepository $categoryRepository): Response
    {
        // Récupérer les catégories d'actualités spécifiques
        $actualitiesCategories = $categoryRepository->findBy(['title' => ['témoignage', 'éco-geste', 'les dangers']]);
        
        // Récupérer les articles associés à ces catégories
        $articles = $articleRepository->findBy(['category' => $actualitiesCategories]);

        return $this->render('actualities/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
