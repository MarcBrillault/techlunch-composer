<?php

require_once __DIR__ . '/vendor/autoload.php';

if ($_SERVER['REQUEST_URI'] === '/') {
    // Gallery
    $images = (new \Techlunch\Gallery())->list();

    // Markdown
    $markdown  = file_get_contents(__DIR__ . '/resources/text.md');
    $parsedown = new ParsedownExtra();
    $text      = $parsedown->text($markdown);

    // Twig init
    $loader = new Twig_Loader_Filesystem(__DIR__ . '/resources/templates/');
    $twig   = new Twig_Environment($loader);

    // Twig display
    $template = $twig->load('index.html');
    die($template->render([
        'images' => $images,
        'text'   => $text,
    ]));
}

if (preg_match('#^/(image|thumbnail)-([0-9]+)\.jpg$#', $_SERVER['REQUEST_URI'], $matches)) {
    list(, $type, $imageNumber) = $matches;
    $image = new \Techlunch\Image($imageNumber, $type === 'thumbnail');
    die($image->render());
}