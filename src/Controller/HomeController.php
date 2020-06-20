<?php


namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $dql   = "SELECT p FROM App:Post p ORDER BY p.id DESC";
        $query = $this->em->createQuery($dql);
        $pageNumber = $request->query->getInt('page', 1);
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $pageNumber, /*page number*/
            Post::ITEMS_PER_PAGE
        );
        $categories = $this->em->getRepository(Category::class)->findAll();

        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'pagination' => $pagination
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
