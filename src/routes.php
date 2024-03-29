<?php

$app->get("/", "App\\Controllers\\ChronikController:chronik");

$app->get("/rechronik", "App\\Controllers\\ChronikController:chronik");

$app->get("/dashboard", "App\\Controllers\\DashboardController:dashboard");

$app->map(["GET","POST"], "/editPost", "App\\Controllers\\ChronikController:postBearbeiten");

$app->post("/deletePost", "App\\Controllers\\ChronikController:postLoeschen");

$app->get("/newsletter", "App\\Controllers\\NewsletterController:newsletter");

$app->get("/profile", "App\\Controllers\\ProfileController:profil");

$app->get("/logout", "App\\Controllers\\LoginController:logout");

$app->post("/chronik", "App\\Controllers\\ChronikController:postErstellen");

$app->post("/subscribe", "App\\Controllers\\NewsletterController:subscribe");

$app->map(["POST","GET"],"/editpostpage", "App\\Controllers\\DashboardController:editpostpage");


$app->map(["GET","POST"],"/update", "App\\Controllers\\ProfileController:update");

$app->map(["GET", "POST"], "/update-p", "App\\Controllers\\ProfileController:updatePassword");


$app->map(["GET","POST"], "/login", "App\\Controllers\\LoginController:login");

$app->map(["GET","POST"], "/register", "App\\Controllers\\LoginController:register");





