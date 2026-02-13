<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class CompassController extends AbstractController
{
    #[Route('/compass', name: 'app_compass')]
    public function index(): Response
    {
        return $this->render('compass/index.html.twig', [
            'controller_name' => 'CompassController',
        ]);
    }
}
