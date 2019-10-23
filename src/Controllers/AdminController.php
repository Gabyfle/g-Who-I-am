<?php
/**
 * Gabyfle
 * AdminController.php
 *
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */

namespace Gabyfle\Controllers;


use Gabyfle\SteamAuth;
use Gabyfle\Core\Configuration;
use Gabyfle\Core\Template;
use Gabyfle\Core\User;
use Gabyfle\Util;

class AdminController extends Controller
{
    /**
     * @var SteamAuth
     */
    private $steam;
    /**
     * @var Configuration
     */
    private $config;
    /**
     * @var User
     */
    private $user;

    public function __construct()
    {
        try {
            $this->config = Configuration::getInstance();
            $url = Util::getServerUrl() . '/login';
            $this->steam = new SteamAuth($url, $this->config->get('steam')['api']);
        } catch (\Exception $e) {
            error_log('[Gabyfle] A problem occurred in AdminController in __construct()');
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
        try {
            if ($this->isConnected()) {
                $this->user = new User(SteamAuth::getUserData('steamid'));
                if ($this->user->isAdministrator()) {
                    $template = new Template('admin');
                    try {
                        $template->buildTemplate('body', [
                            'user' => SteamAuth::getUserData(),
                            'administrators' => $this->config->get('administrators', [])
                        ], true);
                    } catch (\Exception $e) {
                        error_log('[Gabyfle] A fatal error occurred while trying to get the administrators from the config file.');
                        header('Location: /home');
                    }
                } else {
                    $template = new Template();
                    $template->buildTemplate('error', []);
                } /* Ok, we're clearly repeating ourselves. That's not optimal, but hey, wo carries ? */
            } else {
                $template = new Template();
                $template->buildTemplate('error', []);
            }
        } catch (\Exception $e) {
            error_log('[Gabyfle] A fatal error occurred while trying to check if the user is admin.');
            header('Location: /home');
        }
    }
}