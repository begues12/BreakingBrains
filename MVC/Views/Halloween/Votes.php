<?php

namespace MVC\Views\Halloween;

use Engine\Core\IView;
use Engine\Core\HTML;
use Engine\Utils\Header;

class Votes extends IView
{
    private $div_gallery;
    private $hash;

    public function prepare()
    {
        $this->setHeader(new Header());
        $this->setTitle("🎃 Halloween");
        $this->hash = $this->getVar("participant_hash");
    }

    public function createObjects()
    {
        $this->createGallery();
    }

    private function createGallery()
    {
        $this->div_gallery = new HTML('div', ['class' => 'gallery-container']);
        $this->div_gallery->setClasses(['d-flex', 'flex-wrap', 'justify-content-center', 'my-5']);

        $votes = $this->getVar('votes');

        foreach ($votes as $id => $contestant) {
            $div_image = new HTML('div', ['class' => 'contestant']);
            $div_image->setClasses(['d-flex', 'flex-column', 'align-items-center', 'm-3']);

            $img = new HTML('img', ['src' => $contestant['image'], 'alt' => 'Disfraz Halloween']);
            $img->setStyle([
                'width' => '200px',
                'height' => '200px',
                'border-radius' => '10px',
                'object-fit' => 'cover'
            ]);

            // Crear el botón de votar solo si se permite votar
            $voteButton = new HTML('button');
            $voteButton->setClasses(['btn', 'btn-vote', 'vote-button','btn-submit', 'mt-3', 'text-white']);
            $voteButton->setText("Votar 🎃");
            $voteButton->setAttributes(['data-contestant-id' => $id, 'data-contestant-hash' => $this->hash]);
            $voteButton->setAttributes(['data-contestant-id' => $id, 'data-contestant-hash' => $this->hash]);

            $div_image->addElements([$img, $voteButton]);
          
            $this->div_gallery->addElement($div_image);
        }

        // Añadir la galería al body
        $this->addBody($this->div_gallery);
    }

    public function compile()
    {
        // Compilar la vista si es necesario, se deja vacío si no es requerido.
    }
}
