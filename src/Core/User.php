<?php
/**
 * Gabyfle
 * User.php
 *
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */
namespace Gabyfle\Core;

use Gabyfle\SteamAuth;

/**
 * Class User
 * A light class which make user management faster :)
 * @package Gabyfle\Core
 */
class User
{
    /**
     * @var \PDO
     */
    private $db;
    /**
     * @var string
     */
    private $id;
    /**
     * @var array
     */
    public $connectedAccounts;
    /**
     * @var Configuration
     */
    private $config;
    /**
     * ERRORS CONSTANTS
     */
    const ACCOUNT_ALREADY_CONNECTED = 1;
    const UNKNOWN_PROVIDER = 2;
    const UNKNOWN_USER = 3;
    /**
     * User constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        try {
            $this->db = Database::getInstance()->getPDOObject();
            $this->config = Configuration::getInstance();
            $this->id = $id;
            $this->connectedAccounts = [];
        } catch (\Exception $e) {
            echo 'An error occurred while trying to create an user object. Error : ' . $e;
        }
    }

    /**
     * Returns whether or not this
     * @return bool
     */
    private function exists() :bool
    {
        $request = $this->db->prepare('SELECT * FROM gabyfle WHERE SteamID = :steamid');
        $request->execute([
            'steamid' => $this->id
        ]);

        return count($request->fetchAll()) == 1;
    }

    /**
     * Initialize an user into the database
     * @return bool
     */
    private function initUserDatabase() :bool
    {
        $request = $this->db->prepare('INSERT INTO gabyfle (SteamName, SteamID) VALUES (:steamname, :steamid)');
        if (
            $request->execute([
                'steamname' => SteamAuth::getUserData('personaname'),
                'steamid' => $this->id
            ])
        ) {
            return true;
        }

        return false;
    }

    /**
     * Try to build a new user into the database
     * @return bool
     * @throws \Exception
     */
    public function buildUser() :bool
    {
        if (
            !$this->exists() &&
            !$this->initUserDatabase()
        ) {
            throw new \Exception('A fatal error occurred while trying to init the user database.');
        }
        return true;
    }

    /**
     * Returns whether or not the current user is an administrator
     * @return bool
     * @throws \Exception
     */
    public function isAdministrator() :bool
    {
        return in_array($this->id, $this->config->get('administrators', []));
    }
}