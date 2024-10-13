<?php

namespace MVC\Views\OurDjs;

use Engine\Core\IView;
use Engine\Utils\Header;
use Engine\Core\HTML;

class Index extends IView
{
    private $djs;
    private $div_djs;

    public function prepare()
    {
        $this->setHeader(new Header());
        $this->setTitle("🎛 Nuestros DJs");

        $this->djs = [
            $this->getVar('biel-text'),
            $this->getVar('ntk-text'),
            $this->getVar('sadi-text')
        ];
    }

    public function createObjects()
    {
        $this->div_djs = new HTML('div', ['class' => 'grid-container']);
        $this->createPhotoGrid();
    }

    public function compile()
    {
        $this->addBody($this->div_djs);
    }

    private function createPhotoGrid()
    {
        foreach ($this->djs as $dj) {
            $this->createDjTile($dj);
        }
    }

    private function createDjTile($dj)
    {
        // Tarjeta con un diseño de cuadrícula
        $div_tile = new HTML('div', ['class' => 'dj-tile']);

        // Imagen del DJ
        $img = new HTML('img', [
            'src' => $dj['src'],
            'class' => 'img-fluid',
            'alt' => 'Photo of ' . $dj['name']
        ]);

        // Información del DJ
        $div_info = new HTML('div', ['class' => 'dj-info']);
        
        $h4 = new HTML('h4');
        $h4->setText($dj['name']);
        
        $p = new HTML('p');
        $p->setText($dj['description']);

        $div_info->addElement($h4);
        $div_info->addElement($p);

        // Añadir imagen e información al tile
        $div_tile->addElement($img);
        $div_tile->addElement($div_info);

        // Añadir el tile al contenedor principal
        $this->div_djs->addElement($div_tile);
    }
}
