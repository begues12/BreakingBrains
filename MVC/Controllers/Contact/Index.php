<?php
namespace MVC\Controllers\Contact;

use Engine\Core\IController;

class Index extends IController
{
    private $data;

    function __construct()
    {
        parent::__construct();
    }

    public function prepare()
    {
        // No necesitas cargar datos para la vista de contacto, ya que es un formulario simple
    }

    public function execute()
    {
        // Procesar la información enviada por el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processForm();
        }
    }

    public function finish()
    {
        // Opcional: lógica de finalización
    }

    // Procesar el formulario de contacto
    private function processForm()
    {
        // Capturar los datos del formulario
        $this->data = [
            'name' => $_POST['name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'subject' => $_POST['subject'] ?? '',
            'message' => $_POST['message'] ?? ''
        ];

        // Validar los datos (básica)
        if ($this->validate()) {
            // Aquí podrías enviar un correo o almacenar la información en una base de datos
            $this->sendEmail($this->data);
            
            // Redirigir o mostrar un mensaje de éxito
            header('Location: /contact/success');
            exit;
        } else {
            // Mostrar errores o volver a mostrar el formulario con mensajes de error
            $this->setVar('error', 'Por favor, completa todos los campos correctamente.');
        }
    }

    // Validar los datos del formulario
    private function validate()
    {
        return !empty($this->data['name']) && 
               filter_var($this->data['email'], FILTER_VALIDATE_EMAIL) &&
               !empty($this->data['subject']) && 
               !empty($this->data['message']);
    }

    // Simular el envío de un correo
    private function sendEmail($data)
    {
        $to = "contact@example.com";  // El correo al que se enviará
        $subject = "Nuevo mensaje de contacto: " . $data['subject'];
        $message = "Nombre: " . $data['name'] . "\n" .
                   "Correo electrónico: " . $data['email'] . "\n\n" .
                   "Mensaje:\n" . $data['message'];
        $headers = "From: " . $data['email'];

        // Simulamos el envío de un correo
        // mail($to, $subject, $message, $headers);

        // Para fines de desarrollo, simplemente puedes guardar en logs o simular el proceso.
        error_log("Mensaje de contacto enviado: \n" . $message);
    }
}
