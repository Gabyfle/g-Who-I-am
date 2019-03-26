<?php
/**
 * Gets posts from database
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */

class Posts
{
    private $pdo;
    /**
     * construct
     * Returns a PDO object after connecting to the database
     */
    function __construct($dbhost, $dbname, $dbuser, $dbpass)
    {
        try {
            $db = new PDO('mysql:host='. $dbhost .';dbname=' . $dbname . '', $dbuser, $dbpass);
        } catch (\Throwable $th) {
            throw $th;        
        }

        $this->pdo = $db;
    }
    /**
     * getPosts
     * Gets every posts from a date to another
     */
    public function getPosts($from = 0, $to = 'time')
    {  
        if ($to === 'time') { $to = time(); }
        $query = $this->pdo->prepare('SELECT * FROM posts WHERE PostDate BETWEEN FROM_UNIXTIME(:pfrom) AND FROM_UNIXTIME(:pto)');
        $query->execute([
            ':pfrom' => $from,
            ':pto' => $to
        ]);
        
        return $query->fetchAll();
    }
    /**
     * getPostContents($postID)
     * Gets contents of an Post, identified by his ID
     */
    public function getPostContents($postID)
    {
        $query = $this->pdo->prepare('SELECT * FROM postsdetails WHERE PostID = :postid');
        $query->execute([
            ':postid' => $postID
        ]);

        return $query->fetchAll();
    }
    /**
     * getPostComments($postID)
     * Gets comments linked to a specific post
     */
    public function getPostComments($postID)
    {
        $query = $this->pdo->prepare('SELECT * FROM comments WHERE PostID = :postid');
        $query->execute([
            ':postid' => $postID
        ]);

        return $query->fetchAll();      
    }
}