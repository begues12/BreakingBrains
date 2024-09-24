<?php

namespace MVC\Views\Photos;

use Engine\Core\IView;
use Engine\Utils\Header;
use Engine\Core\HTML;
use Engine\Utils\Head;
use Plugins\Wave\BasicWave\BasicWave;
use Plugins\Icons\FontAwesome\LinkIcon;

class Index extends IView{

    private $div_title;
    private $img_breaking;

    public function prepare()
    {
        $this->setHeader(new Header());
    }

    public function createObjects()
    {
        
        $this->div_title = new HTML('div');
        $this->div_title->setClasses([
            'container',
            'text-left'
        ]);

        $this->img_breaking = new HTML('img');
        $this->img_breaking->setClasses([
            'ligthing-icon'
        ]);
        $this->img_breaking->setAttributes([
            'src' => 'Assets/Images/BreakingBrains/breakingbrains_transparent.png',
            'alt' => 'Breaking Brains',
            'width' => '250px',
            'height' => '250px'
        ]);

    


    }

    public function compile()
    {
        $this->addBody($this->div_title);
        $this->div_title->addElement($this->img_breaking);
    }

}

?>