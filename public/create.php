<?php
require_once('../vendor/autoload.php');
$loader = new Twig\Loader\FilesystemLoader(dirname(__DIR__) . '/templates');
$view = new \Twig\Environment($loader);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo $view->render('post_create.html.twig');
} else {
    $post = new \Post\Post($_POST['title'], $_POST['content']);
    if ($post->add()) {
        echo '<h1>Record added</h1>';
        echo '<a href="index.php">Posts</a>';
    } else {
        echo '<h1>Some error</h1>';
        echo '<a href="index.php">Posts</a>';
    }
}