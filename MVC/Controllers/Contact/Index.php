<?php
namespace MVC\Controllers\Contact;

use Engine\Core\IController;
use Plugins\Alerts\BasicAlert\BasicAlert;
use Plugins\EmailSender\EmailSender;
use Engine\Config;
use Exception;
use Plugins\Tools\RequestJson;

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
        $request        = new RequestJson();

        $data       = $this->post();
        
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
        

        if ($emailSender->sendEmail($this->config['email'], $subject, $body)){
            $alert = new BasicAlert();
            $alert->setMessage("¡Email enviado correctamente! 📧");
            $request->requestJsonEncode(['msg' => '¡Email enviado correctamente! 📧', 'alert' => $alert->toString()], 200);
        } else {
            $alert = new BasicAlert(true, 'danger', 'fa-exclamation-circle');
            $alert->setMessage("Error al enviar el email.");
            $request->requestJsonEncode(['msg' => 'Error al enviar el email. Por favor, inténtalo de nuevo.', 'alert' => $alert->toString()], 500);
        }

    }
    
}
