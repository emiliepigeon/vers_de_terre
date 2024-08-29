<?php

namespace App\Controller;

use App\Repository\AboutRepository;
use App\Repository\WordsRepository;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        AboutRepository $aboutRepository,
        WordsRepository $wordsRepository,
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository
    ): Response {
        $about = $aboutRepository->findMostRecent();
        $words = $wordsRepository->findAllWords(); // Utilisez la méthode personnalisée

        $newsCategories = $categoryRepository->findBy(['title' => ['témoignage', 'éco-geste', 'les dangers']]);
        $trainingCategories = $categoryRepository->findBy(['title' => ['fait maison', 'fiche technique', 'e-learning']]);

        $newsArticles = $articleRepository->findByCategories($newsCategories, 3);
        $trainingArticles = $articleRepository->findByCategories($trainingCategories, 3);

        $trainingImages = [
            'assets/images/training1.jpg',
            'assets/images/training2.jpg',
            'assets/images/training3.jpg',
        ];

        return $this->render('home/index.html.twig', [
            'about' => $about,
            'words' => $words,
            'newsArticles' => $newsArticles,
            'trainingArticles' => $trainingArticles,
            'trainingImages' => $trainingImages,
        ]);
    }
}
