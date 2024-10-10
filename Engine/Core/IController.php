<?php

namespace Engine\Core;

use Engine\Config;
abstract class IController
{   

    private $CtrlPath = '';
    private $ViewPath = '';
    private $vars = [];
    private $post = [];
    private $get = [];
    private $bloquedByIp = false;
    private $config = null;

    public function __construct()
    {
        $this->cleanRequest();
    }

    public function setViewPath($path)
    {
        $this->ViewPath = $path.".php";
    }

    public function getViewPath()
    {
        return $this->ViewPath;
    }

    public function setCtrlPath($path)
    {
        $this->CtrlPath = $path.".php";
    }

    public function getCtrlPath()
    {
        return $this->CtrlPath;
    }

    public function setVars($vars)
    {
        $this->vars = $vars;
    }

    public function getVars()
    {
        return $this->vars;
    }

    public function setVar($name, $value)
    {
        $this->vars[$name] = $value;
    }

    public function getVar($name)
    {
        if (!isset($this->vars[$name])) {
            echo "Error: Variable {$name} not found";
        }else{
            return $this->vars[$name];
        }

        return false;
    }

    public function post(string $name=''): mixed
    {
        if ($name == '') {
            return $this->post;
        }

        if (isset($this->post[$name])) {
            return $this->post[$name];
        }

        return '';
    }

    public function get(string $name=''): mixed
    {
        if ($name == '') {
            return $this->get;
        }

        if (isset($this->get[$name])) {
            return $this->get[$name];
        }

        return '';
    }

    public function payload(string $name=''): mixed
    {
        $payload = json_decode(file_get_contents('php://input'), true);

        if ($name == '') {
            return $payload;
        }

        if (isset($payload[$name])) {
            return $payload[$name];
        }

        return '';
    }

    public function BlockByIp()
    {
        $this->bloquedByIp = true;
    }

    public function isBlockedByIp()
    {
        $this->config = new Config();

        if (in_array($_SERVER['REMOTE_ADDR'], $this->config->get('ipEditor')['whitelist']) || !$this->bloquedByIp) {
            return false;
        }else{
            return true;
        }

    }

    public function isIpInWhitelist()
    {
        $this->config = new Config();

        if (in_array($_SERVER['REMOTE_ADDR'], $this->config->get('ipEditor')['whitelist'])) {
            return true;
        }else{
            return false;
        } 
    }

    private function cleanRequest()
    {
        $cleanedPost    = [];
        $cleanedGet     = [];
    
        foreach ($_POST as $key => $value) {
            $cleanedPost[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
    
        foreach ($_GET as $key => $value) {
            $cleanedGet[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        
        $this->post = $cleanedPost;
        $this->get = $cleanedGet;
    }

    public function getOtherView(IView $view)
    {
        $view->prepare();
        $view->createObjects();
        $view->compile();
        $view->compileView();
        return $view->toString();
    }

    public function setCookie($name, $value, $time = 3600)
    {
        setcookie($name, $value, time() + $time, '/');
    }

    public function getCookie($name)
    {
        if (isset($_COOKIE[$name])) {
            return $_COOKIE[$name];
        }

        return '';
    }

    abstract public function prepare();

    abstract public function execute();

    abstract public function finish();

}

?>