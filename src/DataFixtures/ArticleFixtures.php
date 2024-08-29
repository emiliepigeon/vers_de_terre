<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            'témoignage' => new Category(),
            'éco-geste' => new Category(),
            'les dangers' => new Category(),
            'fait maison' => new Category(),
            'fiche technique' => new Category(),
            'e-learning' => new Category(),
        ];

        foreach ($categories as $title => $category) {
            $category->setTitle($title);
            $manager->persist($category);
        }

        $actualitesArticles = [
            ['title' => 'Parole de jardinnier', 'category' => 'témoignage', 'image' => 'assets/images/nikola-jovanovic-OBok3F8buKY-unsplash.jpg'],
            ['title' => 'Au quotidien chez soit', 'category' => 'éco-geste', 'image' => 'assets/images/istockphoto-1409913791-1024x1024.jpg'],
            ['title' => 'Agriculture intensive', 'category' => 'les dangers', 'image' => 'assets/images/red-zeppelin-Uplc8Wq8188-unsplash.jpg'],
            ['title' => 'Parole de jardinnier', 'category' => 'témoignage', 'image' => 'assets/images/nikola-jovanovic-OBok3F8buKY-unsplash.jpg'],
            ['title' => 'Au quotidien chez soit', 'category' => 'éco-geste', 'image' => 'assets/images/istockphoto-1409913791-1024x1024.jpg'],
            ['title' => 'Agriculture intensive', 'category' => 'les dangers', 'image' => 'assets/images/red-zeppelin-Uplc8Wq8188-unsplash.jpg'],
            ['title' => 'Parole de jardinnier', 'category' => 'témoignage', 'image' => 'assets/images/nikola-jovanovic-OBok3F8buKY-unsplash.jpg'],
            ['title' => 'Au quotidien chez soit', 'category' => 'éco-geste', 'image' => 'assets/images/istockphoto-1409913791-1024x1024.jpg'],
            ['title' => 'Agriculture intensive', 'category' => 'les dangers', 'image' => 'assets/images/red-zeppelin-Uplc8Wq8188-unsplash.jpg'],
        ];

        $trainingsArticles = [
            ['title' => 'Fabriquez votre lombricomposteur', 'category' => 'fait maison', 'image' => 'assets/images/istockphoto-479440915-1024x1024.jpg'],
            ['title' => 'Augmenter la population de vers-de-terre', 'category' => 'fiche technique', 'image' => 'assets/images/jonathan-kemper-YD5TvbPgmQc-unsplash.jpg'],
            ['title' => 'Apprendre à connaître son sol', 'category' => 'e-learning', 'image' => 'assets/images/sippakorn-yamkasikorn-6v9w4ZR2TJE-unsplash.jpg'],
            ['title' => 'Fabriquez votre lombricomposteur', 'category' => 'fait maison', 'image' => 'istockphoto-479440915-1024x1024.jpg'],
            ['title' => 'Augmenter la population de vers-de-terre', 'category' => 'fiche technique', 'image' => 'assets/images/jonathan-kemper-YD5TvbPgmQc-unsplash.jpg'],
            ['title' => 'Apprendre à connaître son sol', 'category' => 'e-learning', 'image' => 'assets/images/sippakorn-yamkasikorn-6v9w4ZR2TJE-unsplash.jpg'],
            ['title' => 'Fabriquez votre lombricomposteur', 'category' => 'fait maison', 'image' => 'assets/images/istockphoto-479440915-1024x1024.jpg'],
            ['title' => 'Augmenter la population de vers-de-terre', 'category' => 'fiche technique', 'image' => 'assets/images/jonathan-kemper-YD5TvbPgmQc-unsplash.jpg'],
            ['title' => 'Apprendre à connaître son sol', 'category' => 'e-learning', 'image' => 'assets/images/sippakorn-yamkasikorn-6v9w4ZR2TJE-unsplash.jpg'],
        ];

        $this->createArticles($manager, $actualitesArticles, $categories);
        $this->createArticles($manager, $trainingsArticles, $categories);

        $manager->flush();
    }

    private function createArticles(ObjectManager $manager, array $articlesData, array $categories): void
    {
        foreach ($articlesData as $articleData) {
            $article = new Article();
            $article->setTitle($articleData['title']);
            $article->setTexte('Ceci est le contenu de l\'article ' . $articleData['title'] . '. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor.');
            $article->setSlug($this->slugify($articleData['title']));
            $article->setCategory($categories[$articleData['category']]);
            $article->setImageFeatured($articleData['image']);
            $article->setCreatedAt(new \DateTime());
            $article->setUpdatedAt(new \DateTime());
            $article->setIsPublished(true);
            $article->setAuthor('Auteur par défaut');
            $article->setMetaDescription('Description meta pour ' . $articleData['title']);
            $article->setMetaKeywords('mots-clés, pour, ' . $articleData['title']);

            $manager->persist($article);
        }
    }

    private function slugify(string $text): string
    {
        // Remplace les caractères non alphanumériques par un tiret
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // Translitère
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // Supprime les caractères indésirables
        $text = preg_replace('~[^-\w]+~', '', $text);

        // Trim les tirets
        $text = trim($text, '-');

        // Supprime les tirets dupliqués
        $text = preg_replace('~-+~', '-', $text);

        // Convertit en minuscules
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
