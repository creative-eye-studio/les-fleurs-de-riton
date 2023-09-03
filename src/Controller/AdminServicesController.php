<?php

namespace App\Controller;

use App\Entity\Services;
use App\Entity\ServicesImages;
use App\Form\ServiceFormType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminServicesController extends AbstractController
{
    #[Route('/admin/services', name: 'admin_services')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $servicesRepo = $entityManager->getRepository(Services::class);
        $services = $servicesRepo->findAll();

        return $this->render('admin_services/index.html.twig', [
            "services" => $services
        ]);
    }

    #[Route('/admin/services/ajout', name: 'app_service_create')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $service = new Services();
        $form = $this->createForm(ServiceFormType::class, $service);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $service = $form->getData();
            $entityManager = $doctrine->getManager();

            // Téléchargement des images
            $imageFiles = $form->get('images')->getData();
            foreach ($imageFiles as $imageFile) {
                $dest = $this->getParameter('services_img_directory');
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                $imageFile->move($dest, $newFilename);

                $image = new ServicesImages();
                $entityManager->persist($service);
                $image->setServId($service);
                $image->setImgName($newFilename);

                $entityManager->persist($image);
                $entityManager->flush();
            }

            // Envoi des données vers la BDD
            $entityManager->persist($service);
            $entityManager->flush();
        }

        return $this->render('admin_services/service-manager.html.twig', [
            'title' => "Créer un service",
            'form' => $form->createView(),
            'images' => $service->getServicesImages()
        ]);
    }

    #[Route('/admin/services/modif/{id}', name: 'app_service_update')]
    public function update(ManagerRegistry $doctrine, Request $request, string $id): Response
    {
        $entityManager = $doctrine->getManager();
        $servicesRepo = $entityManager->getRepository(Services::class);
        $service = $servicesRepo->findOneBy(['id' => $id]);

        $form = $this->createForm(ServiceFormType::class, $service);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { 
            $service = $form->getData();
            $entityManager = $doctrine->getManager();

            // Téléchargement des images
            $imageFiles = $form->get('images')->getData();
            foreach ($imageFiles as $imageFile) {
                $dest = $this->getParameter('services_img_directory');
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                $imageFile->move($dest, $newFilename);

                $image = new ServicesImages();
                $entityManager->persist($service);
                $image->setServId($service);
                $image->setImgName($newFilename);

                $entityManager->persist($image);
                $entityManager->flush();
            }

            // Envoi des données vers la BDD
            $entityManager = $doctrine->getManager();
            $entityManager->persist($service);
            $entityManager->flush();
        }

        return $this->render('admin_services/service-manager.html.twig', [
            'title' => "Mettre à jour un service",
            'form' => $form->createView(),
            'images' => $service->getServicesImages()
        ]);
    }

    #[Route('/admin/services/delete-image/{id}', name: 'delete_image', methods:['POST'])]
    public function delete_image(ManagerRegistry $doctrine, int $id): Response
    {
        $em = $doctrine->getManager();
        $image = $em->getRepository(ServicesImages::class)->findOneBy(['id' => $id]);

        $em->remove($image);
        $em->flush();

        return new JsonResponse(['message' => 'Data deleted successfully']);
    }
}
