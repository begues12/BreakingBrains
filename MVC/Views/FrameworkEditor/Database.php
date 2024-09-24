<?php

namespace MVC\Views\FrameworkEditor;

use Engine\Core\IView;
use Engine\Core\HTML;
use Plugins\Icons\FontAwesome\Icon;
use MVC\Views\FrameworkEditor\Partial\Database\ConectBDForm;

class Database extends IView{

    private $h1Title;
    private $divContainerBd;
    private $iconNotConnection;
    private $labelNotConnection;
    private $aGoToConfig;

    public function prepare()
    {    
        $this->setHeader(new \Engine\Utils\EditorHeader());
    }

    public function createObjects()
    {   

        $this->h1Title = new HTML('h1');
        $this->h1Title->setText('Database');

        $this->divContainerBd = new HTML('div');
        $this->divContainerBd->setId('divContainerBd');
        $this->divContainerBd->setStyle([
            'overflow-y' => 'auto',
            'height' => 'calc(100vh - 190px)'
        ]);
        $this->divContainerBd->setClasses([
            'container',
            'w-100',
        ]);

        $this->iconNotConnection = new Icon('fa-exclamation-triangle');
        $this->iconNotConnection->setClasses([
            'text-danger',
            'font-weight-bold',
            'text-center',
            'w-100'
        ]);

        $this->labelNotConnection = new HTML('label');
        $this->labelNotConnection->setText('Not connected to the database');
        $this->labelNotConnection->setClasses([
            'text-danger',
            'font-weight-bold',
            'text-center',
            'w-100'
        ]);

        $this->aGoToConfig = new HTML('a');
        $this->aGoToConfig->setText('Configure connection');
        $this->aGoToConfig->setAttributes([
            'href' => '?Ctrl=FrameworkEditor&Do=Configuration',
        ]);
        $this->aGoToConfig->setClasses([
            'font-weight-bold',
            'text-center',
            'w-100'
        ]);
        
    }

    public function compile()
    {

        $this->addBody($this->h1Title);

        $this->addBody($this->divContainerBd);

        $this->divContainerBd->addElements([
            $this->iconNotConnection,
            $this->labelNotConnection,
            $this->aGoToConfig
        ]);

    }

}
