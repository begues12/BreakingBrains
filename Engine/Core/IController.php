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

    public function post($name)
    {
        if (isset($this->post[$name])) {
            return $this->post[$name];
        }

        return '';
    }

    public function get($name)
    {
        if (isset($this->get[$name])) {
            return $this->get[$name];
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
        // Inicializa arrays vacíos para las entradas limpias.
        $cleanedPost = [];
        $cleanedGet = [];
    
        // Limpieza de datos POST.
        foreach ($_POST as $key => $value) {
            // Utiliza la función htmlspecialchars para escapar caracteres especiales en valores POST.
            $cleanedPost[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
    
        // Limpieza de datos GET.
        foreach ($_GET as $key => $value) {
            // Utiliza la función htmlspecialchars para escapar caracteres especiales en valores GET.
            $cleanedGet[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
    
        // Ahora, los datos POST y GET limpios están disponibles en $cleanedPost y $cleanedGet.
    
        // Puedes asignar estos datos limpios a las propiedades de tu objeto si es necesario.
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

    abstract public function prepare();

    abstract public function execute();

    abstract public function finish();

}

?>