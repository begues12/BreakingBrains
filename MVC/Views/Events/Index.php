<?php

namespace MVC\Views\Events;

use Engine\Core\IView;
use Engine\Utils\Header;
use Engine\Core\HTML;

class Index extends IView
{
    private $events;
    private $div_gallery;

    public function prepare()
    {
        $this->setHeader(new Header());
        // Supongamos que estos datos se obtienen de alguna lógica del backend:
        $this->events = $this->getVar('events');
    }

    public function createObjects()
    {
        // Contenedor principal de la galería
        $this->div_gallery = new HTML('div', ['class' => 'container']);
        $this->div_gallery->setClasses(['row', 'justify-content-center', 'g-4', 'w-100']);
        $this->div_gallery->setStyle([
            'margin-top'    => '50px',
            'margin-bottom' => '50px',
            'margin-left'   => 'auto',
            'margin-right'  => 'auto'
        ]);

        $this->createEventGallery();
    }

    public function compile()
    {
        $this->addBody($this->div_gallery);
    }

    private function createEventGallery()
    {
        $today = date('Y-m-d'); // Fecha actual para comparar con la fecha del evento
        foreach ($this->events as $event) {
            $isPast = (strtotime($event['date']) < strtotime($today)) ? true : false;
            $this->createEventCard($event, $isPast);
        }
    }

    private function createEventCard($event, $isPast)
    {
        $div_card = new HTML('div', ['class' => 'col-lg-3 col-md-6 col-sm-12 m-3 p-0 card-event']);
        $div_card->setStyle([
            'margin-left' => 'auto',
            'margin-right' => 'auto',
            'overflow' => 'hidden'
        ]);

        // Imagen del evento
        $img = new HTML('img', [
            'src' => $event['image'],
            'class' => 'img-fluid',
            'alt' => 'Photo of event ' . $event['title']
        ]);
        $img->setStyle([
            'width' => '100%',
            'height' => '200px',
        ]);

        // Nombre del evento
        $h5 = new HTML('h5');
        $h5->setText($event['title'] . ($isPast ? " - Finalizado" : ""));
        $h5->setStyle(['color' => '#fff', 'text-align' => 'center', 'margin-top' => '15px', 'font-size' => '20px']);
        $h5->setClass( $isPast ? 'bg-danger' : 'bg-primary' );

        $h5_2 = new HTML('h5');
        $h5_2->setText($event['date']);
        $h5_2->setStyle(['color' => '#fff', 'text-align' => 'center', 'margin-top' => '15px', 'font-size' => '14px']);

        // Descripción del evento
        $p = new HTML('p');
        $p->setText($event['description']);
        $p->setStyle(['color' => '#ccc', 'text-align' => 'center', 'font-size' => '14px']);

        $div_card->addElement($img);
        $div_card->addElement($h5);
        $div_card->addElement($h5_2);
        $div_card->addElement($p);

        $this->div_gallery->addElement($div_card);
    }
}
