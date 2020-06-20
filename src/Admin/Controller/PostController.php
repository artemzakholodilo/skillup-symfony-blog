<?php

namespace App\Admin\Controller;

use App\Admin\Form\Type\PostType;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractController
{
    public function add(Request $request, EntityManagerInterface $em)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $image = $form->get('image')->getData();
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$image->guessExtension();

                try {
                    $image->move(
                        $this->getParameter('post_images_directory') . $post->getSlug(),
                        $newFilename
                    );
                } catch (FileException $e) {
                    log($e->getMessage());
                }

                $post->setImage($newFilename);
            }
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('admin/post/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}