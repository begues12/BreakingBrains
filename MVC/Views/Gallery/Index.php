<?php

namespace MVC\Views\Gallery;

use Engine\Core\IView;
use Engine\Utils\Header;
use Engine\Core\HTML;
use Engine\Utils\Head;
use Plugins\Wave\BasicWave\BasicWave;
use Plugins\Icons\FontAwesome\LinkIcon;

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
        foreach($this->photos as $photo)
        {
            $this->createPhotoCard($photo);
        }
    }

    private function createPhotoCard(string $src)
    {
        // Tarjeta de imagen que se adaptará a tamaños pequeños y medianos
        $div_image = new HTML('div', ['class' => 'col-lg-3 col-md-4 col-sm-6']);
        $div_image->setStyle([
            'position' => 'relative',
            'overflow' => 'hidden',   // Recortar imagenes
            'border-radius' => '8px', // Esquinas redondeadas
            'box-shadow' => '0px 4px 15px rgba(0, 0, 0, 0.1)', // Sombra suave
            'transition' => 'transform 0.3s ease-in-out' // Transición suave
        ]);

        // Imagen dentro de la tarjeta
        $img = new HTML('img', [
            'src' => 'Assets/Images/TeamPhoto/' . $src,
            'class' => 'img-fluid',
            'alt' => 'Photo'
        ]);
        $img->setStyle([
            'width' => '100%',
            'height' => 'auto',
            'border-radius' => '8px'
        ]);

        // Añadir animación de escala al pasar el ratón
        $div_image->setStyle(['cursor' => 'pointer']);
        $div_image->setAttribute('onmouseover', "this.style.transform='scale(1.05)'");
        $div_image->setAttribute('onmouseout', "this.style.transform='scale(1)'");

        // Agregar la imagen dentro del div de la tarjeta
        $div_image->addElement($img);
        
        // Agregar la tarjeta de imagen al contenedor principal
        $this->div_gallery->addElement($div_image);
    }
}

?>
