<?php
/**
 * Gabyfle
 * ConnectController.php
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
 * Class ConnectController
 * @package Gabyfle\Controllers
 */
class ConnectController extends Controller
{
    /**
     * @var SteamAuth
     */
    private $steam;
    /**
     * @var Configuration
     */
    private $config;

    public function __construct()
    {
        try {
            $this->config = Configuration::getInstance();
            $url = Util::getServerUrl() . '/login';
            $this->steam = new SteamAuth($url, $this->config->get('steam')['api']);
        } catch (\Exception $e) {
            header('Location: /home');
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
        if (!$this->isConnected()) {
            header('Location: /home');
        }
        $template = new Template();
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
    }
}