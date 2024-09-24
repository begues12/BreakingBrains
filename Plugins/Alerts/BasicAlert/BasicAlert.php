<?php

namespace Plugins\Alerts\BasicAlert;

use Engine\Core\HTML;
use Plugins\Icons\FontAwesome\Icon;

class BasicAlert extends HTML
{
    private $alertContainer;
    private $icon;
    private $label;
    private $text;

    public function __construct(bool $visible = false, string $alertType = 'success', $icon = 'fa-check-circle')
    {
        parent::__construct('div');
        $this->setId('basic-alert');
        $this->setClasses([
            'alert-container',
            'basic-alert'
        ]);
        $this->setStyle(['visibility' => $visible ? 'visible' : 'hidden']);
        $this->setCssFile   ('Plugins/Alerts/BasicAlert/Css/BasicAlert.css');
        $this->setJsFile('Plugins/Alerts/BasicAlert/Js/BasicAlert.js');

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
        
        $this->compile();
    }

    private function compile()
    {
        // No es necesario agregar más contenido aquí, ya que el mensaje de éxito se establece dinámicamente.
        $this->alertContainer->addElements([$this->icon, $this->label]);
        $this->label->addElement($this->text);
        $this->addElement($this->alertContainer);

    }

    public function setMessage(string $message)
    {
        $this->text->setText($message);
    }

}

?>
