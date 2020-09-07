<?php

namespace App\DataFixtures;

use App\ArticleAPI\Domain\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i <= 50; ++$i) {
            $article = new Article();

            $article->setTitle($faker->sentence);
            $article->setBody($faker->paragraph);

            $article->setCreatedAt(new \DateTime());
            $article->setUpdatedAt(new \DateTime());

            $manager->persist($article);
            $manager->flush();
        }
    }
}
