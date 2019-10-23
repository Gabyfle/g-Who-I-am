<?php
/**
 * Gabyfle
 * Template.php
 *
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */
namespace Gabyfle\Core;

use Gabyfle\Util;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

/**
 * Class Template
 * @package Gabyfle\Core
 */
class Template
{
    /**
     * @var Configuration
     */
    private $config;
    /**
     * @var string
     */
    private $templateName;

    const PAGES = [
        'connect.twig',
        'error.twig',
        'home.twig'
    ];

    public function __construct(string $templateName = '')
    {
        try {
            $this->config = Configuration::getInstance();
            if ($templateName == ''){
                $this->templateName = $this->config->get('site')['template'];
            } else {
                $this->templateName = $templateName;
            }
        } catch (\Exception $e) {
            echo 'An error occurred while trying to build up the template : ' . $e;
        }
    }

    /**
     * Check if a template is a valid one
     * @return bool
     */
    private function isValid() :bool
    {
        if (
            !is_dir(DOCUMENT_ROOT . '/templates/' . $this->templateName) ||
            array_diff(self::PAGES, scandir(DOCUMENT_ROOT . '/templates/' . $this->templateName))
        ) { // we could just return the things in the if statement but for long expressions like this, I do not like this
            return false;
        }

        return true;
    }

    /**
     * Checks whether or not a page is a valid one
     * @param string $pageName
     * @return bool
     */
    private function isValidPage(string $pageName) :bool
    {
        return is_file(DOCUMENT_ROOT . '/templates/' . $this->templateName . '/' . $pageName);
    }

    /**
     * Returns an array with every basic parameters such as site data (title, url...)
     * @return array
     */
    private function buildParams() :array
    {
        $parameters = [
            'site' => $this->config->get('site', [])
        ];

        /**
         * 'Site' additional parameters
         */
        $parameters['site']['url'] = Util::getServerUrl();

        return $parameters;
    }

    /**
     * Build the template with the TWIG templating engine. Displays the template.
     * @param string $pageName
     * @param array $parameters
     */
    public function buildTemplate(string $pageName, array $parameters, bool $isAdminTemplate = false)
    {
        if ($this->isValid() || $isAdminTemplate) {
            $loader = new FilesystemLoader(DOCUMENT_ROOT . '/templates/' . $this->templateName);
            $twig = new Environment($loader, [
                'cache' => DOCUMENT_ROOT . '/cache',
            ]);
            if (!$this->isValidPage($pageName . '.twig')) {
                echo 'Page ' . $pageName . ' does not exists.';
                return;
            }
            try {
                $template = $twig->load($pageName . '.twig');
            } catch (LoaderError $e) {
                echo 'An error occurred while rendering the template ' . $e;
            } catch (RuntimeError $e) {
                echo 'An error occurred while rendering the template ' . $e;
            } catch (SyntaxError $e) {
                echo 'An error occurred while rendering the template ' . $e;
            }
            /* Merging everything together and building the template */
            $parameters = array_merge($this->buildParams(), $parameters);
            echo $template->render($parameters);
        }
    }
}