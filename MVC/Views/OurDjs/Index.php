<?php

namespace MVC\Views\OurDjs;

use Engine\Core\IView;
use Engine\Utils\Header;
use Engine\Core\HTML;

class Index extends IView
{
    private $djs;
    private $div_djs;
    private $menu;

    public function prepare()
    {
        $this->setHeader(new Header());
        $this->setTitle("🎛 Nuestros DJs");

        // Definir los DJs con sus respectivas fotos, descripciones y estilos de música
        $this->djs = $this->getVar('djs');
    }

    public function createObjects()
    {
        $this->div_djs = new HTML('div', ['class' => 'dj-carousel']);
        $this->menu = new HTML('ul', ['class' => 'dj-menu']);
        
        // Crear el menú y la grid de DJs
        $this->createMenu();
        $this->createPhotoGrid();
    }

    public function compile()
    {
        // Agregar el menú al body
        $this->addBody($this->menu);
        // Agregar la grid de DJs al body
        $this->addBody($this->div_djs);
    }

    private function createMenu()
    {
        foreach ($this->djs as $index => $dj) {
            // Crear los elementos del menú con los nombres de los DJs
            $li = new HTML('li', ['data-dj' => 'dj' . ($index + 1)]);
            $li->setText($dj['name']);

            if ($index == 0) {
                $li->setClasses(['active']);
            }

            $this->menu->addElement($li);
        }
    }

    private function createPhotoGrid()
    {
        foreach ($this->djs as $index => $dj) {
            $this->createDjTile($dj, $index);
        }
    }

    private function createDjTile($dj, $index)
    {
        // Crear el contenedor del DJ
        $div_tile = new HTML('div', ['class' => 'dj-tile' . ($index === 0 ? ' active' : '')]);
        $div_tile->setStyle(['width'=>'100%', 'display' => $index === 0 ? 'block' : 'none']);
        $div_tile->setId('dj' . ($index + 1));

        // Contenedor flex para la imagen y la información
        $div_flex = new HTML('div', ['class' => 'dj-flex']);

        // Imagen del DJ
        $img = new HTML('img', [
            'src' => $dj['src'],
            'alt' => 'Photo of ' . $dj['name']
        ]);
        $img->setClasses(['img-fluid', 'dj-image']);

        // Descripción y más información del DJ
        $div_info = new HTML('div', ['class' => 'dj-info']);
        
        $h4 = new HTML('h4');
        $h4->setClass('dj-name');
        $h4->setText($dj['name']);
        
        $p = new HTML('p');
        $p->setText($dj['description']);

        // Estilos de música
        $p_music = new HTML('p');
        $p_music->setText('Estilos de música: ' . $dj['music']);

        $div_info->addElement($h4);
        $div_info->addElement($p);
        $div_info->addElement($p_music);

        // Añadir la imagen y la info al contenedor flex
        $div_flex->addElement($img);
        $div_flex->addElement($div_info);

        // Añadir el contenedor flex al div del DJ
        $div_tile->addElement($div_flex);

        // Añadir al div del carrusel
        $this->div_djs->addElement($div_tile);
    }
}
?>
