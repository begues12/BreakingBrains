<?php

namespace MVC\Views\Contact;

use Engine\Core\IView;
use Engine\Utils\Header;
use Engine\Core\HTML;

class Index extends IView{

    private $div_contact_form;

    public function prepare()
    {
        // Configurar el encabezado
        $this->setHeader(new Header());
    }

    public function createObjects()
    {
        // Contenedor principal del formulario de contacto
        $this->div_contact_form = new HTML('div', ['class' => 'container']);
        $this->div_contact_form->setClasses(['row', 'justify-content-center', 'g-4', 'w-100']);
        $this->div_contact_form->setStyle([
            'margin-top' => '50px',
            'margin-bottom' => '50px',
            'margin-left' => 'auto',
            'margin-right' => 'auto'
        ]);

        $this->createContactForm();
    }

    public function compile()
    {
        // Agregar el formulario de contacto al cuerpo
        $this->addBody($this->div_contact_form);
    }

    private function createContactForm()
    {
        // Crear el formulario
        $form = new HTML('form');
        $form->setAttribute('method', 'post');
        $form->setAttribute('action', '/contact/submit');  // La ruta de acción del formulario
        $form->setClasses(['contact-form', 'w-100']);

        // Campo de nombre
        $div_name = new HTML('div', ['class' => 'mb-3']);
        $label_name = new HTML('label', ['for' => 'name']);
        $label_name->setText('Nombre');
        $input_name = new HTML('input', [
            'type' => 'text',
            'class' => 'form-control',
            'id' => 'name',
            'name' => 'name',
            'placeholder' => 'Tu nombre'
        ]);

        $div_name->addElement($label_name);
        $div_name->addElement($input_name);
        $form->addElement($div_name);

        // Campo de correo electrónico
        $div_email = new HTML('div', ['class' => 'mb-3']);
        $label_email = new HTML('label', ['for' => 'email']);
        $label_email->setText('Correo Electrónico');
        $input_email = new HTML('input', [
            'type' => 'email',
            'class' => 'form-control',
            'id' => 'email',
            'name' => 'email',
            'placeholder' => 'Tu correo electrónico'
        ]);

        $div_email->addElement($label_email);
        $div_email->addElement($input_email);
        $form->addElement($div_email);

        // Campo de asunto
        $div_subject = new HTML('div', ['class' => 'mb-3']);
        $label_subject = new HTML('label', ['for' => 'subject']);
        $label_subject->setText('Asunto');
        $input_subject = new HTML('input', [
            'type' => 'text',
            'class' => 'form-control',
            'id' => 'subject',
            'name' => 'subject',
            'placeholder' => 'Asunto del mensaje'
        ]);

        $div_subject->addElement($label_subject);
        $div_subject->addElement($input_subject);
        $form->addElement($div_subject);

        // Campo de mensaje
        $div_message = new HTML('div', ['class' => 'mb-3']);
        $label_message = new HTML('label', ['for' => 'message']);
        $label_message->setText('Mensaje');
        $textarea_message = new HTML('textarea', [
            'class' => 'form-control',
            'id' => 'message',
            'name' => 'message',
            'rows' => '5',
            'placeholder' => 'Escribe tu mensaje aquí...'
        ]);

        $div_message->addElement($label_message);
        $div_message->addElement($textarea_message);
        $form->addElement($div_message);

        // Botón de enviar
        $div_submit = new HTML('div', ['class' => 'mb-3']);
        $button_submit = new HTML('button', [
            'type' => 'submit',
            'class' => 'btn btn-primary'
        ]);
        $button_submit->setText('Enviar');

        $div_submit->addElement($button_submit);
        $form->addElement($div_submit);

        // Agregar el formulario completo al contenedor principal
        $this->div_contact_form->addElement($form);
    }
}

?>
