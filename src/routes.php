<?php

$app->get("/", "App\\Controllers\\ClipboardController:index");

$app->post("/clipboard", "App\\Controllers\\ClipboardController:create");

$app->get("/clipboard/{token}", "App\\Controllers\\ClipboardController:get");

$app->map(["GET","POST"], "/login", "App\\Controllers\\LoginController:login");

$app->get("/logout", "App\\Controllers\\LoginController:logout");

$app->map(["GET","POST"], "/register", "App\\Controllers\\LoginController:register");





