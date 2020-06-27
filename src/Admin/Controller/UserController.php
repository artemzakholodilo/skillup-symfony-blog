<?php


namespace App\Admin\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    public function index(Request $request, EntityManagerInterface $em, Security $security): Response
    {
        $users = $em->getRepository(User::class)->findAll();
        $currentUser = $security->getUser();

        return $this->render('admin/user/index.html.twig', [
            'users' => $users
        ]);
    }

    public function promote(Request $request, EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $id = $request->request->get('id');
        $response = new JsonResponse();
        if (!$id) {
            return $this->badResponse("Id must contains", 400);
        }
        $user = $em->getRepository(User::class)->find($id);
        if (!$validator->validate($user)) {
            return $this->badResponse("User not found", 404);
        }
        $user->addRole(User::ROLE_ADMIN);
        $em->persist($user);

        $em->flush();
        $response->setStatusCode(Response::HTTP_NO_CONTENT);
        $response->setData([
            'success' => true,
            'message' => 'User updated'
        ]);

        return $response;
    }

    // DRY dont repeat yourself
    private function badResponse($message, $statusCode)
    {
        $response = new JsonResponse($message);
        $response->setStatusCode($statusCode);

        return $response;
    }
}