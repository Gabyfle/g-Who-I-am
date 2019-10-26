<?php
/**
 * Gabyfle
 * Controllers.php
 *
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */

namespace Gabyfle\Controllers;


use Gabyfle\SteamAuth;
use Gabyfle\Core\Configuration;
use Gabyfle\Core\Template;
use Gabyfle\Core\User;
use Gabyfle\Util;


class ErrorController extends Controller
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
        $template = new Template();
        if ($this->isConnected()) {
            $user = new User(SteamAuth::getUserData('steamid'));
            $params = [
                'user' => SteamAuth::getUserData()
            ];
            $params['connected'] = true;
            $template->buildTemplate('error', $params);
        } else {
            $template->buildTemplate('error', []);
        }
    }
}