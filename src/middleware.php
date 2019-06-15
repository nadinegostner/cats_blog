<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

//$app->add($container->get("HttpBasicMiddleware"));
$app->add($container->get("WebFormMiddleware"));
