<?php

namespace App\Controller;

use App\Entity\GlobalSettings;
use App\Entity\PagesList;
use App\Entity\PostsList;
use App\Entity\Services;
use App\Form\ContactFormType;
use App\Form\NewsletterFormType;
use Doctrine\Persistence\ManagerRegistry;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class WebPagesIndexController extends AbstractController
{

    #region Page
    // Page Generator
    // -----------------------------------------------------------------------------------------------------------------
    private function showPage(ManagerRegistry $doctrine, Request $request, string $page_id): Response
    {
        $page = $doctrine->getRepository(PagesList::class)->findOneBy(["page_url" => $page_id]);
        $settings = $doctrine->getRepository(GlobalSettings::class)->findOneBy(['id' => 0]);
        $posts = $doctrine->getRepository(PostsList::class)->findAll();
        $services = $doctrine->getRepository(Services::class)->findBy([], ['pos' => 'ASC', 'title' => 'ASC']);
        $mailingVar = $this->getParameter('brevo');

        $statut = $page->isStatus();

        if (!$statut) {
            throw $this->createNotFoundException("Cette page n'est pas disponible");
        }
        
        if ($page){
            $page_lang = $request->getLocale();
            $meta_title = $page->getPageMetaTitle();
            $meta_desc = $page->getPageMetaDesc();
        } else {
            return $this->redirectToRoute('web_index');
        }

        // Formulaure de contact
        $contactForm = $this->createForm(ContactFormType::class);
        $contactForm->handleRequest($request);
        if ($contactForm->isSubmitted() && $contactForm->isValid()) { 
            
        }

        // Formulaire de Newsletter
        $newsForm = $this->createForm(NewsletterFormType::class);
        $newsForm->handleRequest($request);
        if ($newsForm->isSubmitted() && $newsForm->isValid()) { 
            $client = new Client();
            $data = [
                'email' => $newsForm->get('email')->getData(),
                'list_id' => '#4',
            ];

            try {
                $response = $client->post('https://api.brevo.com/contacts', [
                    'json' => $data,
                    'headers' => [
                        'Authorization' => 'Bearer ' + $mailingVar,
                        'Content-Type' => 'application/json',
                    ],
                ]);

                // Traitez la réponse de l'API Brevo en fonction de vos besoins
                $statusCode = $response->getStatusCode();
                $responseBody = $response->getBody()->getContents();
                
                // Retournez la réponse ou effectuez des actions supplémentaires si nécessaire
                return new Response($responseBody, $statusCode);
            } catch (\Throwable $th) {
                //throw $th;
                return new Response($th->getMessage(), 500);
            }
        }

        return $this->render('web_pages_views/index.html.twig', [
            'posts' => $posts,
            'services' => $services,
            'contact_form' => $contactForm,
            'news_form' => $newsForm,
            'page_lang' => $page_lang,
            'page_id' => $page->getPageId(),
            'page_slug' => $page->getPageUrl(),
            'meta_title' => $meta_title,
            'meta_desc' => $meta_desc,
            'settings' => $settings
        ]);
    }

    // Index Page
    // -----------------------------------------------------------------------------------------------------------------
    #[Route('/{_locale}', name: 'web_index', requirements: ['_locale' => 'fr|en'])]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        return $this->showPage($doctrine, $request, 'index');
    }


    // Other Page
    // -----------------------------------------------------------------------------------------------------------------
    #[Route('/{_locale}/{page_slug}', name: 'web_page', requirements: ['_locale' => 'fr|en'])]
    public function page(ManagerRegistry $doctrine, Request $request, string $page_slug): Response
    {
        if($page_slug == 'index')
            return $this->redirectBase();
        else
            return $this->showPage($doctrine, $request, $page_slug);
    }

    // Redirections
    // -----------------------------------------------------------------------------------------------------------------
    #[Route('/', name: 'web_redirect')]
    public function redirectBase(){
        return $this->redirectToRoute('web_index');
    }
    #endregion

    #region Post

    // Post Generator
    // -----------------------------------------------------------------------------------------------------------------
    public function showPost(ManagerRegistry $doctrine, Request $request, string $post_url){
        $post = $doctrine->getRepository(PostsList::class)->findOneBy(["post_url" => $post_url]);
        $statut = $post->isStatus();
        if (!$statut) {
            throw $this->createNotFoundException("Cet article n'est pas disponible");
        }
        
        $post_lang = $request->getLocale();
        $meta_title = $post->getPostMetaTitle();
        $meta_desc = $post->getPostMetaDesc();

        return $this->render('web_pages_views/post.html.twig', [
            'post_id' => $post->getPostId(),
            'post_slug' => $post->getPostUrl(),
            'post_thumb' => $post->getPostThumb(),
            'post_lang' => $post_lang,
            'meta_title' => $meta_title,
            'meta_desc' => $meta_desc,
        ]);
    }

    // Post Page
    // -----------------------------------------------------------------------------------------------------------------
    #[Route('/{_locale}/blog/{post_url}', name: 'web_post', requirements: ['_locale' => 'fr|en'])]
    public function post(ManagerRegistry $doctrine, Request $request, string $post_url): Response
    {
        return $this->showPost($doctrine, $request, $post_url);
    }

    #endregion
}
