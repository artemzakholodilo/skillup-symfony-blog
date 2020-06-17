<?php


namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $repository = $this->em->getRepository(Post::class);
        $posts = $repository->findAll();

        return $this->render('home/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @param string $slug
     * @return Response
     */
    public function view($slug): Response
    {
        $repository = $this->em->getRepository(Post::class);
        $post = $repository->findOneBy(['slug' => $slug, 'published' => false]);
        return $this->render('home/view.html.twig', [
            'post' => $post
        ]);
    }

    public function post(): Response
    {
        return $this->render('hello/post.html.twig');
    }
}
