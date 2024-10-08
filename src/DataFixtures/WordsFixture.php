<?php

namespace App\DataFixtures;

use App\Entity\Words;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class WordsFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $phrases = [
            'Sauvez les vers de terre, c\'est sauver la terre!',
            'Nous sommes des bioindicateurs!',
            'Pas de vers-de-terre pas d\'agriculture!',
            'SOS',
            'Help',
            'Nous sommes en danger!'
        ];

        foreach ($phrases as $phrase) {
            $word = new Words();
            $word->setContent($phrase);
            $manager->persist($word);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['WordsFixtures'];
    }
}
