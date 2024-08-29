<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrainingsController extends AbstractController
{
    #[Route('/formations', name: 'app_trainings')]
    public function index(ArticleRepository $articleRepository, CategoryRepository $categoryRepository): Response
    {
        $trainingCategories = $categoryRepository->findBy(['title' => ['fait maison', 'fiche technique', 'e-learning']]);
        $articles = $articleRepository->findAllByCategories($trainingCategories);

        return $this->render('trainings/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
