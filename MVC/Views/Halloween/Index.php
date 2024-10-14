<?php

namespace MVC\Views\Halloween;

use Engine\Core\IView;
use Engine\Core\HTML;
use Engine\Utils\Header;

class Index extends IView
{
    private $div_button_add;
    private $button_add_participant;
    private $div_gallery;

    public function prepare()
    {
        $this->setHeader(new Header());
        $this->setTitle("🎃 Halloween");
    }

    public function createObjects()
    {
        if ($this->getVar('status') == "activated"){ 
            if (!$this->getVar('has_email')){
                $this->createText();
            }else{
                $this->createGallery();
            }
        }else{
            $this->createGallery(false);
        }
    }

    private function createGallery(bool $active=true)
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

            $voteButton = new HTML('button');
            $voteButton->setClasses(['btn', 'btn-vote', 'mt-3', 'text-white']);
            $voteButton->setText("Votar 🎃");
            $voteButton->setAttributes(['data-id' => $id]);

            $div_image->addElement($img);
            
            if($active){
                $div_image->addElement($voteButton);
            }

            $this->div_gallery->addElement($div_image);
            
        }
        $this->addBody($this->div_gallery);
    }

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

        $this->button_add_participant = new HTML('button', ['type' => 'button', 'onclick' => 'sendMail()']);
        $this->button_add_participant->setText('👻 ¡Unirse al concurso! 👻');
        $this->button_add_participant->setClasses([
            'btn',
            'btn-submit',
            'btn-outline',
            'btn-lg',
            'mt-3'
        ]);

        $form->addElements([$input_name, $input_mail, $div_upload, $input_image, $this->button_add_participant]);

        $div_with_text->addElement($form);

        $this->addBody($div_with_text);
    }




    public function compile()
    {
       

    }
}
