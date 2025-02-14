<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/team')]
final class TeamController extends AbstractController
{
    #[Route('', name: 'team_index', methods: ['GET'])]
    public function index(EmployeeRepository $repository): Response
    {
        $employees = $repository->findAll();

        return $this->render('team/index.html.twig', [
            'employees' => $employees,
        ]);
    }

    #[Route('/add', name: 'team_add', methods: ['GET', 'POST'])]
    #[Route('/{id}', name: 'team_edit', requirements:  ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $manager, ?Employee $employee = null): Response
    {
        if (!$employee)
            $employee = new Employee();

        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($employee);
            $employee->setThumbnail(substr($employee->getFirstname(), 0, 1) . substr($employee->getLastname(), 0, 1));
            $manager->flush();
            return $this->redirectToRoute('team_index');
        }
        return $this->render('team/edit.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'team_delete', methods: ['DELETE'])]
    #[Route('/delete/{id}', name: 'team_delete', requirements:  ['id' => '\d+'], methods: ['GET'])]
    public function delete(Request $request, EntityManagerInterface $manager, Employee $employee): Response
    {
        /* Utiliser la requète pour ajouter le verbe delete */
        $manager->remove($employee);
        $manager->flush();
        return $this->redirectToRoute('team_index');
    }
}
