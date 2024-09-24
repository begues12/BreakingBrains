<?php

namespace MVC\Views\Documentation;

use Engine\Core\IView;
use Engine\Core\HTML;
use Plugins\Sidebars\BasicCollapsibleSidebar;

class Index extends IView{

    private $h2Title;
    
    private $sidebar;

    public function prepare()
    {
    }

    public function createObjects()
    {
        $this->h2Title = new HTML('h2');
        $this->h2Title->setText('Documentation');
        $this->h2Title->setClasses([
            'text-dark',
            'mt-3'
        ]);

        $this->sidebar = new BasicCollapsibleSidebar();

    }

    public function compile()
    {
        $this->addBody($this->h2Title);

        $this->addBody($this->sidebar);
    }

}

?>