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
        $this->div_gallery->setClasses(['row', 'justify-content-between', 'g-4', 'w-100']);
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
        $today = date('Y-m-d');
        foreach ($this->events as $event) {
            $isPast = (strtotime($event['date']) < strtotime($today)) ? true : false;
            $this->createEventCard($event, $isPast);
        }
    }

    private function createEventCard($event, $isPast)
    {
        $div_card = new HTML('div', ['class' => 'col-lg-4 col-md-4 col-sm-12 m-3 p-0 card-event']);
        $div_card->setStyle([
            'margin-left' => 'auto',
            'margin-right' => 'auto',
            'overflow' => 'hidden'
        ]);

        $carousel_id = 'carousel_' . uniqid();
        $div_carousel = new HTML('div', [
            'id' => $carousel_id,
            'class' => 'carousel slide',
            'data-bs-ride' => 'carousel'
        ]);
        $div_carousel_inner = new HTML('div', ['class' => 'carousel-inner']);

        foreach ($event['media'] as $index => $media) {
            $carousel_item = new HTML('div', [
                'class' => $index === 0 ? 'carousel-item active' : 'carousel-item'
            ]);

            if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $media)) {
                $img = new HTML('img', [
                    'src' => $media,
                    'class' => 'd-block w-100',
                    'alt' => 'Media for event ' . $event['title']
                ]);
                $img->setStyle([
                    'height' => '180px',
                    'object-fit' => 'cover' // Mantener el ratio de la imagen
                ]);
                $carousel_item->addElement($img);
            } elseif (preg_match('/\.(mp4|webm)$/i', $media)) {
                $video = new HTML('video', [
                    'class' => 'd-block w-100',
                    'controls' => true
                ]);
                $source = new HTML('source', [
                    'src' => $media,
                    'type' => 'video/mp4'
                ]);
                $video->addElement($source);
                $video->setStyle([
                    'height' => '180px',
                    'object-fit' => 'cover' // Mantener el ratio de la imagen del video
                ]);
                $carousel_item->addElement($video);
            }

            $div_carousel_inner->addElement($carousel_item);
        }

        $div_carousel->addElement($div_carousel_inner);

        $carousel_control_prev = new HTML('a', [
            'class' => 'carousel-control-prev',
            'href' => '#' . $carousel_id,
            'role' => 'button',
            'data-bs-slide' => 'prev'
        ]);
        $carousel_control_prev->addElement(new HTML('span', ['class' => 'carousel-control-prev-icon']));
        
        $carousel_control_next = new HTML('a', [
            'class' => 'carousel-control-next',
            'href' => '#' . $carousel_id,
            'role' => 'button',
            'data-bs-slide' => 'next'
        ]);
        $carousel_control_next->addElement(new HTML('span', ['class' => 'carousel-control-next-icon']));
        
        $div_carousel->addElement($carousel_control_prev);
        $div_carousel->addElement($carousel_control_next);

        $div_card->addElement($div_carousel);

        $h5 = new HTML('h5');
        $h5->setText($event['title'] . ($isPast ? " - Finalizado" : ""));
        $h5->setStyle(['color' => '#fff', 'text-align' => 'center', 'margin-top' => '15px', 'font-size' => '20px']);
        $h5->setClass($isPast ? 'bg-danger' : 'bg-primary');

        $h5_2 = new HTML('h5');
        //Change format date
        $h5_2->setText(date('d/m/Y', strtotime($event['date'])));
        $h5_2->setStyle(['color' => '#fff', 'text-align' => 'center', 'margin-top' => '15px', 'font-size' => '14px']);

        $p = new HTML('p');
        $p->setText($event['description']);
        $p->setStyle(['color' => '#ccc', 'text-align' => 'center', 'font-size' => '14px']);

        $div_card->addElement($h5);
        $div_card->addElement($h5_2);
        $div_card->addElement($p);

        $this->div_gallery->addElement($div_card);
    }

    
}
