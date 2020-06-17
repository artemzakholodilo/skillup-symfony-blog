<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TagController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function posts($id)
    {
        $repository = $this->em->getRepository(Post::class);
        $posts = $repository->getPostsByTagId($id);

        return $this->render('tag/posts.html.twig', [
            'posts' => $posts
        ]);
    }
}