<?php
/**
 * Gabyfle
 * Controllers.php
 *
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */
namespace Gabyfle\Controllers;

/**
 * Class Controllers
 * @package Gabyfle\Controllers
 */
abstract class Controller
{
    /**
     * Launch the view to a client
     * @return void
     */
    abstract public function run();
}