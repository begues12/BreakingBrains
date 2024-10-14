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
        $this->setTitle('📷 Galería');
        $this->photos = $this->getVar('photos');
    }

    public function createObjects()
    {
        // Contenedor principal de la galería (utilizando grid)
        $this->div_gallery = new HTML('div', ['class' => 'container']);
        $this->div_gallery->setStyle([
            'margin-top'    => '50px',
            'margin-bottom' => '50px',
            'margin-left'   => 'auto',
            'margin-right'  => 'auto'
        ]);
        
        $this->createPhotoGallery();
    }

    public function compile()
    {
        $this->addBody($this->div_gallery);
    }

    private function createPhotoGallery()
    {
        // Cambiar el contenedor a <section> para seguir la estructura semántica
        $this->div_gallery = new HTML('section', ['class' => 'gallery-container']);
        $this->div_gallery->setStyle([
            'column-count' => '4', // Establece el número inicial de columnas
            'column-gap' => '15px', // Espacio entre columnas
            'padding' => '20px',
            'width' => '100%'
        ]);

        foreach ($this->photos as $photo) {
            $this->createPhotoCard($photo);
        }
    }

    private function createPhotoCard(string $src)
    {
        // Utilizar <article> como contenedor para cada imagen
        $article = new HTML('article', ['class' => 'gallery-item']);
        $article->setStyle([
            'break-inside' => 'avoid', // Evita que los artículos se rompan entre columnas
            'margin-bottom' => '15px', // Espacio inferior entre imágenes
            'border-radius' => '8px',
            'box-shadow' => '0 4px 8px rgba(0, 0, 0, 0.1)'
        ]);

        // Usar <figure> para envolver la imagen
        $figure = new HTML('figure', ['class' => 'gallery-figure']);
        $figure->setStyle([
            'margin' => '0',
            'padding' => '0'
        ]);

        // Imagen dentro del <figure>
        $img = new HTML('img', [
            'src' => 'Assets/Images/TeamPhoto/' . $src,
            'class' => 'gallery-img',
            'alt' => 'Photo'
        ]);
        $img->setStyle([
            'width' => '100%',
            'display' => 'block',
            'object-fit' => 'cover',
            'border-radius' => '8px'
        ]);

        // Añadir la imagen al <figure>
        $figure->addElement($img);
        // Añadir el <figure> al <article>
        $article->addElement($figure);
        // Añadir el <article> al <section> (galería)
        $this->div_gallery->addElement($article);
    }


}

?>
