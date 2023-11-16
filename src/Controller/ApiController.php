<?php

namespace App\Controller;

use App\Entity\Services;
use App\Services\FormsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    private $em;
    private $servicesRepo;
    private $request;
    private $formService;

    function __construct(EntityManagerInterface $em, FormsService $formService)
    {
        $this->em = $em;
        $this->servicesRepo = $this->em->getRepository(Services::class);
        $this->formService = $formService;
        $this->request = new Request();
    }

    #[Route('/api/services', name: 'api_services')]
    public function services(): JsonResponse
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

    #[Route('/api/contact-form', name: 'api_contact_form', methods: ["POST"])]
    function contactForm() {
        $data = json_decode($this->request->getContent(), true);

        $nom = $data['nom'];
        $prenom = $data['prenom'];
        $tel = $data['tel'] ?? "Non communiqué";
        $mail = $data['email'];
        $message = $data['message'];
        $objet = $data['objet'];

        $dataArray = [
            'nom' => $nom,
            'prenom' => $prenom,
            'tel' => $tel,
            'mail' => $mail,
            'objet' => $objet,
            'message' => $message,
        ];

        try {
            $this->formService->send($mail, 'contact@lesfleursderiton.com', $objet, 'form-e-mail', $dataArray);

            return new JsonResponse([
                "Response" => "Votre E-Mail a bien été envoyé"
            ], 200);
        } catch (\Throwable $th) {
            return $this->json([
                'Response' => $th,
                "data" => $data
            ], 500);
        }
    }
}
