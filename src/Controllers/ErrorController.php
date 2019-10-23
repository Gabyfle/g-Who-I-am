<?php
/**
 * Gabyfle
 * Controllers.php
 *
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */

namespace Gabyfle\Controllers;


use Gabyfle\Core\Template;

class ErrorController extends Controller
{
    public function run()
    {
        $template = new Template();
        $template->buildTemplate('error', []);
    }
}