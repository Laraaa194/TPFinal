<?php

class Router
{
    private $defaultController;
    private $defaultMethod;
    private $configuration;

    public function __construct($defaultController, $defaultMethod, $configuration)
    {
        $this->defaultController = $defaultController;
        $this->defaultMethod = $defaultMethod;
        $this->configuration = $configuration;
    }

    public function go($controllerName, $methodName,  $params = null)
    {
        $controller = $this->getControllerFrom($controllerName);
        $this->executeMethodFromController($controller, $methodName, $params);
    }

    private function getControllerFrom($controllerName)
    {

        $controllerName = 'get' . ucfirst($controllerName) . 'Controller';
        $validController = method_exists($this->configuration, $controllerName) ? $controllerName : $this->defaultController;
        return call_user_func(array($this->configuration, $validController));
    }

    private function executeMethodFromController($controller, $method, $params = null)
    {
        $validMethod = method_exists($controller, $method) ? $method : $this->defaultMethod;

        if ($params !== null && $params !== '') {
            call_user_func_array(array($controller, $validMethod), [$params]);
        } else {
            call_user_func(array($controller, $validMethod));
        }
    }
}