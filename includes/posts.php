<?php
/**
 * Uses posts.class.php to get posts datas
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */
require('class/posts.class.php');
require('../config.php');
$posts = new Posts($ghost, $gname, $guser, $gpass);
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
    /* Printing this in JSON format, to allow JS & PHP scripts to parse easily this data */
    header('Content-Type: application/json');
    echo json_encode($datas, JSON_PRETTY_PRINT);
}