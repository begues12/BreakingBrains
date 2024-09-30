<?php

namespace MVC\Views\Contact;

use Engine\Core\IView;
use Engine\Utils\Header;
use Engine\Core\HTML;

class Index extends IView
{
    private $div_contact;

    public function prepare()
    {
        $this->setHeader(new Header());
    }

    public function createObjects()
    {
        // Contenedor principal con row de Bootstrap
        $this->div_contact = new HTML('div', ['class' => 'container my-5']);
        $row = new HTML('div', ['class' => 'row']);
        
        // Información de contacto a la izquierda
        $div_info = $this->createContactInfo();
        $div_info->setClasses(['col-md-6', 'col-12']);

        // Formulario de contacto a la derecha
        $div_form = $this->createContactForm();
        $div_form->setClasses(['col-md-6', 'col-12']);

        $row->addElement($div_info);
        $row->addElement($div_form);
        $this->div_contact->addElement($row);
    }

    public function compile()
    {
        $this->addBody($this->div_contact);
    }

    private function createContactInfo()
    {

        $div_info = new HTML('div', ['class' => 'contact-info']);

        $h2 = new HTML('h2');
        $h2->setClasses(['text-left']);
        $h2->setText('Contacto');

        $p1 = new HTML('p');
        $p1->setText('<strong>Teléfono:</strong> '. $this->getVar('phone'));

        $p2 = new HTML('p');
        $p2->setText('<strong>Email:</strong> '. $this->getVar('email'));

        $p3 = new HTML('p');
        $p3->setText('<strong>Dirección:</strong> '. $this->getVar('address'));

        $div_info->addElement($h2);
        $div_info->addElement($p1);
        $div_info->addElement($p2);
        $div_info->addElement($p3);

        return $div_info;
    }

    private function createContactForm()
    {
        $form = new HTML('form', ['id' => 'contactForm', 'class' => 'contact-form']);
        $form->setAttribute('method', 'post');
        $form->setAttribute('action', '?Ctrl=ContactUs&Action=Send');
        $form->addElement($this->createInput('Nombre', 'name', 'text', 'Tu nombre'));
        $form->addElement($this->createInput('Correo Electrónico', 'email', 'email', 'Tu correo electrónico'));
        $form->addElement($this->createInput('Asunto', 'subject', 'text', 'Asunto del mensaje'));
        $form->addElement($this->createTextArea('Mensaje', 'message', 'Escribe tu mensaje aquí...'));
        
        $submit = new HTML('button');
        $submit->setClasses(['btn', 'btn-primary']);
        $submit->setAttribute('type', 'submit');
        $submit->setText('Enviar');
        $form->addElement($submit);

        return $form;
    }

    private function createInput($labelText, $name, $type, $placeholder)
    {
        $div = new HTML('div', ['class' => 'mb-3']);
        $label = new HTML('label', ['for' => $name], $labelText);
        $input = new HTML('input', [
            'type' => $type,
            'class' => 'form-control',
            'id' => $name,
            'name' => $name,
            'placeholder' => $placeholder
        ]);
        $div->addElement($label);
        $div->addElement($input);
        return $div;
    }

    private function createTextArea($labelText, $name, $placeholder)
    {
        $div = new HTML('div', ['class' => 'mb-3']);
        $label = new HTML('label', ['for' => $name], $labelText);
        $textarea = new HTML('textarea', [
            'class' => 'form-control',
            'id' => $name,
            'name' => $name,
            'rows' => '5',
            'placeholder' => $placeholder
        ]);
        $div->addElement($label);
        $div->addElement($textarea);
        return $div;
    }
}

?>
