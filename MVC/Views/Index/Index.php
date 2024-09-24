<?php

namespace MVC\Views\Index;

use Engine\Core\IView;
use Engine\Core\HTML;
use Engine\Utils\Header;
use Plugins\Wave\BasicWave\BasicWave;
use Plugins\Icons\FontAwesome\LinkIcon;

class Index extends IView{

    private $div_video_container;
    private $video_background;
    private $div_title;
    private $img_breaking;
    private $div_buttons;
    private $linkIcon_showMusic;
    private $linkIcon_showPhots;
    private $linkIcon_contactUs;
    private $linkIcon_instagram;
    private $waveEffect;
    private $div_side_images;
    private $div_gallery;

    public function prepare()
    {
        $this->setHeader(new Header());
    }

    public function createObjects()
    {
        // Contenedor del video y la imagen
        $this->div_video_container = new HTML('div', ['class' => 'video-container']);
        $this->div_video_container->setStyle([
            'position' => 'relative',
            'width' => '100%',
            'height' => '250px',
            'overflow' => 'hidden',
        ]);

        // Video de fondo
        $this->video_background = new HTML('video');
        $this->video_background->setAttributes([
            'autoplay' => true,
            'loop' => true,
            'muted' => true,
            'playsinline' => true
        ]);
        $this->video_background->setClasses(['video-background']);
        $this->video_background->setStyle([
            'position' => 'absolute',
            'top' => '0',
            'left' => '0',
            'width' => '100%',
            'height' => '100%',
            'object-fit' => 'cover',
            'z-index' => '-1'
        ]);
        $this->video_background->setAttribute('src', 'Assets/Videos/MVI_1643.MP4');

        // Título e imagen
        $this->div_title = new HTML('div', ['class' => 'image-container']);
        $this->div_title->setStyle([
            'position' => 'absolute',
            'top' => '0',
            'left' => '50%',
            'transform' => 'translate(-50%, 175px)',
            'border-radius' => '50%',
            'z-index' => '1',  
        ]);

        $this->img_breaking = new HTML('img');
        $this->img_breaking->setClasses(['ligthing-icon']);
        $this->img_breaking->setAttributes([
            'src' => 'Assets/Images/BreakingBrains/BreakingBrainsVinil.png',
            'alt' => 'Breaking Brains'
        ]);

        // Botones
        $this->div_buttons = new HTML('div');
        $this->div_buttons->setClasses(['container', 'd-flex', 'align-items-between', 'justify-content-center', 'w-50']);
        $this->div_buttons->setStyle([
            'margin-top' => '90px'
        ]);

        $button_classes = ['btn', 'btn-futuristic', 'mt-3', 'mx-2'];

        $this->linkIcon_showMusic = new LinkIcon(
            'fa-compact-disc',
            '2x',
            'white',
            '?Ctrl=Sessions',
            'Sessions',
            $button_classes
        );

        $this->linkIcon_showPhots = new LinkIcon(
            'fa-camera-retro',
            '2x',
            'white',
            '?Ctrl=Photos',
            'Photos',
            $button_classes
        );

        $this->linkIcon_contactUs = new LinkIcon(
            'fa-headset',
            '2x',
            'white',
            '?Ctrl=ContactUs',
            'Contact Us',
            $button_classes
        );

        $this->linkIcon_instagram = new LinkIcon(
            'fa-square-instagram',
            '2x',
            'white',
            'https://www.instagram.com/breakingbrainsdj/',
            'Instagram',
            $button_classes
        );

        $this->waveEffect = new BasicWave(60, 20);

        // Fotos con texto en los laterales
        $this->div_side_images = new HTML('div', ['class' => 'side-images-container']);
        $this->div_side_images->setClasses(['d-flex', 'justify-content-between', 'align-items-center', 'w-100', 'mt-4']);
        
        // $this->createSideImage('Assets/Images/side1.jpg', 'Texto a la izquierda', 'left');
        // $this->createSideImage('Assets/Images/side2.jpg', 'Texto a la derecha', 'right');

        // Galería de fotos
        $this->div_gallery = new HTML('div', ['class' => 'gallery-container']);
        $this->div_gallery->setClasses(['d-flex', 'flex-wrap', 'justify-content-center', 'my-5']);
        $this->createGalleryImages($this->getVar('galleryImages'));
    }

    // Crear imagenes con texto en los laterales
    private function createSideImage($src, $text, $position)
    {
        $div_side_image = new HTML('div', ['class' => 'side-image']);
        $div_side_image->setClasses(['d-flex', 'flex-column', 'align-items-center']);
        $img = new HTML('img', ['src' => $src, 'alt' => $text]);
        $img->setStyle([
            'width' => '150px',
            'height' => '150px',
            'border-radius' => '50%',
            'object-fit' => 'cover',
            'margin-bottom' => '100px'
        ]);

        $div_text = new HTML('div');
        $div_text->setText($text);
        $div_text->setStyle([
            'margin-top' => '10px',
            'font-size' => '16px',
            'color' => '#333',
        ]);

        $div_side_image->addElement($img);
        $div_side_image->addElement($div_text);

        if ($position === 'left') {
            $this->div_side_images->addElement($div_side_image);
        } else {
            $this->div_side_images->addElement($div_side_image);
        }
    }

    // Crear galería de fotos
    private function createGalleryImages(array $imagePaths)
    {
        foreach ($imagePaths as $image) {
            $div_image = new HTML('div', ['class' => 'gallery-image']);
            $img = new HTML('img', ['src' => $image, 'alt' => 'Gallery Image']);
            $img->setStyle([
                'width' => '200px',
                'height' => '200px',
                'margin' => '10px',
                'border-radius' => '10px',
                'object-fit' => 'cover'
            ]);

            $div_image->addElement($img);
            $this->div_gallery->addElement($div_image);
        }
    }

    public function compile()
    {
        // Añadir el contenedor del video y la imagen
        $this->addBody($this->div_video_container);

        // Añadir el video de fondo
        $this->div_video_container->addElement($this->video_background);

        // Añadir la imagen dentro del contenedor de la imagen
        $this->addBody($this->div_title);
        $this->div_title->addElement($this->img_breaking);

        // Añadir los botones debajo del video
        $this->addBody($this->div_buttons);
        $this->div_buttons->addElement($this->linkIcon_showMusic);
        $this->div_buttons->addElement($this->linkIcon_showPhots);
        $this->div_buttons->addElement($this->linkIcon_instagram);
        $this->div_buttons->addElement($this->linkIcon_contactUs);

        // Añadir el efecto de onda
        $this->addBody($this->waveEffect);

        // Añadir las fotos con texto en los laterales
        $this->addBody($this->div_side_images);

        // Añadir la galería de fotos
        $this->addBody($this->div_gallery);
    }
}

?>
