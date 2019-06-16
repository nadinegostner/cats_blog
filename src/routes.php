<?php

$app->get("/", "App\\Controllers\\ChronikController:chronik");

$app->get("/rechronik", "App\\Controllers\\ChronikController:chronik");

$app->get("/dashboard", "App\\Controllers\\DashboardController:dashboard");

$app->get("/newsletter", "App\\Controllers\\NewsletterController:newsletter");

$app->get("/profil", "App\\Controllers\\ProfilController:profil");

$app->get("/logout", "App\\Controllers\\LoginController:logout");

$app->post("/chronik", "App\\Controllers\\ChronikController:postErstellen");

//alte routen

$app->post("/clipboard", "App\\Controllers\\ClipboardController:create");

$app->get("/clipboard/{token}", "App\\Controllers\\ClipboardController:get");

$app->map(["GET","POST"], "/login", "App\\Controllers\\LoginController:login");



$app->map(["GET","POST"], "/register", "App\\Controllers\\LoginController:register");





