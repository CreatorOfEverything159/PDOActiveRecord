<?php
require_once('../vendor/autoload.php');

$is_remove = \Post\Post::remove($_GET['id']);
if ($is_remove) {
    echo '<h1>Record deleted</h1>';
    echo '<a href="index.php">Posts</a>';
} else {
    echo '<h1>Some error</h1>';
    echo '<a href="index.php">Posts</a>';
}