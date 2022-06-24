<?php
require_once('../vendor/autoload.php');
$loader = new Twig\Loader\FilesystemLoader(dirname(__DIR__) . '/templates');
$view = new \Twig\Environment($loader);
if (isset($_GET['id'])) {
    $post = \Post\Post::getByID($_GET['id']);
    if ($post) {
        echo $view->render('post_update.html.twig', ['post' => $post]);

        if (isset($_POST['title'])) {
            $post->setPostTitle($_POST['title']);
            $post->setPostContent($_POST['content']);
            if ($post->save()) {
                echo '<h1>The data is successfully changed</h1>';
                echo '<a href="index.php">Posts</a>';
            } else {
                echo '<h1>Something went wrong</h1>';
                echo '<a href="index.php">Posts</a>';
            }
        }
    } else {
        echo '<h1>An error has occurred. ID is not found</h1>';
        echo '<a href="index.php">Posts</a>';
    }
}
