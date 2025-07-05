<?php
require_once("Configuration.php");
$configuration = new Configuration();
$router = $configuration->getRouter();


$controller = $_GET["controller"] ?? "Home";
$method = $_GET["method"] ?? "show";
$params = $_GET["params"] ?? "";

$configuration->validateSession($controller);
$configuration->validateRole($controller);

$router->go(
    $controller,
    $method,
    $params
);

