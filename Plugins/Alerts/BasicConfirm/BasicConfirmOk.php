<?php

namespace Plugins\Alerts\BasicConfirm;

use Engine\Core\HTML;

class BasicConfirmOk extends HTML
{
    private $modalBackdrop; // Fondo negro con opacidad
    private $modal;
    private $modalDialog;
    private $modalContent;
    private $modalHeader;
    private $modalTitle;
    private $modalBody;
    private $modalFooter;
    private $tickIcon;
    private $crossIcon;

    public function __construct(bool $visible = false)
    {
        parent::__construct('div');
        $this->setAttribute('id', 'confirm-container');
        $this->setAttribute('class', 'modal fade');
        $this->setAttribute('tabindex', '-1');
        $this->setAttribute('role', 'dialog');
        $this->setAttribute('aria-labelledby', 'confirmTitle');
        $this->setAttribute('aria-hidden', 'true');
        $this->setAttribute('style', $visible ? 'display: block;' : 'display: none;');

        $this->setCssFile("Plugins\Alerts\BasicConfirm\Css\BasicConfirmOk.css");
        $this->setJsFile("Plugins\Alerts\BasicConfirm\Js\BasicConfirmOk.js");

        // Fondo negro con opacidad
        $this->modalBackdrop = new HTML('div');
        $this->modalBackdrop->setAttribute('class', 'modal-backdrop fade show');

        // Modal
        $this->modal = new HTML('div');
        $this->modal->setAttribute('class', 'modal-dialog modal-dialog-centered');
        $this->modal->setAttribute('role', 'document');

        // Modal dialog
        $this->modalDialog = new HTML('div');
        $this->modalDialog->setAttribute('class', 'modal-content');

        // Modal content
        $this->modalContent = new HTML('div');
        $this->modalContent->setAttribute('class', 'modal-content');

        // Modal header
        $this->modalHeader = new HTML('div');
        $this->modalHeader->setAttribute('class', 'modal-header');

        // Modal title
        $this->modalTitle = new HTML('h4');
        $this->modalTitle->setAttribute('id', 'confirmTitle');
        $this->modalTitle->setAttribute('class', 'modal-title');
        $this->modalTitle->setText('Confirmación');

        // Modal body
        $this->modalBody = new HTML('div');
        $this->modalBody->setAttribute('class', 'modal-body');
        $this->modalBody->setText('¿Estás seguro de que deseas continuar?');

        // Modal footer
        $this->modalFooter = new HTML('div');
        $this->modalFooter->setAttribute('class', 'modal-footer');

        // Iconos de "tick" y "cross" de Material Icons
        $this->tickIcon = new HTML('i');
        $this->tickIcon->setAttribute('class', 'material-icons');
        $this->tickIcon->setAttribute('style', 'color: green;');
        $this->tickIcon->setText('done');

        $this->crossIcon = new HTML('i');
        $this->crossIcon->setAttribute('class', 'material-icons');
        $this->crossIcon->setAttribute('style', 'color: red;');
        $this->crossIcon->setText('clear');

        $this->compile();
    }

    private function compile()
    {
        // Agregar el fondo negro con opacidad detrás del modal        
        $this->modalHeader->addElement($this->modalTitle);
        $this->modalFooter->addElement($this->tickIcon);
        $this->modalFooter->addElement($this->crossIcon);
        $this->modalContent->addElement($this->modalHeader);
        $this->modalContent->addElement($this->modalBody);
        $this->modalContent->addElement($this->modalFooter);
        $this->modalDialog->addElement($this->modalContent);
        $this->modal->addElement($this->modalDialog);
        
        // Agregar el modal y el fondo negro al contenedor principal
        $this->addElement($this->modalBackdrop);
        $this->addElement($this->modal);
    }
}

?>
