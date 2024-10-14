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
        $this->setTitle("🎃 Halloween");
    }

    public function createObjects()
    {
        // Verificamos si el usuario ya está registrado (mediante la cookie o la variable de estado)
        if ($this->getVar('status') == "activated") { 
            if (!$this->getVar('can_vote')) {
                $this->createText();
            } else {
                $this->createGallery($this->getVar('can_vote'));
            }
        } else {
            // Si el concurso aún no ha comenzado, mostrar la galería sin opción de votar
            $this->createGallery(false);
        }
    }

    /**
     * Crear la galería de participantes
     * @param bool $can_vote Indica si se puede votar o no
     */
    private function createGallery(bool $can_vote = false)
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
            $voteButton->setClasses(['btn', 'btn-vote', 'mt-3', 'text-white']);
            $voteButton->setText("Votar 🎃");
            $voteButton->setAttributes(['data-id' => $id]);

            $div_image->addElement($img);

            if ($can_vote) {
                // Si se puede votar, añadir el botón de votar
                $div_image->addElement($voteButton);
            } else {
                // Si no se puede votar, añadir un mensaje en lugar del botón
                $noVoteMessage = new HTML('p');
                $noVoteMessage->setText("Votación no disponible.");
                $noVoteMessage->setClasses(['text-muted', 'mt-3']);
                $div_image->addElement($noVoteMessage);
            }

            $this->div_gallery->addElement($div_image);
        }

        // Añadir la galería al body
        $this->addBody($this->div_gallery);
    }

    /**
     * Crear el formulario de registro para nuevos participantes
     */
    private function createText()
    {
        $div_with_text = new HTML('div');
        $div_with_text->setClasses([
            'w-100',
            'd-block',
            'text-center',
            'mt-5',
        ]);

        $h1_text = new HTML('h1');
        $h1_text->setText('Entra en nuestro concurso de disfraces 🎃');

        $div_with_text->addElement($h1_text);

        $form = new HTML('form', ['id' => 'halloween-form']);
        $form->setAttributes(['enctype' => 'multipart/form-data']);

        $input_name = new HTML('input');
        $input_name->setId("participant_name");
        $input_name->setAttributes(['placeholder' => "Nombre", 'type' => 'text', 'name' => 'name']);
        $input_name->setClasses([
            'input',
            'form-control',
            'mb-3'
        ]);

        $input_mail = new HTML('input');
        $input_mail->setId("participant_email");
        $input_mail->setAttributes(['placeholder' => "E-Mail", 'type' => 'email', 'name' => 'email']);
        $input_mail->setClasses([
            'input',
            'form-control',
            'mb-3'
        ]);

        // Icono y texto para subir la imagen
        $div_upload = new HTML('div', ['id' => 'upload-container']);
        $div_upload->setClasses(['upload-box', 'text-center', 'mb-3']);
        $div_upload->setAttributes(['onclick' => "document.getElementById('participant_image').click()"]);

        $icon_upload = new HTML('i');
        $icon_upload->setClasses(['fa', 'fa-upload', 'upload-icon']);
        
        $text_upload = new HTML('p');
        $text_upload->setText("Haz clic aquí para subir tu foto de disfraz 🎃");

        // Input de tipo file oculto
        $input_image = new HTML('input', ['type' => 'file', 'name' => 'participant_image']);
        $input_image->setAttributes(['id' => 'participant_image', 'style' => 'display:none']);

        $div_upload->addElements([$icon_upload, $text_upload]);

        $button_add_participant = new HTML('button', ['type' => 'button', 'onclick' => 'sendMail()']);
        $button_add_participant->setText('👻 ¡Unirse al concurso! 👻');
        $button_add_participant->setClasses([
            'btn',
            'btn-submit',
            'btn-outline',
            'btn-lg',
            'mt-3'
        ]);

        $form->addElements([$input_name, $input_mail, $div_upload, $input_image, $button_add_participant]);

        $div_with_text->addElement($form);

        $this->addBody($div_with_text);
    }

    public function compile()
    {
        // Compilar la vista si es necesario, se deja vacío si no es requerido.
    }
}
