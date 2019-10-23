<?php
/**
 * Gabyfle
 * LogoutController.php
 *
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */


namespace Gabyfle\Controllers;

use Gabyfle\SteamAuth;

/**
 * Class LogoutController
 * @package Gabyfle\Controllers
 */
class LogoutController extends Controller
{
    public function run()
    {
        SteamAuth::disconnect();
        header('Location: /home');
    }
}