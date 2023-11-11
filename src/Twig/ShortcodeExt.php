<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;
use Symfony\Component\HttpKernel\KernelInterface;

class ShortcodeExt extends AbstractExtension
{
    private $entityManager;
    private $twig;
    private $environment;

    public function __construct(EntityManagerInterface $entityManager, Environment $twig, KernelInterface $kernel)
    {
        $this->entityManager = $entityManager;
        $this->twig = $twig; // Inject the Twig service
        $this->environment = $kernel->getEnvironment();
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('convert_shortcode', [$this, 'convertShortcode'], ['is_safe' => ['html']]),
        ];
    }

    public function convertShortcode(string $content)
    {
        $processedContent = preg_replace_callback(
            '/\[include:([^ \]]+)([^\]]+)\]/',
            function ($matches) {
                $templatePath = trim($matches[1]);
                $variablesString = $matches[2];
                $variables = [];
    
                // Convertir la chaîne de variables en tableau associatif
                preg_match_all('/(\S+)="([^"]+)"/', $variablesString, $variableMatches);
                foreach ($variableMatches[1] as $index => $name) {
                    $variables[$name] = $variableMatches[2][$index];
                }
    
                // Charger et rendre le template Twig inclus avec les variables si elles sont présentes
                return $this->renderTemplate($templatePath, $variables);
            },
            $content
        );
    
        return $processedContent;
    }

    private function renderTemplate($templatePath, $variables)
    {
        // Filtrer les variables pour ne transmettre que celles qui sont définies
        $filteredVariables = array_filter($variables, function ($value) {
            return $value !== null;
        });

        // Utiliser le service Twig pour rendre le template spécifié avec les variables si elles sont présentes
        return $this->twig->render($templatePath, $filteredVariables);
    }
}