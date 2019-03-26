<?php
/**
 * index.view.php
 * HTML/PHP Code for displaying posts
 */
$data = file_get_contents('../blog_data.php?getposts');
foreach ($data as $key => $value) {
?>
    
<?php
    } /* end foreach */
?>