<?php

namespace App\DataFixtures;

use App\Entity\Artwork;
use App\Entity\ArtWorkCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $category = new ArtWorkCategory();
            $category->setName('category ' . $i);
            $category->setImage('category ' . $i . '.jpg');
            $manager->persist($category);
        }

        $manager->flush();

        $CategoryRepository = $manager->getRepository(ArtWorkCategory::class);
        $categorys = $CategoryRepository->findAll();

        for ($i = 1; $i <= 200; $i++) {

            $randkey = rand (0, count($categorys)-1);

            $artwork= new Artwork();
            $artwork->setName('Artwork ' . $i);
            $artwork->setArtWorkCategorie($categorys[$randkey]);
            $artwork->setPrice(rand(5000, 100000) / 5);
            $artwork->setImage('artwork ' . $i . '.jpg');
            $artwork->setStock(rand(50, 200));
            $artwork->setDescription('Artwork ' . $i . ' is an unique description of feels and emotions.');

            $manager->persist($artwork);


        }
        $manager->flush();

    }
}
