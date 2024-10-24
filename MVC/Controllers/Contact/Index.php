<?php
namespace MVC\Controllers\Contact;

use Engine\Core\IController;
use Plugins\EmailSender\EmailSender;
use Engine\Config;
use Exception;

class Index extends IController
{
    private $data;
    private $config;

    function __construct()
    {
        parent::__construct();
        $config = new Config();
        $this->config = $config->get('contact');
        $this->setVars($this->config);
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
    }

    private function processForm()
    {
        $this->data = [
            'name'      => $_POST['name']     ?? '',
            'email'     => $_POST['email']    ?? '',
            'subject'   => $_POST['subject']  ?? '',
            'message'   => $_POST['message']  ?? ''
        ];

        if ($this->validate()) {
            $this->sendEmail($this->data);
            
            header('Location: /contact/success');
            exit;
        } else {
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

    public function sendEmail()
    {
        try{
            $data       = $this->payload();
            
            $to         = $data['email'];
            $subject    = $data['subject'];

            $data = [
                'name'          => $data['name'],
                'email'         => $data['email'],
                'subject'       => $data['subject'],
                'contact_email' => $this->config['email'],
                'message'       => $data['message']
            ];

            $emailSender    = new EmailSender();

            $message    = $emailSender->renderEmailTemplate("Plugins/EmailSender/templates/send_info_template.html", $data);
            $emailSender->sendEmail($to, $subject, $message);
    
            $body       = $emailSender->renderEmailTemplate("Plugins/EmailSender/templates/admin_notification_template.html", $data);
            $emailSender->sendEmail($this->config['email'], $subject, $body);

            error_log("Mensaje de contacto enviado: \n" . $message);
    
        } catch (Exception $e) {
            error_log("Error al enviar el mensaje de contacto: " . $e->getMessage());
        }
    }
    
}
