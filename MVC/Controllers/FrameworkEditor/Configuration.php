<?php
namespace MVC\Controllers\FrameworkEditor;

use Engine\Core\IController;

class Configuration extends IController
{

    private $config;

    function __construct()
    {
        parent::__construct();
        $this->BlockByIp();

        $this->config = new \Engine\Config();
        
        $this->setVar('config', $this->config->getAll());
    }

    public function prepare()
    {
    }

    public function execute()
    {
    }

    public function finish()
    {   
    }
}

?>