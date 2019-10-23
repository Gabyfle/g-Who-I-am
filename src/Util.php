<?php
/**
 * Gabyfle
 * Util.php
 *
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */
namespace Gabyfle;


class Util
{
    /**
     * getServerUrl
     * Get the full server URL including protocol and port
     * @return string
     */
    public static function getServerUrl() :string
    {
        /* Defining the server's protocol */
        if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off') {
            $protocol = 'https';
        } else {
            $protocol = 'http';
        }
        /* Defining server name */
        $serverName = $_SERVER['SERVER_NAME'];
        /* Defining server port */
        if ($_SERVER['SERVER_PORT'] != 80 && $_SERVER['SERVER_PORT'] != 443) {
            $port = ":{$_SERVER['SERVER_PORT']}";
        } else {
            $port = '';
        }
        return $protocol . '://' . $serverName . $port;
    }
}