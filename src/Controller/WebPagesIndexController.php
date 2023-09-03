<?php

namespace App\Controller;

use App\Entity\GlobalSettings;
use App\Entity\Menu;
use App\Entity\PagesList;
use App\Entity\PostsList;
use App\Entity\Services;
use App\Form\ContactFormType;
use App\Form\NewsletterFormType;
use App\Services\FormsService;
use Doctrine\Persistence\ManagerRegistry;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Intl\Locales;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class WebPagesIndexController extends AbstractController
{

    #region Page
    // Page Generator
    // -----------------------------------------------------------------------------------------------------------------
    private function showPage(ManagerRegistry $doctrine, Request $request, string $page_id, FormsService $formsService, Environment $twig): Response
    {

        #region Page
        $page_base = $doctrine->getRepository(PagesList::class);
        $page = $page_base->findOneBy(['page_url' => $page_id]);
        $post_base = $doctrine->getRepository(PostsList::class);
        $posts = $post_base->findAll();
        $menus = $doctrine->getRepository(Menu::class);

        $lang = $request->getLocale();
        $locales = Locales::getLocales();
        $localesSite = [
            $locales[280], // FR
            $locales[96] // EN
        ];

        $lang = array_search($lang, $localesSite);
        $meta_title = $page->getPageMetaTitle()[$lang];
        $meta_desc = $page->getPageMetaDesc()[$lang];
        $page_content = $page->getPageContent()[$lang];

        if (!$page || !$page->isStatus()) {
            return (!$page) ? $this->redirectToRoute('web_index') : throw $this->createNotFoundException("Cette page n'est pas disponible");
        }

        $settings = $doctrine->getRepository(GlobalSettings::class)->findOneBy(['id' => 0]);
        $posts = $doctrine->getRepository(PostsList::class)->findAll();
        $services = $doctrine->getRepository(Services::class)->findBy([], ['pos' => 'ASC', 'title' => 'ASC']);
        $mailingVar = $this->getParameter('brevo');

        if (!$page || !$page->isStatus()) {
            throw $this->createNotFoundException("Cette page n'est pas disponible");
        }
        
        if ($page){
            $page_lang = $request->getLocale();
            $meta_title = $page->getPageMetaTitle();
            $meta_desc = $page->getPageMetaDesc();
        } else {
            return $this->redirectToRoute('web_index');
        }
        #endregion

        #region Templates de code
        $page_content = htmlspecialchars_decode($page_content);
        $page_content = $twig->createTemplate($page_content)->render();
        #endregion

        #region Formulaire de Contact
        $contactForm = $this->createForm(ContactFormType::class);
        $contactForm->handleRequest($request);
        $formData = [
            'fname' => $contactForm->get('fname')->getData(),
            'lname' => $contactForm->get('lname')->getData(),
            'mail' => $contactForm->get('mail')->getData(),
            'tel' => $contactForm->get('tel')->getData(),
            'subject' => $contactForm->get('subject')->getData(),
            'message' => $contactForm->get('message')->getData(),
        ];

        if ($contactForm->isSubmitted() && $contactForm->isValid()) { 
            // E-Mail depuis le formulaire
            $formsService->send(
                $contactForm->get('mail')->getData(),
                'contact@lesfleursderiton.com',
                $contactForm->get('subject')->getData(),
                'form-e-mail',
                $formData
            );
            // E-Mail récapitulatif
            $formsService->send(
                'contact@lesfleursderiton.com',
                $contactForm->get('mail')->getData(),
                "Récapitulatif de votre demande par E-Mail",
                'confirmation-envoi',
                $formData
            );
        }
        #endregion

        #region Formulaire de Newsletter
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
                        'Authorization' => 'Bearer ' . $mailingVar,
                        'Content-Type' => 'application/json',
                    ],
                ]);

                $statusCode = $response->getStatusCode();
                $responseBody = $response->getBody()->getContents();
                
                return new Response($responseBody, $statusCode);
            } catch (\Throwable $th) {
                throw $th;
                // return new Response($th->getMessage(), 500);
            }
        }
        #endregion

        return $this->render('web_pages_views/index.html.twig', [
            'page_content' => $page_content,
            'posts' => $posts,
            'lang' => $lang,
            'lang_page' => $localesSite[$lang],
            'meta_title' => $meta_title,
            'meta_desc' => $meta_desc,
            'settings' => $settings,
            'menus' => $menus,
            'services' => $services,
            'contact_form' => $contactForm->createView(),
            'news_form' => $newsForm->createView(),
        ]);
    }

    // Index Page
    // -----------------------------------------------------------------------------------------------------------------
    #[Route('/{_locale}', name: 'web_index', requirements: ['_locale' => 'fr'])]
    public function index(ManagerRegistry $doctrine, Request $request, FormsService $formsService, Environment $twig): Response
    {
        return $this->showPage($doctrine, $request, 'index', $formsService, $twig);
    }


    // Other Page
    // -----------------------------------------------------------------------------------------------------------------
    #[Route('/{_locale}/{page_slug}', name: 'web_page', requirements: ['_locale' => 'fr'])]
    public function page(ManagerRegistry $doctrine, Request $request, FormsService $formsService, string $page_slug, Environment $twig): Response
    {
        return ($page_slug === 'index') ? $this->redirectBase() : $this->showPage($doctrine, $request, $page_slug, $formsService, $twig);
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
        $menus = $doctrine->getRepository(Menu::class);
        $statut = $post->isOnline();

        if (!$statut) {
            throw $this->createNotFoundException("Cet article n'est pas disponible");
        }

        $lang = $request->getLocale();
        $locales = Locales::getLocales();
        $localesSite = [
            $locales[280], // FR
            $locales[96] // EN
        ];
        
        $lang = array_search($lang, $localesSite);
        $meta_title = $post->getPostMetaTitle()[array_search($lang, $localesSite)];
        $meta_desc = $post->getPostMetaDesc()[array_search($lang, $localesSite)];
        $post_content = $post->getPostContent()[array_search($lang, $localesSite)];

        return $this->render('web_pages_views/post.html.twig', [
            'post_slug' => $post->getPostUrl(),
            'post_thumb' => $post->getPostThumb(),
            'post_content' => htmlspecialchars_decode($post_content),
            'menus' => $menus,
            'lang' => $lang,
            'lang_page' => $localesSite[$lang],
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

    #region Template
    private function showIncludes($contenu, Environment $twig){
        // Utiliser une expression régulière pour détecter les inclusions spéciales dans le contenu
        $pattern = '/\{% include \'(.*?)\' with ({.*?}) %\}/';
        $contenu = preg_replace_callback($pattern, function ($match) use ($twig) {
            $template = $match[1];
            $parametres = $match[2];
            $parametresArray = json_decode($parametres, true);

            // Charger le contenu du template TWIG correspondant avec les paramètres
            $loader = new FilesystemLoader('/chemin/vers/les/templates');
            $template = $twig->load($template);

            // Rendre le template avec les paramètres
            return $template->render($parametresArray);
        }, $contenu);

        return $contenu;
    }
    #endregion
}
