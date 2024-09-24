<?php

namespace MVC\Views\FrameworkEditor;

use Engine\Core\IView;
use Engine\Core\HTML;

class Pages extends IView{

    private $h1Title;

    public function prepare()
    {    
        $this->setHeader(new \Engine\Utils\EditorHeader());
    }

    public function createObjects()
    {   
        $this->h1Title = new HTML('h1');
        $this->h1Title->setText('Pages');
    }

    public function compile()
    {
        $this->addBody($this->h1Title);
    }

}

?>