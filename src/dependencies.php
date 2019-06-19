<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['view'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\Twig($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['session'] = function ($c) {
    return new \App\Helper\Session();
};

// clipboard controller
$container["App\\Controllers\\ClipboardController"] = function($c) {
    $view = $c->get('view');
    $clipboard = $c->get('clipboard');
    return new \App\Controllers\ClipboardController($view, $clipboard);
};

// Login controller
$container["App\\Controllers\\LoginController"] = function($c) {
    $view = $c->get('view');
    $user = $c->get('user');
    $session = $c->get('session');
    return new \App\Controllers\LoginController($view, $user, $session);
};

// clipboard model
$container['clipboard'] = function($c) {
    return new \App\Models\Clipboard();
};

// user models
$container['user'] = function($c) {
    return new \App\Models\User();
};

// chronik model -> wo beiträge erstellt werden
$container['chronik'] = function($c){
    return new \App\Models\Chronik();
};

// http basic middleware
$container['HttpBasicMiddleware'] = function($c) {
    return new \App\Middlewares\HttpBasicMiddleware($c->get('user'), $c->get('logger'));
};

// WebForm middleware
$container['WebFormMiddleware'] = function($c) {
    return new \App\Middlewares\WebFormMiddleware($c->get('user'), $c->get('logger'), $c->get('session'));
};

$container["App\\Controllers\\ChronikController"] = function($c) {
    $view = $c->get('view');
    $chronik = $c->get('chronik');

    return new \App\Controllers\ChronikController($view, $chronik);
};

$container["App\\Controllers\\DashboardController"] = function($c) {
    $view = $c->get('view');
    $chronik = $c->get('chronik');

    return new \App\Controllers\DashboardController($view, $chronik);
};

$container["App\\Controllers\\NewsletterController"] = function($c) {
    $view = $c->get('view');

    return new \App\Controllers\NewsletterController($view);
};

$container["App\\Controllers\\ProfileController"] = function($c) {
    $view = $c->get('view');
    $user = $c->get('user');

    return new \App\Controllers\ProfileController($view, $user);
};