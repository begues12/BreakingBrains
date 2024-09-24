<?php

namespace MVC\Views\FrameworkEditor;

use Engine\Core\IView;
use Engine\Core\HTML;

class Configuration extends IView{

    private $config;

    private $h1Title;
    private $divConfig;

    public function prepare()
    {    
        $this->setHeader(new \Engine\Utils\EditorHeader());
        $this->config = $this->getVar('config');
    }

    public function createObjects()
    {   
        $this->h1Title = new HTML('h1');
        $this->h1Title->setText('Configuration');

        $this->divConfig = new HTML('div');
        $this->divConfig->setClasses(['container-fluid']);//'container-fluid', 'p-5', 'w-75

    }

    public function compile()
    {
        $this->addBody($this->h1Title);

        $this->divConfig->addElement($this->generalConfig());
        $this->divConfig->addElement($this->databaseConfig());

        $this->addBody($this->divConfig);
    }

    private function generalConfig(): HTML
    {
        return new HTML('div');
    }

    private function databaseConfig(): HTML
    {
        $div = new HTML('div');
        $div->setStyle(['max-width' => '500px', 'min-width' => '300px']);//'max-width' => '500px', 'min-width' => '300px

        $title = new HTML('h3');
        $title->setText('Database');

        $InputHost = new HTML('input');
        $InputHost->setClass('form-control');
        $InputHost->setAttribute('type', 'text');
        $InputHost->setAttribute('name', 'database-host');
        $InputHost->setAttribute('value', $this->config['database']['host']);

        $divInputHost = $this->createGroupInput('Host', $InputHost);

        $InputUser = new HTML('input');
        $InputUser->setClass('form-control');
        $InputUser->setAttribute('type', 'text');
        $InputUser->setAttribute('name', 'database-user');
        $InputUser->setAttribute('value', $this->config['database']['username']);

        $divInputUser = $this->createGroupInput('User', $InputUser);

        $InputPassword = new HTML('input');
        $InputPassword->setClass('form-control');
        $InputPassword->setAttribute('type', 'password');
        $InputPassword->setAttribute('name', 'database-password');
        $InputPassword->setAttribute('value', $this->config['database']['password']);

        $divInputPassword = $this->createGroupInput('Password', $InputPassword);

        $InputPort = new HTML('input');
        $InputPort->setClass('form-control');
        $InputPort->setAttribute('type', 'number');
        $InputPort->setAttribute('name', 'database-port');
        $InputPort->setAttribute('value', $this->config['database']['port']);

        $divInputPort = $this->createGroupInput('Port', $InputPort);

        
        $div->addElements([$title, $divInputHost, $divInputUser, $divInputPassword, $divInputPort]);

        return $div;
    }

    private function createGroupInput(string $label, HTML $input) : HTML
    {
        $div = new HTML('div');
        $div->setClasses(['input-group', 'mb-3']);//'input-group-prepend

        $divLabel = new HTML('div');
        $divLabel->setClass('input-group-prepend');
        $divLabel->setStyle(['width' => '100px']);//['width' => '200px'

        $labelInput = new HTML('span');
        $labelInput->setClass('input-group-text');

        $labelInput->setText($label);

        $divLabel->addElement($labelInput);

        $div->addElement($divLabel);

        $div->addElement($input);

        return $div;

    }

}

?>