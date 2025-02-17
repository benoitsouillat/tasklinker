<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/project', name: 'app_project_')]
final class ProjectController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $manager)
    {
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $projects = $this->manager->getRepository(Project::class)->findAll();
        return $this->render('project/index.html.twig', [
            'title' => 'Projets',
            'projects' => $projects,
        ]);
    }

    #[Route('/add', name: 'add', methods: ['GET', 'POST'])]
    #[Route('/{id}', name: 'edit', requirements: ['id' => '\+d'], methods: ['GET', 'POST'])]
    public function edit(Request $request, ?Project $project = null): Response
    {
        if ($project === null) {
            $project = new Project();
        }
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($project);
            $this->manager->flush();

            return $this->redirectToRoute('app_project_index');
        }
        return $this->render('project/edit.html.twig', [
            'form' => $form,
            'project' => $project,
            'title' => !empty($project->getName()) ? $project->getName() : "Créer un nouveau projet",
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function delete(Request $request, Project $project): Response
    {
        $this->manager->remove($project);
        $this->manager->flush();

        return $this->redirectToRoute('app_project_index');
    }
}
