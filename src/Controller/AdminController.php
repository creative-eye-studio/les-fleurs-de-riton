<?php

namespace App\Controller;

use App\Entity\PagesList;
use App\Entity\PostsList;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $pagesList = $em->getRepository(PagesList::class)->findBy([], ['id' => 'DESC'], 5);
        $postsList = $em->getRepository(PostsList::class)->findBy([], ['id' => 'DESC'], 5);
        $usersList = $em->getRepository(User::class)->findBy([], ['id' => 'DESC'], 5);

        return $this->render('admin/index.html.twig', [
            'phpversion' => phpversion(),
            'pagesList' => $pagesList,
            'postsList' => $postsList,
            'usersList' => $usersList,
        ]);
    }
}
