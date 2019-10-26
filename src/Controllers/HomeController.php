<?php
/**
 * Gabyfle
 * HomeController.php
 *
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */

namespace Gabyfle\Controllers;


use Gabyfle\SteamAuth;
use Gabyfle\Core\Configuration;
use Gabyfle\Core\Template;
use Gabyfle\Core\User;
use Gabyfle\Util;

/**
 * Class HomeController
 * @package Gabyfle\Controllers
 */
class HomeController extends Controller
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
            $this->config = Configuration::getInstance();
            $url = 'http://gabyfle.local:8082/login';
            $this->steam = new SteamAuth($url, $this->config->get('steam')['api']);
        } catch (\Exception $e) {
            echo 'OOPS ! A <em>fatal</em> error occurred and we canno\'t retreive your site\'s configuration.';
        }
    }

    /**
     * isConnected
     * Returns whether or not the user is connected
     * @return bool
     */
    public function isConnected() :bool
    {
        return $this->steam->check();
    }

    public function run()
    {
        $template = new Template();
        if ($this->isConnected()) {
            $user = new User(SteamAuth::getUserData('steamid'));
            $params = [
                'user' => SteamAuth::getUserData()
            ];
            try {
                if ($user->isAdministrator()) { /* Adding it to the "user" array */
                    $params['user']['administrator'] = true;
                } else {
                    $params['user']['administrator'] = false;
                }
                $params['connected'] = true;
            } catch (\Exception $e) {
                $params['connected'] = false;
                $params['user']['administrator'] = false;
            } finally {
                $template->buildTemplate('home', $params);
            }
        } else {
            $template->buildTemplate('home', []);
        }
    }
}