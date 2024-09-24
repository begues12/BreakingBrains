<?php

namespace Plugins\Footers\BasicFooter;

use Engine\Core\HTML;

class BasicFooter extends HTML
{
    public function __construct()
    {
        parent::__construct('footer');
        $this->setId('basic-footer');
        $this->setClasses([
            'container-fluid',
            'mt-2',
            'border-top',
            'w-100',
            'text-center',
            'p-1'
        ]);
        $this->setCssFile('Plugins/Footers/BasicFooter/Css/BasicFooter.css');
        $this->setJsFile('Plugins/Footers/BasicFooter/Js/BasicFooter.js');
    }

    public function render()
    {
    }
}

?>