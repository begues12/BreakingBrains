<?php
namespace MVC\Controllers\Index;

use Engine\Core\IController;

class Index extends IController
{

    function __construct()
    {
        parent::__construct();
    }

    public function prepare()
    {
        //Read ViewCode and put into a variable   
        $this->setVar('CtrlCode',str_replace("<?php", "&#60;?php", file_get_contents($this->getCtrlPath())));
        $this->setVar('ViewCode',str_replace("<?php", "&#60;?php", file_get_contents($this->getViewPath())));
    }

    public function execute()
    {
    }

    public function finish()
    {   
    }
}

?>