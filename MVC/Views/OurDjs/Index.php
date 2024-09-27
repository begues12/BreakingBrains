<?php

namespace MVC\Views\OurDjs;

use Engine\Core\IView;
use Engine\Utils\Header;
use Engine\Core\HTML;

class Index extends IView
{
    private $photos;
    private $div_gallery;

    public function prepare()
    {
        $this->setHeader(new Header());
        // Aquí deberías cargar los datos de los DJs de una base de datos o configuración
        $this->photos = [
            ['src' => 'Assets\Images\TeamPhoto\SadiTheLake_SergiLopez 1.jpg', 'name' => 'OMEGA', 'description' => 'Specializing in house and electronic beats.'],
            ['src' => 'Assets\Images\TeamPhoto\SadiTheLake_SergiLopez 1.jpg', 'name' => 'SADI', 'description' => 'Specializing in house and electronic beats.'],
            ['src' => 'Assets\Images\TeamPhoto\SadiTheLake_SergiLopez 1.jpg', 'name' => 'NTK', 'description' => 'Bringing the best of hip hop and top 40.'],
            // Agrega más DJs aquí...
        ];
    }

    public function createObjects()
    {
        // Contenedor principal de la galería
        $this->div_gallery = new HTML('div', ['class' => 'container']);
        $this->div_gallery->setClasses(['row', 'justify-content-center', 'g-4', 'w-100']);
        $this->div_gallery->setStyle([
            'margin-top' => '50px',
            'margin-bottom' => '50px',
            'margin-left' => 'auto',
            'margin-right' => 'auto'
        ]);

        $this->createPhotoGallery();
    }

    public function compile()
    {
        $this->addBody($this->div_gallery);
    }

    private function createPhotoGallery()
    {
        foreach ($this->photos as $photo) {
            $this->createPhotoCard($photo);
        }
    }

    private function createPhotoCard($dj)
    {
        $div_card = new HTML('div', ['class' => 'col-lg-3 col-md-4 col-sm-6 my-3 card-dj']);

        // Imagen
        $img = new HTML('img', [
            'src' => $dj['src'],
            'class' => 'img-fluid',
            'alt' => 'Photo of ' . $dj['name']
        ]);
        $img->setStyle([
            'width' => '100%',
            'height' => 'auto',
            'border-radius' => '8px'
        ]);

        // Nombre del DJ
        $h5 = new HTML('h5');
        $h5->setText($dj['name']);
        $h5->setStyle(['color' => '#fff', 'text-align' => 'center', 'margin-top' => '15px']);

        // Descripción del DJ
        $p = new HTML('p');
        $p->setText($dj['description']);
        $p->setStyle(['color' => '#ccc', 'text-align' => 'center', 'font-size' => '14px']);

        $div_card->addElement($img);
        $div_card->addElement($h5);
        $div_card->addElement($p);

        $this->div_gallery->addElement($div_card);
    }
}

?>
