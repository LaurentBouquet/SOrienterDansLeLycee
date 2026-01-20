<?php

namespace App\Controller;

use App\Entity\Connection;
use App\Form\ConnectionType;
use App\Repository\ConnectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/connection')]
final class ConnectionController extends AbstractController
{
    #[Route(name: 'app_connection_index', methods: ['GET'])]
    public function index(ConnectionRepository $connectionRepository): Response
    {
        return $this->render('connection/index.html.twig', [
            'connections' => $connectionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_connection_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $connection = new Connection();
        $form = $this->createForm(ConnectionType::class, $connection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($connection);
            $entityManager->flush();

            return $this->redirectToRoute('app_connection_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('connection/new.html.twig', [
            'connection' => $connection,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_connection_show', methods: ['GET'])]
    public function show(Connection $connection): Response
    {
        return $this->render('connection/show.html.twig', [
            'connection' => $connection,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_connection_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Connection $connection, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConnectionType::class, $connection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_connection_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('connection/edit.html.twig', [
            'connection' => $connection,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_connection_delete', methods: ['POST'])]
    public function delete(Request $request, Connection $connection, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$connection->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($connection);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_connection_index', [], Response::HTTP_SEE_OTHER);
    }
}
