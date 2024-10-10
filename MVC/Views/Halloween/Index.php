<?php

namespace MVC\Views\Halloween;

use Engine\Core\IView;
use Engine\Core\HTML;
use Engine\Utils\Header;

class Index extends IView
{
    private $div_gallery;

    public function prepare()
    {
        $this->setHeader(new Header());
    }

    public function createObjects()
    {
        $this->div_gallery = new HTML('div', ['class' => 'gallery-container']);
        $this->div_gallery->setClasses(['d-flex', 'flex-wrap', 'justify-content-center', 'my-5']);

        $votes = $this->getVar('votes');

        $this->createGallery($votes);
    }

    private function createGallery(array $votes)
    {
        foreach ($votes as $id => $contestant) {
            $div_image = new HTML('div', ['class' => 'contestant']);
            $div_image->setClasses(['d-flex', 'flex-column', 'align-items-center', 'm-3']);

            // Imagen del disfraz
            $img = new HTML('img', ['src' => $contestant['image'], 'alt' => 'Disfraz Halloween']);
            $img->setStyle([
                'width' => '200px',
                'height' => '200px',
                'border-radius' => '10px',
                'object-fit' => 'cover'
            ]);

            // Botón de votar
            $voteButton = new HTML('button');
            $voteButton->setClasses(['btn', 'btn-vote', 'mt-3']);
            $voteButton->setText("Votar 🎃");
            $voteButton->setAttributes(['data-id' => $id]);

            // Mostrar número de votos
            $votesCount = new HTML('span');
            $votesCount->setText("Votos: " . $contestant['votes']);
            $votesCount->setStyle(['margin-top' => '10px', 'color' => 'white']);

            // Añadir elementos al contenedor
            $div_image->addElements([$img, $voteButton, $votesCount]);
            $this->div_gallery->addElement($div_image);
        }
    }

    public function compile()
    {
        $this->addBody($this->div_gallery);
    }
}
