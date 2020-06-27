<?php

namespace App\Admin\Controller;

use App\Admin\Form\Type\PostType;
use App\Entity\Post;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractController
{
    private $fileUploader;

    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

    /**
     * Dependency injection container => object static property instances [new PDO, new User, ...]
     * Dependency injection
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('images')->getData();
            $post->removeImages();

            foreach ($images as $image) {
                $imageEntity = $this->fileUploader->upload(
                    $image, $this->getParameter('post_images_directory'), $post->getSlug()
                );

                try {
                    $imageEntity->setPost($post);
                    $em->persist($imageEntity);
                    $post->addImage($imageEntity);
                    $em->persist($post);
                } catch (FileException $e) {
                    log($e->getMessage());
                }
            }

            $em->flush();

            return $this->redirectToRoute('home');
        } else {
            return $this->render('admin/post/add.html.twig', [
                'form' => $form->createView()
            ]);
        }

        return $this->render('admin/post/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}