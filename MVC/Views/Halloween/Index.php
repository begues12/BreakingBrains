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
        $h1_text->setText('Unete a nuestro concurso de disfraces! <br>🎃');

        $div_with_text->addElement($h1_text);

        $input_name = new HTML('input');
        $input_name->setId("participant_email");
        $input_name->setAttributes(['placeholder' => "Nombre", "type" => "text"]);
        $input_name->setClasses([
            "input",
            'm-3'
        ]);

        $input_mail = new HTML('input');
        $input_mail->setId("participant_email");
        $input_mail->setAttributes(['placeholder' => "E-Mail", "type" => "email"]);
        $input_mail->setClasses([
            "input",
            'm-3'
        ]);

        $this->button_add_participant = new HTML('button');
        $this->button_add_participant->setText('👻¡Unirse al concurso!👻');
        $this->button_add_participant->setClasses([
            'btn',
            'btn-success',
            'btn-outline',
            'm-3'
        ]);
        $div_with_text->addElements([$input_name, $input_mail, $this->button_add_participant]);

        $this->addBody($div_with_text);
        
    }

    public function compile()
    {
       

    }
}
