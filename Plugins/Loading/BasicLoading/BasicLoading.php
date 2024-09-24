<?php

namespace Plugins\Loading\BasicLoading;

use Engine\Core\HTML;

class BasicLoading extends HTML
{
    private $divLoading;
    private $divDark;

    public function __construct(bool $visible = false)
    {
        parent::__construct('div');
        $this->setAttribute('id', 'loading-container');
        $this->setAttribute('class', 'loading');
        $this->setStyle(['display' => $visible ? 'block' : 'none']);

        // Agregar la referencia al archivo CSS
        $this->setCssFile('Plugins\Loading\BasicLoading\Css\BasicLoading.css');
        $this->setJsFile('Plugins/Loading/BasicLoading/Js/BasicLoading.js');
        
        $this->divDark = new HTML('div');
        $this->divDark->setId('loading-bg');

        $this->divLoading = new HTML('img');
        $this->divLoading->setId('loading');
        $this->divLoading->setAttribute('src', 'https://cdn.pixabay.com/animation/2022/07/31/05/09/05-09-47-978_512.gif');

        $this->compile();
    }

    private function compile()
    {
        $this->divDark->addElement($this->divLoading);
        $this->addElement($this->divDark);
    }
}

?>
