<?php
namespace Plugins\Icons;

use Engine\Core\HTML;

class LinkEmoji extends HTML
{   
    private $button;
    private $emoji;
    private $size;
    private $color;
    private $href;
    private $toolTipTitle;
    private $classes;
    private $div_icon_text; // Nuevo div para contener emoji y texto


    /*
    *   @param string $emoji
    *   @param string $size
    *   @param string $color
    *   @param string $toolTipTitle
    *   @param array $classes
    */

    public function __construct(string $emoji, string $size = '1x', string $color = 'black', string $href='', string $toolTipTitle = '', array $classes = [])
    {
        parent::__construct('a');
        $this->setAttribute('href', $href);
        $this->setStyle(['text-decoration' => 'none']);

        $this->button = new HTML('button');
        $this->button->setClasses(['btn', 'btn-transparent', 'border-0']);

        $this->emoji = $emoji;
        $this->size = $size;
        $this->color = $color;
        $this->href = $href;
        $this->toolTipTitle = $toolTipTitle;
        $this->classes = $classes;

        // Crear el div para contener emoji y texto
        $this->div_icon_text = new HTML('div');
        $this->div_icon_text->setClasses(['text-center', 'nav-link']); // Para centrar el contenido

        // Crear un elemento de span que contenga el emoji
        $emoji_span = new HTML('span');
        $emoji_span->setText($this->emoji);
        $emoji_span->setStyle([
            'font-size' => $this->getSizeCss($this->size), // Convertir el tamaño en CSS
            'color' => $this->color
        ]);

        // Crear un elemento de texto para el tooltip debajo del emoji
        $text_tooltip = new HTML('span');
        $text_tooltip->setText($this->toolTipTitle);
        $text_tooltip->setStyle([
            'display' => 'block', // Hacer que el texto aparezca en su propia línea
            'margin-top' => '5px', // Añadir un pequeño margen superior
            'font-size' => '12px', // Tamaño de fuente más pequeño
            'color' => 'white' // Color del texto
        ]);

        // Añadir el emoji y el texto al div contenedor
        $this->div_icon_text->addElement($emoji_span);
        $this->div_icon_text->addElement($text_tooltip);

        // Añadir el div contenedor (que incluye emoji y texto) al enlace
        $this->addElement($this->div_icon_text);

        // Aplicar las clases personalizadas
        $this->setClasses($this->classes);

        // Incluir el archivo JS (si es necesario)
        $this->setJsFile('Plugins\Icons\FontAwesome\Js\StartIcon.js');
    }

    private function getSizeCss(string $size): string
    {
        switch ($size) {
            case '2x':
                return '2em';
            case '3x':
                return '3em';
            case '4x':
                return '4em';
            default:
                return '1em';
        }
    }
}

?>
