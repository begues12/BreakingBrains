<?php
namespace Plugins\Icons\FontAwesome;

use Engine\Core\HTML;

class LinkIcon extends HTML
{   
    private $button;
    private $iIcon;
    private $icon;
    private $size;
    private $color;
    private $href;
    private $toolTipTitle;
    private $classes;
    private $div_icon_text; // Nuevo div para contener icono y texto


    /*
    *   @param string $icon
    *   @param string $size
    *   @param string $color
    *   @param string $toolTipTitle
    *   @param array $classes
    */

    public function __construct(string $icon, string $size = '1x', string $color = 'black', string $href='', string $toolTipTitle = '', array $classes = [])
    {
        parent::__construct('a');
        $this->setAttribute('href', $href);
        $this->setStyle(['text-decoration' => 'none']);

        $this->button = new HTML('button');
        $this->button->setClasses(['btn', 'btn-transparent', 'border-0']);

        $this->iIcon = new HTML('i');
        $this->icon = $icon;
        $this->size = $size;
        $this->color = $color;
        $this->href = $href;
        $this->toolTipTitle = $toolTipTitle;
        $this->classes = $classes;

        // Crear el div para contener icono y texto
        $this->div_icon_text = new HTML('div');
        $this->div_icon_text->setClasses(['text-center']); // Para centrar el contenido

        // Establecer el icono
        $this->iIcon->setClasses([
            'fas',
            $this->icon,
            'fa-' . $this->size,
            'text-' . $this->color,
        ]);

        // Añadir el tooltip como atributo de icono si está presente
        if ($this->toolTipTitle != '')
        {
            $this->iIcon->setAttributes([
                'data-toggle' => 'tooltip',
                'data-placement' => 'top',
                'title' => $this->toolTipTitle
            ]);
        }

        // Crear un elemento de texto para el tooltip debajo del icono
        $text_tooltip = new HTML('span');
        $text_tooltip->setText($this->toolTipTitle);
        $text_tooltip->setStyle([
            'display' => 'block', // Hacer que el texto aparezca en su propia línea
            'margin-top' => '5px', // Añadir un pequeño margen superior
            'font-size' => '12px', // Tamaño de fuente más pequeño
            'color' => 'white' // Color del texto
        ]);

        // Añadir el icono y el texto al div contenedor
        $this->div_icon_text->addElement($this->iIcon);
        $this->div_icon_text->addElement($text_tooltip);

        // Añadir el div contenedor (que incluye icono y texto) al enlace
        $this->addElement($this->div_icon_text);

        // Aplicar las clases personalizadas
        $this->setClasses($this->classes);

        // Incluir el archivo JS (si es necesario)
        $this->setJsFile('Plugins\Icons\FontAwesome\Js\StartIcon.js');
    }
}

?>
