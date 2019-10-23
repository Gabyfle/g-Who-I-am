<?php
/**
 * Gabyfle
 * Database.php
 *
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */
namespace Gabyfle\Core;

/**
 * Class Database
 * @package Gabyfle\Core
 */
class Database
{
    /**
     * @var Database
     */
    private static $instance;
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(string $host, string $dbname, string $dbuser, string $dbpass)
    {
        try {
            $this->pdo = new \PDO('mysql:host='. $host . ';dbname=' . $dbname . ';charset=utf8', $dbuser, $dbpass);
        } catch (\Exception $e) {
            echo 'An error occurred while connecting to the database : ' . $e;
        }

    }

    /**
     * Build a new instance of Database and put it in self::$instance
     * @param string $path
     * @return Database
     */
    public static function build(string $host, string $dbname, string $dbuser, string $dbpass) :Database
    {
        if (is_null(self::$instance) ||
            !self::$instance instanceof self
        ) {
            self::$instance = new self($host, $dbname, $dbuser, $dbpass);
        }

        return self::$instance;
    }

    /**
     * Returns an instance of Database
     * @return Database
     * @throws \Exception
     */
    public static function getInstance() :Database
    {
        if (!is_null(self::$instance) && self::$instance instanceof self) {
            return self::$instance;
        }

        throw new \Exception('There is no instance of Configuration available. You should build Configuration before using it.');
    }

    /**
     * Returns the PDO object in itself.
     * @return \PDO
     */
    public function getPDOObject()
    {
        return $this->pdo;
    }
}