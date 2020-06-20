<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();
        $categories = [];
        $tags = [];

        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->setName($faker->text(8));
            $category->setRating(1, 5);
            $manager->persist($category);
            $categories[] = $category;
        }
        $manager->flush();

        //
        $i = 0;
        for ($i = 0; $i < 100; $i++) {
            $post = new Post();
            $post->setTitle($faker->word(5));
            $post->setBody($faker->realText(3000));
            $post->setSlug($faker->slug(3));
            $randomCategory = rand(0, count($categories) - 1);
            $post->setCategory($categories[$randomCategory]);
            for ($j = 0; $j < 3; $j++) {
                $tag = new Tag();
                $tag->setName($faker->text(8));
                $post->addTag($tag);
                $manager->persist($tag);
            }
            $manager->persist($post);
        }

        $manager->flush();
    }
}
