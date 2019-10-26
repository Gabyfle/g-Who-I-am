<?php
/**
 * Gabyfle
 * LoginController.php
 *
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */

namespace Gabyfle\Controllers;


use Gabyfle\SteamAuth;
use Gabyfle\Core\Configuration;
use Gabyfle\Core\User;

/**
 * Class LoginController
 * @package Gabyfle\Controllers
 */
class LoginController extends Controller
{
    /**
     * @var Configuration
     */
    private $config;
    /**
     * @var SteamAuth
     */
    private $steam;

    public function __construct()
    {
        try {
            $config = Configuration::getInstance();
            $url = 'http://gabyfle.local:8082/login';
            $this->steam = new SteamAuth($url, $config->get('steam')['api']);
        } catch (\Exception $e) {
            header('Location: /home');
        }
    }

    /**
     * Returns whether or not the user is already connected
     * @return bool
     */
    private function isConnected() :bool
    {
        return $this->steam->check();
    }

    public function run()
    {
        if ($this->isConnected()) {
            $this->steam->getDataFromSteam();
            $user = new User(SteamAuth::getUserData('steamid'));
            try {
                $user->buildUser();
            } catch (\Exception $e) {
                error_log($e);
            } finally {
                header('Location: /home');
            }
        } else {
            try {
                $this->steam->open();
            } catch (\ErrorException $e) {
                header('Location: /home');
            }
        }
    }
}