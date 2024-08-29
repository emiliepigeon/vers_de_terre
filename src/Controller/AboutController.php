<?php

namespace App\Controller;

use App\Repository\AboutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    #[Route('/about', name: 'app_about')]
    public function index(AboutRepository $aboutRepository): Response
    {
        $about = $aboutRepository->findMostRecent();

        if (!$about) {
            throw $this->createNotFoundException('No About information found');
        }

        return $this->render('about/detail.html.twig', [
            'about' => $about,
        ]);
    }

    public function aboutPartial(AboutRepository $aboutRepository): Response
    {
        $about = $aboutRepository->findMostRecent();

        if (!$about) {
            return new Response(''); // Return empty response if no About info found
        }

        return $this->render('_partials/_about.html.twig', [
            'about' => $about,
        ]);
    }
}
