<?php

namespace MVC\Views\Gallery;

use Engine\Core\IView;
use Engine\Utils\Header;
use Engine\Core\HTML;

class Index extends IView{

    private $photos;
    private $div_gallery;

    public function prepare()
    {
        $this->setHeader(new Header());
        $this->photos = $this->getVar('photos');
    }

    public function createObjects()
    {
        // Contenedor principal de la galería (utilizando grid)
        $this->div_gallery = new HTML('div', ['class' => 'container']);
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

    private function createPhotoCard(string $src)
    {
        // Tarjeta de imagen dentro de la galería (sin uso de columnas de Bootstrap)
        $div_image = new HTML('div', ['class' => 'image-gallery-card']);

        // Imagen dentro de la tarjeta
        $img = new HTML('img', [
            'src' => 'Assets/Images/TeamPhoto/' . $src,
            'class' => 'img-fluid image-gallery',
            'alt' => 'Photo'
        ]);
        $img->setStyle([
            'width' => '100%',
            'height' => 'auto',
            'border-radius' => '8px'
        ]);

        // Agregar la imagen dentro del div de la tarjeta
        $div_image->addElement($img);
        
        // Agregar la tarjeta de imagen al contenedor principal
        $this->div_gallery->addElement($div_image);
    }
}

?>
