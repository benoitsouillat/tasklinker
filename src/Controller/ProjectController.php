<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/project')]
final class ProjectController extends AbstractController
{
    #[Route('', name: 'project_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('project/index.html.twig', []);
    }
}
