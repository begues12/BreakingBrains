<?php

namespace MVC\Views\FrameworkEditor\Partial\Database;

use Engine\Core\HTML;
use Plugins\Icons\FontAwesome\Icon;

class ConectBDForm extends HTML
{
    private $divContainer;
    private $divUsername;
    private $inputUsername;
    private $divPassword;
    private $inputPassword;
    private $divHost;
    private $inputHost;
    private $divPort;
    private $inputPort;
    private $divButtons;
    private $inputSubmit;
    private $iInputSubmit;
    private $labelSubmit;

    private $username;
    private $password;
    private $host;
    private $port;

    public function __construct(string $username = '', string $password = '', string $host = '', string $port = '')
    {
        parent::__construct('form');
        $this->setId('formBd');

        $this->setAttributes([
            'method'    => 'post',
            'action'    => '?Ctrl=FrameworkEditor&Do=Database&Action=autenticateSQL'
        ]);

        $this->username = $username;
        $this->password = $password;
        $this->host = $host;
        $this->port = $port;
        
        $this->divContainer = new HTML('div');
        $this->divContainer->setClasses([
            'row',
            'd-flex',
            'justify-content-between',
            'align-items-center',
        ]);

        $this->divUsername = new HTML('div');
        $this->divUsername->setClasses(['form-group', 'col-3', 'text-center']);

        $this->inputUsername = new HTML('input');
        $this->inputUsername->setAttributes([
            'type'          => 'text',
            'name'          => 'username',
            'placeholder'   => 'Username',
            'value'         =>  $this->username
        ]);
        $this->inputUsername->setClasses(['form-control']);

        $this->divPassword = new HTML('div');
        $this->divPassword->setClasses(['form-group', 'col-3', 'text-center']);
        
        $this->inputPassword = new HTML('input');
        $this->inputPassword->setAttributes([
            'type'          => 'password',
            'name'          => 'password',
            'placeholder'   => 'Password',
            'value'         =>  $this->password
        ]);
        $this->inputPassword->setClasses(['form-control']);

        $this->divHost = new HTML('div');
        $this->divHost->setClasses(['form-group', 'col-2', 'text-center']);

        $this->inputHost = new HTML('input');
        $this->inputHost->setAttributes([
            'type'          => 'text',
            'name'          => 'host',
            'placeholder'   => 'Host',
            'value'         =>  $this->host
        ]);
        $this->inputHost->setClasses(['form-control']);

        $this->divPort = new HTML('div');
        $this->divPort->setClasses(['form-group', 'col-2', 'text-center']);

        $this->inputPort = new HTML('input');
        $this->inputPort->setAttributes([
            'type'          => 'text',
            'name'          => 'port',
            'placeholder'   => 'Port',
            'value'         =>  $this->port
        ]);
        $this->inputPort->setClasses(['form-control']);

        $this->divButtons = new HTML('div');
        $this->divButtons->setClasses(['form-group', 'col-2', 'text-center']);

        $this->inputSubmit = new HTML('button');
        $this->inputSubmit->setId('btnSubmit');
        $this->inputSubmit->setAttribute('type', 'submit');
        $this->inputSubmit->setClasses(['btn', 'btn-primary']);

        $this->iInputSubmit = new Icon('fa-plug', '1x', 'white', ['mr-2']);

        $this->labelSubmit = new HTML('label');
        $this->labelSubmit->setText('Connect');
        $this->labelSubmit->setClasses([
            'text-white',
        ]);

        $this->addElement($this->divContainer);

        $this->divContainer->addElements([
            $this->divUsername,
            $this->divPassword,
            $this->divHost,
            $this->divPort,
            $this->divButtons
        ]);

        $this->divUsername->addElements([$this->inputUsername]);

        $this->divPassword->addElements([$this->inputPassword]);

        $this->divHost->addElements([$this->inputHost]);

        $this->divPort->addElements([$this->inputPort]);
        
        $this->divButtons->addElements([$this->inputSubmit]);

        $this->inputSubmit->addElements([$this->iInputSubmit, $this->labelSubmit]);
       
    }

}

?>