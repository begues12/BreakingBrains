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
        // Aquí deberías cargar los datos de los DJs de una base de datos o configuración
        $this->djs = [
            $this->getVar('biel-text'),
            $this->getVar('ntk-text'),
            $this->getVar('sadi-text')
        ];
    }

    public function createObjects()
    {
        // Contenedor principal de la galería
        $this->div_djs = new HTML('div', ['class' => 'container']);
        $this->div_djs->setClasses(['djs-gallery']);

        $this->createPhotoGallery();
    }

    public function compile()
    {
        $this->addBody($this->div_djs);
    }

    private function createPhotoGallery()
    {
        foreach ($this->djs as $dj) {
            $this->createDjCard($dj);
        }
    }

    private function createDjCard($dj)
    {
        // Tarjeta contenedora con flexbox para la estructura responsive
        $div_card = new HTML('div', ['class' => 'dj-card']);

        $div_img = new HTML('div', ['class' => 'dj-img']);

        $img = new HTML('img', [
            'src' => $dj['src'],
            'class' => 'img-fluid',
            'alt' => 'Photo of ' . $dj['name']
        ]);

        $div_text = new HTML('div', ['class' => 'dj-info']);

        $h5 = new HTML('h4');
        $h5->setText($dj['name']);

        $p = new HTML('p');
        $p->setText($dj['description']);

        $div_text->addElement($h5);
        $div_text->addElement($p);

        $div_img->addElement($img);

        $div_card->addElement($div_img);
        $div_card->addElement($div_text);

        $this->div_djs->addElement($div_card);
    }
}
