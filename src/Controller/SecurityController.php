<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/api/permissions', name: 'api_get_permissions', methods: ['GET'])]
    public function getPermissions(UserInterface $user): JsonResponse
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            // L'utilisateur a le rôle ADMIN
            return new JsonResponse([
                'message' => 'Access granted to admin functionalities.'
            ]);
        } elseif ($this->isGranted('ROLE_USER')) {
            // L'utilisateur a le rôle USER
            return new JsonResponse([
                'message' => 'Access granted to user functionalities.',
                'personal_info' => $user->getId() // Exemple d'accès aux informations personnelles
            ]);
        } else {
            return new JsonResponse([
                'message' => 'Access denied.'
            ], JsonResponse::HTTP_FORBIDDEN);
        }
    }
}
