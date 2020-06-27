<?php

namespace App\Admin\Controller;

use GuzzleHttp\Client;
use LiqPay;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    public function index()
    {
        $client = 'qweqweqwe';
        return $this->render('admin/dashboard/index.html.twig', [
            'message' => 'Hello'
        ]);
    }
}