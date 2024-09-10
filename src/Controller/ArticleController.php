<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article/new', name: 'article_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $article->getImageFile();
            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move($this->getParameter('images_directory'), $newFilename);
                $article->setImageName($newFilename);
            }

            $article->setCreatedAt(new \DateTimeImmutable());
            $article->setUpdatedAt(new \DateTimeImmutable());
            $article->setMetaDescription('Description par défaut pour ' . $article->getTitle());
            $article->setMetaKeywords('Mots-clés par défaut pour ' . $article->getTitle());
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_list');
        }

        return $this->render('article/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/article/{slug}', name: 'app_article_show')]
    public function show(string $slug, ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findBySlug($slug);

        if (empty($articles)) {
            throw $this->createNotFoundException('Article non trouvé');
        }

        // Prendre le premier article si plusieurs sont trouvés
        $article = $articles[0];

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }
}
