<?php
/**
 * Uses posts.class.php to get posts datas
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */
require('classes/posts.class.php');
require('../config.php');
$posts = new Posts($ghost, $gname, $guser, $gpass);

/**
 * printJson($toPrint)
 * Print $toPrint into JSON format, with json header
 */
function printJson($toPrint)
{
    /* Printing this in JSON format, to allow JS & PHP scripts to parse easily this data */
    header('Content-Type: application/json');
    echo json_encode($toPrint, JSON_PRETTY_PRINT);
}

/* Getting posts data */
if(!empty($_GET) && isset($_GET['getposts']))
{
    $from = 0;
    $to = time();
    if(isset($_GET['from']) && is_int($_GET['from'])){
        $from = $_GET['from'];
    }
    if(isset($_GET['to']) && is_int($_GET['to'])){
        $to = $_GET['to'];
    }

    $postsdata = $posts->getPosts($from, $to);
    foreach ($postsdata as $key => $value) {
        $comments = count($posts->getPostComments($value['PostID']));
        $datas[$key] = [
            'postid' => $value['PostID'],
            'posttitle' => $value['PostTitle'],
            'postdate' => $value['PostDate'],
            'author' => $value['OwnerID'], /* I will soon get name of the author */
            'commentscount' => $comments
        ];
    }
    printJson($datas);
}

/* Getting comments data */
if(!empty($_GET) && isset($_GET['getcomments']) && is_int($_GET['postid']))
{
    $comments = $posts->getPostComments($_GET['postid']);
    printJson($comments);
}