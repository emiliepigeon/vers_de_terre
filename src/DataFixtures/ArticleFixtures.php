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
        // Création des catégories
        $categories = [
            'témoignage' => new Category(),
            'éco-geste' => new Category(),
            'les dangers' => new Category(),
            'fait maison' => new Category(),
            'fiche technique' => new Category(),
            'e-learning' => new Category(),
        ];

        // Persist des catégories
        foreach ($categories as $title => $category) {
            $category->setTitle($title);
            $category->setSlug($this->slugify($title)); // Assurez-vous de slugifier le titre
            $manager->persist($category);
        }

        // Données des articles d'actualités
        $actualitesArticles = [
            ['title' => 'Parole de jardinnier', 'category' => 'témoignage', 'image' => 'nikola-jovanovic-OBok3F8buKY-unsplash.jpg'],
            ['title' => 'Au quotidien chez soi', 'category' => 'éco-geste', 'image' => 'istockphoto-1409913791-1024x1024.jpg'],
            ['title' => 'Agriculture intensive', 'category' => 'les dangers', 'image' => 'red-zeppelin-Uplc8Wq8188-unsplash.jpg'],
            ['title' => 'Jardinage en permaculture', 'category' => 'témoignage', 'image' => 'nikola-jovanovic-OBok3F8buKY-unsplash.jpg'],
            ['title' => 'Économie d\'eau', 'category' => 'éco-geste', 'image' => 'istockphoto-1409913791-1024x1024.jpg'],
            ['title' => 'Pesticides et santé', 'category' => 'les dangers', 'image' => 'red-zeppelin-Uplc8Wq8188-unsplash.jpg'],
            ['title' => 'Techniques de compostage', 'category' => 'témoignage', 'image' => 'nikola-jovanovic-OBok3F8buKY-unsplash.jpg'],
            ['title' => 'Réduction des déchets', 'category' => 'éco-geste', 'image' => 'istockphoto-1409913791-1024x1024.jpg'],
            ['title' => 'Impact de l\'agriculture', 'category' => 'les dangers', 'image' => 'red-zeppelin-Uplc8Wq8188-unsplash.jpg'],
        ];

        // Données des articles de formation
        $trainingsArticles = [
            ['title' => 'Fabriquez votre lombricomposteur', 'category' => 'fait maison', 'image' => 'istockphoto-479440915-1024x1024.jpg'],
            ['title' => 'Augmenter la population de vers-de-terre', 'category' => 'fiche technique', 'image' => 'jonathan-kemper-YD5TvbPgmQc-unsplash.jpg'],
            ['title' => 'Apprendre à connaître son sol', 'category' => 'e-learning', 'image' => 'sippakorn-yamkasikorn-6v9w4ZR2TJE-unsplash.jpg'],
            ['title' => 'Techniques de jardinage', 'category' => 'fait maison', 'image' => 'istockphoto-479440915-1024x1024.jpg'],
            ['title' => 'Créer un jardin vertical', 'category' => 'fiche technique', 'image' => 'jonathan-kemper-YD5TvbPgmQc-unsplash.jpg'],
            ['title' => 'Utilisation des engrais naturels', 'category' => 'e-learning', 'image' => 'sippakorn-yamkasikorn-6v9w4ZR2TJE-unsplash.jpg'],
            ['title' => 'Compostage efficace', 'category' => 'fait maison', 'image' => 'istockphoto-479440915-1024x1024.jpg'],
            ['title' => 'Préparer son sol', 'category' => 'fiche technique', 'image' => 'jonathan-kemper-YD5TvbPgmQc-unsplash.jpg'],
            ['title' => 'Cultiver des légumes bio', 'category' => 'e-learning', 'image' => 'sippakorn-yamkasikorn-6v9w4ZR2TJE-unsplash.jpg'],
        ];

        // Création des articles
        $this->createArticles($manager, $actualitesArticles, $categories);
        $this->createArticles($manager, $trainingsArticles, $categories);

        // Enregistrement des changements
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
            $article->setImageName($articleData['image']); // Enregistrer le nom de l'image dans le champ imageName
            $article->setCreatedAt(new \DateTimeImmutable());
            $article->setUpdatedAt(new \DateTimeImmutable());
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

        return empty($text) ? 'n-a' : $text;
    }
}
