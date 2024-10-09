<?php

namespace Plugins\Alerts\LinkAlert;

use Engine\Core\HTML;
use Plugins\Icons\FontAwesome\Icon;

class LinkAlert extends HTML
{
    private $alertContainer;
    private $icon;
    private $label;
    private $text;
    private $i;
    private $a;

    public function __construct(bool $visible = false, string $alertType = 'success', $icon = 'fa-check-circle')
    {
        parent::__construct('div');
        $this->setId('basic-alert');
        $this->setClasses([
            'alert-container',
            'basic-alert'
        ]);
        $this->setStyle(['visibility' => $visible ? 'visible' : 'hidden']);
        $this->setCssFile('Plugins/Alerts/LinkAlert/Css/LinkAlert.css');
        $this->setJsFile('Plugins/Alerts/LinkAlert/Js/LinkAlert.js');

        // Alerta de éxito
        $this->alertContainer = new HTML('div');
        $this->alertContainer->setClasses([
            'alert',
            'alert-' . $alertType,
            'alert-dismissible',
            'fade',
            'show',
            'alert-basic'
        ]);
        $this->alertContainer->setAttribute('role', 'alert');

        $this->icon = new Icon($icon, '1x', '', ['mr-2']);

        $this->label = new HTML('label');
        $this->label->setClasses([
            'mr-2',
            'vertical-align-middle'
        ]);

        $this->text = new HTML('strong');

        $this->a = new HTML('a');
        $this->a->setAttribute('href', '#');
        $this->a->setClasses(['alert-link']);
        $this->a->addElement('Click here to go to the link');

        $this->i = new Icon('fa-times', '1x', '', ['close']);

        $this->compile();
    }

    private function compile()
    {
        // No es necesario agregar más contenido aquí, ya que el mensaje de éxito se establece dinámicamente.
        $this->alertContainer->addElements([$this->icon, $this->label, $this->a]);
        $this->label->addElement($this->text);

        $this->alertContainer->addElement($this->a);
        $this->alertContainer->addElement($this->i);


        $this->addElement($this->alertContainer);

    }

    public function setMessage(string $message)
    {
        $this->text->setText($message);
    }
    
    public function setLink(string $link)
    {
        $this->a->setAttribute('href', $link);
    }

}

?>
