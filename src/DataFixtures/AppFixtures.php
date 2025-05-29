<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Order;
use App\Enum\OrderStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $authors = [];
        // Create 5 authors
        for ($i = 0; $i < 5; $i++) {
            $author = new Author();
            $author->setName($faker->name());
            $author->setEmail($faker->unique()->safeEmail());
            $author->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($author);
            $authors[] = $author;
        }

        // Create 20 orders
        $statuses = OrderStatus::cases();
        for ($i = 0; $i < 20; $i++) {
            $order = new Order();
            $order->setName($faker->words(3, true));
            $order->setAuthor($faker->randomElement($authors));
            $order->setCreatedAt(new \DateTimeImmutable());
            $order->setStatus($faker->randomElement($statuses));
            $manager->persist($order);
        }

        $manager->flush();
    }
}
