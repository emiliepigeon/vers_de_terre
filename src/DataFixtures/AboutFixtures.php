<?php

namespace App\DataFixtures;

use App\Entity\About;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class AboutFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $about = new About();
        $about->setTitle("World Worm Foundation");
        $about->setContent("La sauvegarde de nos vers de terre au service de notre planète terre.");
        
        $about->setTitle1("Notre association");
        $about->setContent1("World Worm Foundation est une organisation dédiée à la protection et à la préservation des vers de terre, ces créatures essentielles à la santé de nos sols et de notre écosystème.");
        
        $about->setTitle2("Nos conseils");
        $about->setContent2("Moins de pesticides\nMoins de béton\nPlus d'espace naturel");
        
        $about->setTitle3("Nos actions");
        $about->setContent3("Nous menons des campagnes de sensibilisation, organisons des événements éducatifs et collaborons avec des agriculteurs pour promouvoir des pratiques respectueuses des vers de terre.");

        $manager->persist($about);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['AboutFixtures'];
    }
}
