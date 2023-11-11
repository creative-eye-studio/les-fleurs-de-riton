<?php

namespace App\Controller;

use App\Entity\Services;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    private $em;
    private $servicesRepo;

    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->servicesRepo = $this->em->getRepository(Services::class);
    }

    #[Route('/api/services', name: 'api_services')]
    public function index(): JsonResponse
    {
        $services = $this->servicesRepo->findAll();

        $list = array_map(function ($service) {
            return [
                'id' => $service->getId(),
                'label' => $service->getLabel(),
                'pos' => $service->getPos(),
                'title' => $service->getTitle(),
                'content' => htmlspecialchars_decode($service->getContent()), 
            ];
        }, $services);

        return $this->json($list);
    }
}
