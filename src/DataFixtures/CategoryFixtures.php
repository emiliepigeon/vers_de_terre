<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CategoryFixtures extends Fixture implements FixtureGroupInterface
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager)
    {
        $categories = [
            'témoignage',
            'éco-geste',
            'les dangers',
            'fait maison',
            'fiche technique',
            'e-learning'
        ];

        foreach ($categories as $categoryName) {
            $category = new Category();
            $category->setTitle($categoryName);
            $category->setSlug($this->slugger->slug($categoryName)->lower());
            $manager->persist($category);

            $this->addReference('category_' . strtolower(str_replace(' ', '_', $categoryName)), $category);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['CategoryFixtures'];
    }
}
