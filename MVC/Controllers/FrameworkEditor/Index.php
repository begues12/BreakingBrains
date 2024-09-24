<?php
namespace MVC\Controllers\FrameworkEditor;

use Engine\Core\IController;

class Index extends IController
{

    function __construct()
    {
        parent::__construct();
        $this->BlockByIp();
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