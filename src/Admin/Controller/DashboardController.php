<?php

namespace App\Admin\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    public function index()
    {
        return $this->render('admin/dashboard/index.html.twig', [
            'message' => 'Hello'
        ]);
    }
}