<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/api/reservations', name: 'api_get_reservations', methods: ['GET'])]
    public function getReservations(UserInterface $user, ReservationRepository $reservationRepository): JsonResponse
    {
        if ($this->isGranted('ROLE_USER')) {
            $reservations = $reservationRepository->findBy(['user' => $user]);

            return new JsonResponse([
                'message' => 'Access granted.',
                'reservations' => $reservations
            ]);
        }

        return new JsonResponse([
            'message' => 'Access denied.'
        ], JsonResponse::HTTP_FORBIDDEN);
    }
}
