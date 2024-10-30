<?php
namespace MVC\Controllers\Halloween;


use Engine\Core\IController;
use Plugins\Alerts\BasicAlert\BasicAlert;
use Plugins\Tools\RequestJson;
use Plugins\EmailSender\EmailSender;
use Exception;
use Engine\Config;
use Plugins\Tools\Helpers;

class Index extends IController
{
    private $voteFilePath = 'Assets/Data/Halloween/halloween_participants.json';
    private $config_server;
    private $votes;
    private $requestJson;
    private $participant_hash;

    public function prepare()
    {
        $this->requestJson = new RequestJson();
        $config = new Config();
        $this->config_server = $config->get('contact');
        
      
        $this->loadParticipants();
    }

    public function execute()
    {
    }

    public function finish()
    {
    }

    private function loadParticipants()
    {
        $jsonData       = file_get_contents($this->voteFilePath);
        $this->votes    = json_decode($jsonData, true);
    }

    public function getVotes()
    {
        return is_array($this->votes) ? $this->votes : [];
    }

    public function sendEmail()
    {
        $request    = new RequestJson();
        $alertError = new BasicAlert(alertType: 'danger', icon: 'fas fa-exclamation-triangle');

        try {
            $data = $this->post();

            $to         = $data['email'];
            $subject    = "Concurso de disfraces breaking brains";

            // Construir los datos sin la imagen
            $emailData = [
                'name'          => $data['name'],
                'email'         => $to,
                'contact_email' => $this->config_server['email'],
            ];

            // Enviar el correo
            $emailSender    = new EmailSender();
            $message        = $emailSender->renderEmailTemplate("Plugins/EmailSender/templates/send_halloween_template.html", $emailData);
            $emailSender->sendEmail($to, $subject, $message);

            // Guardar al participante sin la imagen
            $this->newParticipant($data['name'], $data['email']);

            // Mensaje de confirmación
            $alert = new BasicAlert();
            $alert->setMessage("¡Email enviado y participante registrado! 📧");
            $request->requestJsonEncode(['msg' => '¡Email enviado y participante registrado! 📧', 'alert' => $alert->toString()], 200);

        } catch (Exception $e) {
            $alertError->setMessage("¡Error al enviar el mensaje! " . $e->getMessage());
            $request->requestJsonEncode(['msg' => '¡Error al enviar el mensaje!', 'alert' => $alertError->toString()], 500);
        }
    }

    private function saveMail()
    {
        $jsonData = json_encode($this->votes, JSON_PRETTY_PRINT);
        file_put_contents($this->voteFilePath, $jsonData);
    }

    private function newParticipant($name, $email)
    {
        $this->votes[] = [
            'name' => $name,
            'email' => $email,
            'hash' => md5($email.date('Y-m-d H:i:s')),
            'date' => date('Y-m-d H:i:s')
        ];

        $this->saveMail();
    }

    public function OpenVotes()
    {
        $alertError = new BasicAlert(alertType: 'danger', icon: 'fas fa-exclamation-triangle');
        $alertSuccess = new BasicAlert(alertType: 'success', icon: 'fas fa-check-circle');
        $emailSender = new EmailSender();
        
        $this->loadParticipants();

        try {
            $subject = "¡Las votaciones han comenzado! - Concurso de disfraces Breaking Brains";
            $sentCount = 0;

            foreach ($this->votes as $participant) {

                $emailData = [
                    'name' => $participant['name'],
                    'voting_link' => Helpers::getBaseUrl()."?Ctrl=Halloween&Do=Votes&hash=" . $participant['hash'],
                    'contact_email' => $this->config_server['email']
                ];
                
                $message = $emailSender->renderEmailTemplate("Plugins/EmailSender/templates/send_halloween_vote_template.html", $emailData);
                $emailSender->sendEmail($participant['email'], $subject, $message);
                $sentCount++;
            }

            $alertSuccess->setMessage("¡Correos de apertura de votación enviados a $sentCount participantes! 📧");
            $this->requestJson->requestJsonEncode(['msg' => "¡{$sentCount} Correos enviados con éxito!", 'alert' => $alertSuccess->toString()], 200);

        } catch (Exception $e) {
            $alertError->setMessage("Error al enviar correos de apertura: " . $e->getMessage());
            $this->requestJson->requestJsonEncode(['msg' => 'Error al enviar correos de apertura', 'alert' => $alertError->toString()], 500);
        }
    }


}
