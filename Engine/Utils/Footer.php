<?php

namespace Engine\Utils;

use Plugins\Footers\BasicFooter\BasicFooter;

use Engine\Core\HTML;
class Footer extends BasicFooter
{

    private $divContent;

    // Create HTML Tags ${tag}Name
    private $labelTitle;

    public function __construct()
    {
        parent::__construct();
    
        $this->createObjects();
        $this->compile();
    }

    public function createObjects()
    {

        $this->divContent = new HTML('div');

        $this->labelTitle = new HTML('label');
        $this->labelTitle->setClass('h5');
        $this->labelTitle->setText('GitHub: <a href="https://github.com/begues12/fountain" target="_blank">Fountain Framework</a>'); 

    }

    public function compile()
    {
        $this->addElement($this->divContent);
        $this->divContent->addElement($this->labelTitle);
    }
}

?>