<?php
/**
 * Gabyfle
 * Configuration.php
 *
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */
namespace Gabyfle\Core;

/**
 * Class Configuration
 * Loads the configuration from a PHP file (? maybe we can extend it to JSON, YAML and INI files)
 * @package Gabyfle\Core
 */
class Configuration
{
    /**
     * @var Configuration
     */
    private static $instance;
    private $configuration;

    public function __construct(string $path)
    {
        try {
            $this->load($path);
        } catch (\Exception $e) {
            echo 'An error occurred while loading the configuration file : ' . $e;
        }
    }

    /**
     * Build a new instance of Configuration and put it in self::$instance
     * @param string $path
     * @return Configuration
     */
    public static function build(string $path) :Configuration
    {
        if (is_null(self::$instance) ||
            !self::$instance instanceof self
        ) {
            self::$instance = new self($path);
        }

        return self::$instance;
    }

    /**
     * Returns an instance of Configuration
     * @return Configuration
     * @throws \Exception
     */
    public static function getInstance() :Configuration
    {
        if (!is_null(self::$instance) && self::$instance instanceof self) {
            return self::$instance;
        }

        throw new \Exception('There is no instance of Configuration available. You should build Configuration before using it.');
    }

    /**
     * Gets a parameter from the configuration file. The configuration must have been loaded before using this.
     * @param string $parameterName
     * @return mixed
     * @throws \Exception
     */
    public function get(string $parameterName, $default = null)
    {
        if (is_null(self::$instance) ||
            !self::$instance instanceof self
        ) {
            throw new \Exception('There is no instance of Configuration available. You should build Configuration before using it.');
        }

        if (empty($parameterName)) {
            return $this->configuration;
        } elseif (!isset($this->configuration[$parameterName])) {
            return $default;
        } else {
            return $this->configuration[$parameterName];
        }
    }

    /**
     * Loads a configuration array from a PHP file.
     * @param string $path
     * @return void
     * @throws \Exception
     */
    public function load(string $path)
    {
        if (is_file($path)) {
            $this->configuration = include($path);
            return;
        }

        throw new \Exception('Can\'t load the following PHP configuration file :' . $path);
    }
}