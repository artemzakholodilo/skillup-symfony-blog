<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// ORM object relational mapper
class HelloController extends AbstractController
{
    public function index(Request $request): Response
    {
        $query = $request->query->get('q') ?? null;
        if ($query) {
            var_dump($query);
            exit;
        }
        return $this->render('hello/index.html.twig', [
            'message' => 'qwe'
        ]);
    }

    public function post(): Response
    {
        return $this->render('hello/post.html.twig');
    }
}