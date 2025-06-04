<?php
require_once("Configuration.php");
$configuration = new Configuration();
$router = $configuration->getRouter();


$controller = $_GET["controller"] ?? "Home";
$method = $_GET["method"] ?? "show";

$router->go(
//    $_GET["controller"],
//    $_GET["method"]
    $controller,
    $method
);