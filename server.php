<?php

require_once __DIR__ . '/vendor/autoload.php';

if ($_SERVER['REQUEST_URI'] === '/') {
    $images = (new \Techlunch\Gallery())->list();

    $loader = new Twig_Loader_Filesystem(__DIR__ . '/resources/templates/');
    $twig   = new Twig_Environment($loader);

    $template = $twig->load('index.html');
    die($template->render([
        'images' => $images,
    ]));
}

if (preg_match('#^/(image|thumbnail)-([0-9]+)\.jpg$#', $_SERVER['REQUEST_URI'], $matches)) {
    list(, $type, $imageNumber) = $matches;
    $image = new \Techlunch\Image($imageNumber, $type === 'thumbnail');
    die($image->render());
}