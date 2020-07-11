<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Picture;
use App\Entity\Property;
use Bluemmb\Faker\PicsumPhotosProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    protected $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factor::create('fr_FR');
        $faker->addProvider(new PicsumPhotosProvider($faker));

        $admin = new User();
        $admin->setFullName('John Doe')
            ->setEmail('admin@gmail.com')
            ->setPassword($this->encoder->encodePassword($admin, 'admin'))
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        for($u = 0; $u < 10; $u++){
            $user = new User;
            $user->setFullName($faker->name())
                ->setEmail("user$u@gmail.com")
                ->setPassword($this->encoder->encodePassword($user, 'password'));

            $manager->persist($user);
        }


        for($p = 0; $p < 100; $p++){
            $property = new Property;

            $property->setTitle($faker->words(random_int(1, 5), true))
                ->setDescription($faker->paragraphs(3, true))
                ->setSurface($faker->numberBetween(30, 500))
                ->setRooms($faker->numberBetween(1, 5))
                ->setBedrooms($faker->numberBetween(1, 3))
                ->setFloor($faker->numberBetween(0, 5))
                ->setPrice($faker->numberBetween(50000, 600000))
                ->setHeat($faker->numberBetween(0, \count(Property::HEAT) - 1))
                ->setCity($faker->city)
                ->setAddress($faker->address)
                ->setPostalCode($faker->postcode)
                ->setSold(false)
                ->setCreatedAt($faker->dateTimeBetween('- 4 years'));

            $picture = new Picture;
            $picture->setProperty($property)
                ->setFilename($faker->imageUrl(200, 200, true));

            $manager->persist($property);
            $manager->persist($picture);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
