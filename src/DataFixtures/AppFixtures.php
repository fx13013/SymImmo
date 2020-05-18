<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($p = 0; $p < 100; $p++){
            $property = new Property;
            $property->setTitle($faker->words(random_int(1, 5), true))
                ->setDescription($faker->paragraphs(3, true))
                ->setSurface($faker->numberBetween(30, 500))
                ->setRooms($faker->numberBetween(1, 5))
                ->setBedrooms($faker->numberBetween(1, 3))
                ->setFloor($faker->numberBetween(0, 5))
                ->setPrice($faker->numberBetween(50000, 600000))
                ->setHeat($faker->numberBetween(0, 3))
                ->setCity($faker->city)
                ->setAddress($faker->address)
                ->setPostalCode($faker->postcode)
                ->setCreatedAt($faker->dateTimeBetween('- 4 years'));

            $manager->persist($property);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
