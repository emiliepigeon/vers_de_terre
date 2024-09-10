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
        $about = $aboutRepository->findOneBy([], ['id' => 'DESC']);
        $words = $wordsRepository->findAll();

        $newsCategories = $categoryRepository->findBy(['title' => ['témoignage', 'éco-geste', 'les dangers']]);
        $trainingCategories = $categoryRepository->findBy(['title' => ['fait maison', 'fiche technique', 'e-learning']]);

        // Utiliser la méthode findLatestFromDifferentCategories
        $newsArticles = $articleRepository->findLatestFromDifferentCategories($newsCategories, 3);
        $trainingArticles = $articleRepository->findLatestFromDifferentCategories($trainingCategories, 3);

        return $this->render('home/index.html.twig', [
            'about' => $about,
            'words' => $words,
            'newsArticles' => $newsArticles,
            'trainingArticles' => $trainingArticles,
        ]);
    }
}
