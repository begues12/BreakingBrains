<?php

namespace Engine\Core;

use Engine\Core\HTML;
use Engine\Utils\Head;
use Engine\Utils\Header;
use Engine\Utils\Footer;
use Plugins\Loading\BasicLoading\BasicLoading;
use Plugins\Alerts\BasicConfirm\BasicConfirmOk;
use Engine\Config;

abstract class IView extends HTML
{
    private $head;
    private $loadingSpinner;
    private $confirmOk;
    private $body;
    private $header;
    private $main;
    private $footer;
    private $vars = array();
    private $editorButton;
    private $config;

    public function __construct()
    {
        parent::__construct('html');
        
        $this->config = new Config();

        $this->head = new Head();
        $this->loadingSpinner = new BasicLoading(false);
        $this->confirmOk = new BasicConfirmOk(false);
        $this->body = new HTML('body');
        $this->main = new HTML('main');
        $this->footer = new Footer();

        $this->body->setAttribute('style', 'height: 100%;');
        $this->body->setClass('bg-dark text-light');

        $this->main->setId('main-content');
        $this->main->setClass('p-3');
    }

    public function setVars($vars)
    {
        $this->vars = $vars;
    }

    public function getVars()
    {
        return $this->vars;
    }

    public function getVar($name)
    {
        if (!isset($this->vars[$name])) {
            echo "Error: Variable {$name} not found";
        }else{
            return $this->vars[$name];
        }

        return false;
    }

    abstract public function createObjects();

    abstract public function prepare();

    abstract public function compile();

    function setHead(HTML $element)
    {
        $this->head = $element;
    }

    function setHeader(HTML $element)
    {
        $this->header = $element;
    }

    function addHead(HTML $element)
    {
        $this->head->addElement($element);
    }

    function addBody(HTML $element)
    {
        $this->main->addElement($element);
    }

    function renderHead()
    {
        $this->head->render();
    }

    function renderBody()
    {
        $this->body->render();
    }

    function renderFooter()
    {
        $this->footer->render();
    }

    function compileView()
    {
        if ($this->head){
            $this->addElement($this->head);
        }

        if ($this->header){
            $this->addElement($this->header);
        }
        
        $this->addElement($this->loadingSpinner);
        $this->addElement($this->confirmOk);
        $this->addElement($this->body);
        

        $this->body->addElement($this->main);


        if (in_array($_SERVER['REMOTE_ADDR'], $this->config->get('ipEditor')['whitelist'])) {
            // $this->body->addElement($this->editorButton);
        }
    }

    function isNotAPage()
    {
        $this->head = null;
        $this->header = null;
        $this->footer = null;
    }

}

?>