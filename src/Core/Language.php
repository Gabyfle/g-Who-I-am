<?php
/**
 * Gabyfle
 * Language.php
 *
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */
namespace Gabyfle\Core;

/**
 * Class Language
 * Allows a faster language support
 * @package Gabyfle\Core
 */
class Language
{
    /**
     * @var Language
     */
    private static $instance;
    /**
     * @var string
     */
    private $lang;
    /**
     * @var array
     */
    private $translations;
    /**
     * Path constant
     */
    const LANGUAGE_FILES_PATH = DOCUMENT_ROOT . 'lang/';
    /**
     * Errors constants
     */
    const NO_ERRORS = 0;
    const UNKNOWN_LANGUAGE = 1;
    const FAILED_JSON_PARSING = 2;

    /**
     * Language constructor.
     * @param string $lang
     * @throws \Exception
     */
    public function __construct(string $lang)
    {
        if (!in_array($lang, $this->getAvailableLanguages())) {
            throw new \Exception('You\'re trying to use an unknown language. Please, refer to the list of languages in /lang');
        }
        $this->lang = $lang;
        $this->setTranslations(self::LANGUAGE_FILES_PATH . $lang . '.json');
    }

    /**
     * Builds a new instance of Language
     * @param string $lang
     * @return Language
     * @throws \Exception
     */
    public static function build(string $lang) :Language
    {
        if (is_null(self::$instance) ||
            !self::$instance instanceof self
        ) {
            self::$instance = new self($lang);
        }

        return self::$instance;
    }

    /**
     * Returns an instance of Language
     * @return Language
     * @throws \Exception
     */
    public static function getInstance() :Language
    {
        if (!is_null(self::$instance) && self::$instance instanceof self) {
            return self::$instance;
        }

        throw new \Exception('There is no instance of Language available. You should build Language before using it.');
    }

    /**
     * Returns whether or not a JSON file is a correct language file
     * @param string $path
     * @return bool
     */
    private function isLang(string $path) :bool
    {
        if (pathinfo($path)['extension'] != 'json') {
            return false;
        }
        $json = file_get_contents($path);
        $decoded = json_decode($json, true);
        /* Just checking if the two arrays 'DASHBOARD' and 'PAGES' have been set, no need to check if they are tables :) */
        return json_last_error() == JSON_ERROR_NONE && !empty($decoded['dashboard']) && !empty($decoded['pages']);
    }

    /**
     * Returns every lang file found in DOCUMENT_ROOT . '/lang'
     * @return array
     */
    private function getAvailableLanguages() :array // OMG, this function has a verrrrry long name... (this sounds like Java)
    {
        /* An array containing every languages files */
        $languages = [];

        foreach (scandir(self::LANGUAGE_FILES_PATH) as $path) {
            if (is_dir($path)) {
                continue;
            } elseif ($this->isLang(self::LANGUAGE_FILES_PATH . $path)) {
                $languages[] = pathinfo($path)['filename'];
            }
        }

        return $languages;
    }

    /**
     * Set translations into $this->translations
     * @param string $path
     * @throws \Exception
     */
    private function setTranslations(string $path) :void
    {
        $file = file_get_contents($path);
        $data = json_decode($file, true); // getting it has an assoc array
        if (json_last_error() == 0) {
            $this->translations = $data;
        } else {
            throw new \Exception('An error occurred while trying to parse the language file : ' . json_last_error_msg());
        }
    }

    /**
     * Returns an array with every translations
     * @return array
     */
    public function getTranslations() :array
    {
        return $this->translations;
    }

    /**
     * Set a new language for the current execution
     * @param string $lang
     * @return int : error constant
     */
    public function setLang(string $lang) :int
    {
        if (!in_array($lang, $this->getAvailableLanguages())) {
            return self::UNKNOWN_LANGUAGE;
        }
        try {
            $this->setTranslations(self::LANGUAGE_FILES_PATH . $lang . '.json');
        } catch (\Exception $e) {
            return self::FAILED_JSON_PARSING;
        }

        $this->lang = $lang;
        return self::NO_ERRORS;
    }

    /**
     * Returns the current language
     * @return string
     */
    public function getLang() :string
    {
        return $this->lang;
    }
}