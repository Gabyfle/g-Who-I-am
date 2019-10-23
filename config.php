<?php
/**
 * Gabyfle's website
 * config.php
 *
 * Website's configuration file
 *
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */

/* DO NOT MODIFY THE ARRAY STRUCTURE OR YOU WILL EXPERIENCE TONS OF BUGS */
$Gabyfle = [
    'administrators' => [
        '76561198127516196'
    ],
    'database' => [
        'host' => 'localhost',
        'dbname' => 'greward',
        'dbuser' => 'root',
        'dbpass' => ''
    ],
    'site' => [
        'template' => 'default',
        'title' => 'Gabyfle - Site web d\'un sauvage',
        'language' => 'en', /* Available languages : fr and en */
    ],
    'steam' => [
        'api' => '1703CBAD0D0C9FEF467A432342465B67'
    ],
    'discord' => [
        'active' => true, /* Is the Discord reward active ? */
        'api' => ''
    ],
    'twitter' => [
        'active' => true, /* Is the Twitter reward active ? */
        'api' => ''
    ],
    'youtube' => [
        'active' => true, /* Is the YouTube reward active ? */
        'api' => ''
    ]
];

/* DO NOT TOUCH THIS LINE */
return $Gabyfle;