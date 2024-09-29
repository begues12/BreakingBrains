<?php
namespace Engine\Utils;

use Plugins\Footers\BasicFooter\BasicFooter;
use Engine\Core\HTML;

class Footer extends BasicFooter
{
    private $divContent;
    private $labelTitle;
    private $divLegal;
    private $divSocial;

    public function __construct()
    {
        parent::__construct();
    
        $this->createObjects();
        $this->compile();
    }

    public function createObjects()
    {
        // Contenedor principal del footer (más compacto, menos padding)
        $this->divContent = new HTML('div', ['class' => 'container-fluid']);
        $this->divContent->setClasses(['d-flex', 'flex-column', 'align-items-center', 'justify-content-center', 'py-2']);

        // Título o marca del footer
        $this->labelTitle = new HTML('label');
        $this->labelTitle->setClasses(['small', 'text-white']);
        $this->labelTitle->setText('Breaking Brains © 2024 - Todos los derechos reservados'); 
        
        // Contenedor para el apartado legal
        $this->divLegal = new HTML('div');
        $this->divLegal->setClasses(['legal-links', 'd-flex', 'justify-content-center', 'mt-1']);

        // Enlaces legales más compactos
        $legalLinks = [
            ['Aviso Legal', '?Ctrl=LegalNotice'],
            ['Privacidad', '?Ctrl=PrivacyPolicy'],
            ['Cookies', '?Ctrl=CookiesPolicy'],
            ['Términos', '?Ctrl=TermsAndConditions'],
        ];

        foreach ($legalLinks as $link) {
            $legalLink = new HTML('a', ['href' => $link[1]]);
            $legalLink->setClasses(['mx-2', 'small', 'text-white']);
            $legalLink->setText($link[0]);
            $this->divLegal->addElement($legalLink);
        }

        // Redes sociales compactas
        $this->divSocial = new HTML('div');
        $this->divSocial->setClasses(['social-links', 'd-flex', 'justify-content-center', 'mt-1']);

        // Iconos de redes sociales compactos
        $socialLinks = [
            ['fa-instagram', 'https://www.instagram.com/breakingbrainsdj/'],
            ['fa-facebook', 'https://www.facebook.com/breakingbrainsdj'],
            ['fa-twitter', 'https://twitter.com/breakingbrainsdj']
        ];

        foreach ($socialLinks as $social) {
            $icon = new HTML('a', ['href' => $social[1], 'target' => '_blank']);
            $icon->setClasses(['mx-2']);
            
            $icon_img = new HTML('i', ['class' => 'fab ' . $social[0]]);
            $icon_img->setStyle(['font-size' => '1.5rem']);

            $icon->addElement($icon_img);
            $this->divSocial->addElement($icon);
        }
    }

    public function compile()
    {
        // Añadir contenido al footer
        $this->addElement($this->divContent);
        $this->divContent->addElement($this->labelTitle);

        // Añadir los enlaces legales compactos
        $this->divContent->addElement($this->divLegal);

        // Añadir redes sociales compactas
        $this->divContent->addElement($this->divSocial);
    }
}
