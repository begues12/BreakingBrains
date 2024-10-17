<?php 

namespace Plugins\Headers\BasicHeader;

use Engine\Core\HTML;

class BasicHeader extends \Engine\Core\HTML
{   

    private $nav;
    private $aTitle;
    private $imgLogo;
    private $buttonCollapse;
    private $spanCollapse;
    private $ul;
    private $divCollapse;

    public function __construct()
    {
        parent::__construct("header");
        $this->prepare();
        $this->createObjects();
        $this->compile();
    }

    private function prepare()
    {
    }

    private function createObjects()
    {
        $this->setClasses([
            'container-fluid',
            'p-0',
            'text-light',
        ]);

        $this->nav = new HTML('nav');
        $this->nav->setStyle(['width' => '100%', 'z-index' => '1000', 'background-color' => '#000000']);
        $this->nav->setClasses([
            'navbar',
            'navbar-expand-md',
            'navbar-light',
            'text-light'
        ]);

        // Creación del logo (imagen) si es necesario
        $this->imgLogo = new HTML('img');
        $this->imgLogo->setAttribute('alt', 'Logo');
        $this->imgLogo->setClasses(['navbar-brand', 'm-2', 'ligthing-icon-header']);
        $this->setLogo('Assets\Images\BreakingBrains\breakingbrains_transparent.jpg', 'Logo');
        $this->imgLogo->setStyle([
            'height' => '80px',
            'width' => '80px',
        ]);

        $this->aTitle = new HTML('a');
        $this->aTitle->setClasses([
            'navbar-brand',
            'fw-bold',
            'fs-3'
        ]);

        // Botón de colapso de color blanco
        $this->buttonCollapse = new HTML('button');
        $this->buttonCollapse->setClasses([
            'navbar-toggler',
            'border-0'
        ]);
        $this->buttonCollapse->setStyle([
            'background-color' => 'transparent',
            'color' => 'white'
        ]);
        $this->buttonCollapse->setAttribute('type', 'button');
        $this->buttonCollapse->setAttribute('data-bs-toggle', 'collapse');
        $this->buttonCollapse->setAttribute('data-bs-target', '#navbarNav');
        $this->buttonCollapse->setAttribute('aria-controls', 'navbarNav');
        $this->buttonCollapse->setAttribute('aria-expanded', 'false');
        $this->buttonCollapse->setAttribute('aria-label', 'Toggle navigation');

        // Icono de colapso de color blanco
        $this->spanCollapse = new HTML('span');
        $this->spanCollapse->setClasses([
            'navbar-toggler-icon'
        ]);
        $this->spanCollapse->setStyle([
            'filter' => 'invert(1)'  // Invertir el color del icono a blanco
        ]);
        $this->buttonCollapse->addElement($this->spanCollapse);

        $this->divCollapse = new HTML('div');
        $this->divCollapse->setClasses([
            'collapse',
            'navbar-collapse',
            'justify-content-end',
        ]);
        $this->divCollapse->setAttribute('id', 'navbarNav');

        $this->ul = new HTML('ul');
        $this->ul->setClasses(['navbar-nav', 'mr-auto']);
    }

    private function compile()
    {
        $this->addElement($this->nav);

        // Añadir la imagen del logo antes del título
        $this->nav->addElement($this->imgLogo);  // La imagen del logo irá primero
        $this->nav->addElement($this->aTitle);   // Luego el título

        $this->nav->addElement($this->buttonCollapse);
        $this->nav->addElement($this->divCollapse);
        $this->divCollapse->addElement($this->ul);
    }

    // Método para establecer la imagen del logo
    public function setLogo(string $src, string $alt = 'Logo')
    {
        $this->imgLogo->setAttribute('src', $src);  // Establece la ruta de la imagen
        $this->imgLogo->setAttribute('alt', $alt);  // Texto alternativo para la accesibilidad
    }

    public function addHeaderLink(string $text, string $href, string $active = null, ?array $liClasses = null, ?array $aClasses = null, string $iconClass = null)
    {
        $li = new HTML('li');
        $li->setClasses(['nav-item', 'mx-2']);

        if ($liClasses) {
            $li->setClasses($liClasses);
        }

        if ($active) {
            $li->setClass('active');
        }

        $li_a = new HTML('a');
        $li_a->setClasses(['nav-link']);
        $li_a->setAttribute('href', $href);

        if ($aClasses) {
            $li_a->setClasses($aClasses);
        }

        if ($iconClass) {
            $icon = new HTML('i');
            $icon->setClasses([$iconClass, 'me-2']); // 'me-2' para espacio entre icono y texto
            $li_a->addElement($icon);
        }

        $li_a->setText($text);

        $li->addElement($li_a);
        $this->ul->addElement($li);
    }


    public function setTitle(string $title)
    {
        $this->aTitle->setText($title);
    }

    public function setTitleLink(string $href)
    {
        $this->aTitle->setAttribute('href', $href);
    }
}

?>
