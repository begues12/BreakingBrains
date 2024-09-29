<?php

namespace MVC\Views\Index;

use Engine\Core\IView;
use Engine\Core\HTML;
use Engine\Utils\Header;
use Plugins\Wave\BasicWave\BasicWave;
use Plugins\Icons\FontAwesome\LinkIcon;

use function PHPSTORM_META\map;

class Index extends IView{

    private $div_video_container;
    private $video_background;
    private $div_title;
    private $img_breaking;
    private $div_buttons;
    private $linkIcon_showMusic;
    private $linkIcon_showPhots;
    private $linkIcon_ourDjs;
    private $linkIcon_events;
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

        // Título e imagen
        $this->div_title = new HTML('div', ['class' => 'image-container']);
        $this->div_title->setClasses(['d-flex', 'flex-column', 'align-items-center', 'justify-content-center', 'w-100']);

        $this->img_breaking = new HTML('img');
        $this->img_breaking->setClasses(['ligthing-icon']);
        $this->img_breaking->setAttributes([
            'src' => 'Assets/Images/BreakingBrains/BreakingBrainsVinil.png',
            'alt' => 'Breaking Brains'
        ]);

        // Botones
        $this->div_buttons = new HTML('div');
        # Si los botones ocupan toda la pantlla saltar a la siguiente línea
        $this->div_buttons->setClasses(['container', 'd-flex', 'flex-wrap', 'justify-content-center']);
        $this->div_buttons->setStyle([
            'margin-top' => '30px'
        ]);

        $button_classes = ['btn', 'btn-futuristic', 'mt-3', 'mx-2', 'd-flex', 'align-items-center', 'justify-content-center'];

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
            '?Ctrl=Gallery',
            'Gallery',
            $button_classes
        );

        $this->linkIcon_ourDjs = new LinkIcon(
            'fa-user',
            '2x',
            'white',
            '?Ctrl=OurDjs',
            'Our Djs',
            $button_classes
        );

        $this->linkIcon_events  = new LinkIcon(
            'fa-calendar',
            '2x',
            'white',
            '?Ctrl=Events',
            'Events',
            $button_classes
        );

        $this->linkIcon_contactUs = new LinkIcon(
            'fa-headset',
            '2x',
            'white',
            '?Ctrl=Contact',
            'Contact Us',
            $button_classes
        );

        $this->linkIcon_instagram = new LinkIcon(
            'fa-instagram',
            '2x',
            'white',
            'https://www.instagram.com/breakingbrainsdj/',
            'Instagram',
            $button_classes
        );

        $this->waveEffect = new BasicWave(60, 20);

        // Galería de fotos
        $this->div_gallery = new HTML('div', ['class' => 'gallery-container']);
        $this->div_gallery->setClasses(['d-flex', 'flex-wrap', 'justify-content-center', 'my-5']);
        $this->createGalleryImages($this->getVar('galleryImages'));
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
        // $this->addBody($this->div_video_container);

        $this->addBody($this->div_title);
        $this->div_title->addElement($this->img_breaking);

        // Añadir los botones debajo del video
        $this->addBody($this->div_buttons);
        $this->div_buttons->addElement($this->linkIcon_showMusic);
        $this->div_buttons->addElement($this->linkIcon_showPhots);
        $this->div_buttons->addElement($this->linkIcon_events);
        $this->div_buttons->addElement($this->linkIcon_ourDjs);
        // $this->div_buttons->addElement($this->linkIcon_instagram);
        $this->div_buttons->addElement($this->linkIcon_contactUs);

        // Añadir el efecto de onda
        $this->addBody($this->waveEffect);

        // Añadir las fotos con texto en los laterales
        $this->addBody($this->imageText1());
        $this->addBody($this->imageText2());

        // Añadir la galería de fotos
        // $this->addBody($this->div_gallery);
    }

    public function imageText1(): HTML
    {
        $div_img_text = new HTML('div', ['class' => 'container']);
        $div_img_text->setClasses(['d-flex', 'flex-column', 'align-items-center', 'justify-content-center', 'w-100', 'my-5']);

        // Contenedor principal para las columnas (con compensación de tamaño)
        $div_image_text_1 = new HTML('div', ['class' => 'row']);
        $div_image_text_1->setClasses([
            'd-flex',
            'align-items-center',
            'justify-content-between',
            'p-3',
        ]);
    
        // Columna para la imagen (compensada con un tamaño mayor en pantallas medianas)
        $div_image = new HTML('div');
        $div_image->setClasses(['col-12', 'col-md-5', 'd-flex', 'justify-content-md-start', 'justify-content-center', 'mb-3', 'mb-md-0']);
    
        // Crear la imagen
        $img = new HTML('img', [
            'src' => 'Assets\Images\TeamPhoto\3Djs.jpg', 
            'alt' => 'Breaking Brains'
        ]);
        $img->setStyle([
            'width'         => '80%',          // La imagen ocupará como máximo el 80% de su contenedor
            'height'        => 'auto',        // Mantener la relación de aspecto
            'border-radius' => '10px',  // Imagen circular
            'object-fit'    => 'cover',
            'max-width'     => '350px'       // Limitar el ancho máximo al 80%
        ]);
    
        // Añadir la imagen a su contenedor
        $div_image->addElement($img);
    
        // Columna para el texto (compensada con un tamaño mayor en pantallas medianas)
        $div_text = new HTML('div');
        $div_text->setClasses(['col-12', 'col-md-7', 'd-flex', 'flex-column', 'align-items-start']);
    
        // Crear el título
        $h2_title = new HTML('h2');
        $h2_title->setText("¿Qué es Breaking Brains?");
        $h2_title->setStyle([
            'font-size'     => '24px',
            'color'         => 'white',
            'margin-bottom' => '10px',
            'text-align'    => 'left'
        ]);
    
        // Crear el párrafo
        $p_text = new HTML('p');
        $p_text->setText("Breaking Brains es un grupo de DJs que se dedican a la música electrónica. Nos encargamos de hacer que tu evento sea inolvidable.");
        $p_text->setStyle([
            'font-size'     => '16px',
            'color'         => 'white',
            'max-width'     => '90%',     // Asegurar que el texto no se salga del contenedor
            'padding-left'  => '15px',  // Añadir espacio entre el texto y la imagen
            'line-height'   => '1.6'     // Mejorar la legibilidad con un mayor interlineado
        ]);
        
        // Añadir el título y el párrafo a su contenedor
        $div_text->addElement($h2_title);
        $div_text->addElement($p_text);

        // Añadir las columnas al contenedor principal
        $div_image_text_1->addElement($div_image);
        $div_image_text_1->addElement($div_text);

        // Añadir el contenedor principal al contenedor principal
        $div_img_text->addElement($div_image_text_1);

        return $div_img_text;

    }


    public function imageText2(): HTML
    {
        $div_img_text = new HTML('div', ['class' => 'container']);
        $div_img_text->setClasses(['d-flex', 'flex-column', 'align-items-center', 'justify-content-center', 'w-100', 'my-5']);

        // Contenedor principal para las columnas (con compensación de tamaño)
        $div_image_text_1 = new HTML('div', ['class' => 'row']);
        $div_image_text_1->setClasses([
            'd-flex',
            'align-items-center',
            'justify-content-between',
            'p-3',
        ]);
    
        // Columna para la imagen (compensada con un tamaño mayor en pantallas medianas)
        $div_image = new HTML('div');
        $div_image->setClasses(['col-12', 'col-md-5', 'd-flex', 'justify-content-md-start', 'justify-content-center', 'mb-3', 'mb-md-0']);
    
        // Crear la imagen
        $img = new HTML('img', [
            'src' => 'Assets\Images\TeamPhoto\3Djs2.jpg', 
            'alt' => 'Breaking Brains'
        ]);
        $img->setStyle([
            'width'         => '80%',          // La imagen ocupará como máximo el 80% de su contenedor
            'height'        => 'auto',        // Mantener la relación de aspecto
            'border-radius' => '10px',  // Imagen circular
            'object-fit'    => 'cover',
            'max-width'     => '350px'       // Limitar el ancho máximo al 80%
        ]);
    
        // Añadir la imagen a su contenedor
        $div_image->addElement($img);
    
        // Columna para el texto (compensada con un tamaño mayor en pantallas medianas)
        $div_text = new HTML('div');
        $div_text->setClasses(['col-12', 'col-md-7', 'd-flex', 'flex-column', 'align-items-start']);
    
        // Crear el título
        $h2_title = new HTML('h2');
        $h2_title->setText("¿Que hacemos?");
        $h2_title->setStyle([
            'font-size'     => '24px',
            'color'         => 'white',
            'margin-bottom' => '10px',
            'text-align'    => 'left'
        ]);
    
        // Crear el párrafo
        $p_text = new HTML('p');
        $p_text->setText("Nos encargamos de hacer que tu evento sea inolvidable. Con nuestra música electrónica y nuestros DJs profesionales, tu evento será único.");
        $p_text->setStyle([
            'font-size'     => '16px',
            'color'         => 'white',
            'max-width'     => '90%',     // Asegurar que el texto no se salga del contenedor
            'padding-left'  => '15px',  // Añadir espacio entre el texto y la imagen
            'line-height'   => '1.6'     // Mejorar la legibilidad con un mayor interlineado
        ]);
        
        // Añadir el título y el párrafo a su contenedor
        $div_text->addElement($h2_title);
        $div_text->addElement($p_text);

        // Añadir las columnas al contenedor principal
        $div_image_text_1->addElement($div_text);
        $div_image_text_1->addElement($div_image);

        // Añadir el contenedor principal al contenedor principal
        $div_img_text->addElement($div_image_text_1);

        return $div_img_text;

    }
}