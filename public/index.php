<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

use Dotenv\Dotenv;
use Post\Post;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$loader = new FilesystemLoader(dirname(__DIR__).'/templates');
$view = new Environment($loader);

$posts = Post::getAll();

echo $view->render('posts.html.twig', ['posts' => $posts]);
