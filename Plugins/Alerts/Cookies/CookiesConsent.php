<?php

namespace Plugins\Alerts\Cookies;

use Engine\Core\HTML;

class CookiesConsent extends HTML
{
    private $modalBackdrop; // Fondo negro con opacidad
    private $modal;
    private $modalDialog;
    private $modalContent;
    private $modalHeader;
    private $modalTitle;
    private $modalBody;
    private $modalFooter;
    private $acceptButton;
    private $declineButton;

    public function __construct(bool $visible = true)
    {
        parent::__construct('div');
        $this->setAttribute('id', 'cookies-consent-container');
        $this->setAttribute('class', 'modal fade');
        $this->setAttribute('tabindex', '-1');
        $this->setAttribute('role', 'dialog');
        $this->setAttribute('aria-labelledby', 'cookiesConsentTitle');
        $this->setAttribute('aria-hidden', 'true');
        $this->setAttribute('style', $visible ? 'display: block;' : 'display: none;');

        $this->setCssFile("Plugins\Alerts\Cookies\Css\CookiesConsent.css");
        $this->setJsFile("Plugins\Alerts\Cookies\Js\CookiesConsent.js");

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
        $this->modalTitle->setAttribute('id', 'cookiesConsentTitle');
        $this->modalTitle->setAttribute('class', 'modal-title');
        $this->modalTitle->setText('Uso de cookies');

        // Modal body
        $this->modalBody = new HTML('div');
        $this->modalBody->setAttribute('class', 'modal-body');
        $this->modalBody->setText('Este sitio web utiliza cookies para garantizar que obtenga la mejor experiencia en nuestro sitio web. ¿Aceptas el uso de cookies?');

        // Modal footer
        $this->modalFooter = new HTML('div');
        $this->modalFooter->setAttribute('class', 'modal-footer');

        // Botón Aceptar
        $this->acceptButton = new HTML('button');
        $this->acceptButton->setAttribute('class', 'btn btn-primary');
        $this->acceptButton->setText('Aceptar');
        $this->acceptButton->setAttribute('onclick', 'acceptCookies()');

        // Botón Rechazar
        $this->declineButton = new HTML('button');
        $this->declineButton->setAttribute('class', 'btn btn-secondary');
        $this->declineButton->setText('Rechazar');
        $this->declineButton->setAttribute('onclick', 'declineCookies()');

        $this->compile();
    }

    private function compile()
    {
        // Agregar el fondo negro con opacidad detrás del modal
        $this->modalHeader->addElement($this->modalTitle);
        $this->modalFooter->addElement($this->acceptButton);
        $this->modalFooter->addElement($this->declineButton);
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
