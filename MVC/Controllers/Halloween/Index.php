<?php

namespace MVC\Controllers\Halloween;

use Engine\Core\IController;
use Plugins\Alerts\BasicAlert\BasicAlert;
use Plugins\Tools\RequestJson;
use Plugins\EmailSender\EmailSender;
use Exception;
use Engine\Config;

class Index extends IController
{
    private $voteFilePath = 'Assets/Data/Halloween/halloween_votes.json';
    private $configFilePath = 'Assets/Data/Halloween/halloween_config.json';
    private $config;
    private $config_server;
    private $save_folder;
    private $votes;
    private $requestJson;
    private $voted_cookie = 'voted_halloween';

    public function prepare()
    {
        $this->requestJson = new RequestJson();
        $config = new Config();
        $this->config_server = $config->get('contact');
        $this->save_folder = "Assets/Images/Halloween/";
        
        $this->loadConfig();
        $this->loadVotes();

        // Verificar si el hash del participante está guardado en la cookie
        $participantHash = $this->getCookie('participant_hash');

        // Verificar si el hash existe en los votos
        $isRegistered = false;
        foreach ($this->votes as $vote) {
            if (isset($vote['hash']) && $vote['hash'] === $participantHash) {
                $isRegistered = true;
                break;
            }
        }

        $this->setVar('can_vote', $isRegistered);
        $this->setVar('votes', $this->votes);
        $this->setVar('status', $this->config['status']);
    }

    public function execute()
    {
        if (isset($_POST['vote'])) {
            $result = $this->vote($_POST['contestant_id']);
            $this->setVar('vote_result', $result);
        }
    }

    public function finish() {}

    private function loadVotes()
    {
        if (file_exists($this->voteFilePath)) {
            $jsonData = file_get_contents($this->voteFilePath);
            $this->votes = $jsonData ? json_decode($jsonData, true) : [];
        } else {
            $this->votes = [
                '1' => ['image' => 'Assets/Images/Halloween/halloween1.jpg', 'votes' => 0, 'name' => 'Halloween 1'],
                '2' => ['image' => 'Assets/Images/Halloween/halloween1.jpg', 'votes' => 0, 'name' => 'Halloween 2'],
                '3' => ['image' => 'Assets/Images/Halloween/halloween1.jpg', 'votes' => 0, 'name' => 'Halloween 3'],
            ];
        }
    }

    private function loadConfig()
    {
        if (file_exists($this->configFilePath)) {
            $jsonData = file_get_contents($this->configFilePath);
            $this->config = $jsonData ? json_decode($jsonData, true) : [];
        } else {
            $this->config = [
                'is_actived' => false,
            ];
        }
    }

    private function saveConfig()
    {
        file_put_contents($this->configFilePath, json_encode($this->config, JSON_PRETTY_PRINT));
    }

    private function saveVotes()
    {
        file_put_contents($this->voteFilePath, json_encode($this->votes, JSON_PRETTY_PRINT));
    }

    public function getVotes()
    {
        return is_array($this->votes) ? $this->votes : [];
    }

    #=== Server actions ===#
    public function vote(): void
    {
        $contestantId = $this->payload('id');
        
        if ($this->getCookie($this->voted_cookie)) {
            $alertVote = new BasicAlert(true, 'danger', 'fas fa-exclamation-triangle');
            $alertVote->setMessage("¡No puedes volver a votar!");
            $this->requestJson->requestJsonEncode(['msg' => "¡No puedes volver a votar!", 'alert' => $alertVote->toString()], 500);
            return;
        }

        if (isset($this->votes[$contestantId])) {
            $this->votes[$contestantId]['votes'] += 1;
        }

        $this->saveVotes();
        $this->setCookie($this->voted_cookie, true, time() + (86400 * 30));

        $alertVote = new BasicAlert(true);
        $alertVote->setMessage("¡Has votado!");
        $this->requestJson->requestJsonEncode(['msg' => '¡Tu voto se ha guardo!', 'alert' => $alertVote->toString()], 200);
    }

    public function resetVotes(): void
    {
        unset($_COOKIE[$this->voted_cookie]);

        foreach ($this->votes as $key => $value) {
            $this->votes[$key]['votes'] = 0;
        }

        $this->saveVotes();

        $alertVote = new BasicAlert(true);
        $alertVote->setMessage("¡Votos reiniciados!");
        $this->requestJson->requestJsonEncode(['msg' => '¡Votos reiniciados!', 'alert' => $alertVote->toString()], 200);
    }

    public function openVotes(): void
    {
        $this->config['status'] = "activated";
        $this->saveConfig();

        $alertVote = new BasicAlert(true);
        $alertVote->setMessage("¡Votaciones abiertas!");
        $this->requestJson->requestJsonEncode(['msg' => '¡Votaciones abiertas!', 'alert' => $alertVote->toString()], 200);
    }

    public function closeVotes(): void
    {
        $this->config['status'] = "closed";
        $this->saveConfig();

        $alertVote = new BasicAlert(true);
        $alertVote->setMessage("¡Votaciones cerradas!");
        $this->requestJson->requestJsonEncode(['msg' => '¡Votaciones cerradas!', 'alert' => $alertVote->toString()], 200);
    }

    public function finishVotes(): void
    {
        $this->config['activated'] = "show_votes";
        $this->saveConfig();

        $alertVote = new BasicAlert(true);
        $alertVote->setMessage("¡Votaciones finalizadas!");
        $this->requestJson->requestJsonEncode(['msg' => '¡Votaciones finalizadas!', 'alert' => $alertVote->toString()], 200);
    }

    public function sendEmail()
    {
        $request    = new RequestJson();
        $alertError = new BasicAlert(alertType: 'danger', icon: 'fas fa-exclamation-triangle');

        try {
            $data = $this->post();

            $to         = $data['email'];
            $subject    = "Concurso de disfraces breaking brains";

            $fileURL = $this->uploadImage();

            $data = [
                'name' => $data['name'],
                'email' => $to,
                'contact_email' => $this->config_server['email'],
            ];

            $emailSender = new EmailSender();
            $message = $emailSender->renderEmailTemplate("Plugins/EmailSender/templates/send_halloween_template.html", $data);
            $emailSender->sendEmail($to, $subject, $message);

            // Guardar al participante con la imagen subida
            $this->newParticipant($data['name'], $data['email'], $fileURL);

            // Mensaje de confirmación
            $alert = new BasicAlert();
            $alert->setMessage("¡Email enviado y participante registrado! 📧");
            $request->requestJsonEncode(['msg' => '¡Email enviado y participante registrado! 📧', 'alert' => $alert->toString()], 200);

        } catch (Exception $e) {
            $alertError->setMessage("¡Error al enviar el mensaje!".$e->getMessage());
            $request->requestJsonEncode(['msg' => '¡Error al enviar el mensaje!', 'alert' => $alertError->toString()], 500);
        }
    }

    private function uploadImage(): string
    {
        if (isset($_FILES['participant_image']) && $_FILES['participant_image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['participant_image']['tmp_name'];
            $fileName = $_FILES['participant_image']['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($fileExtension, $allowedfileExtensions)) {
                $uploadFileDir = $this->save_folder;
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $dest_path = $uploadFileDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    return $dest_path; // Devolver la ruta de la imagen
                }else{
                    throw new Exception("¡Error al subir la imagen por que no se pudo mover al directorio destino!");
                }
            }else{
                throw new Exception("¡Tipo de archivo no permitido!");
            }
        }

        throw new Exception("Error al subir la imagen.");
    }

    public function newParticipant(string $name, string $email, string $fileURL)
    {
        // Generar un hash único para el participante usando su email y el tiempo actual
        $hash = md5($email . time());

        $this->votes[] = [
            'name' => $name,
            'email' => $email,
            'votes' => 0,
            'image' => $fileURL,
            'hash' => $hash  // Guardar el hash en los datos del participante
        ];

        $this->saveVotes();

        // Guardar el hash en una cookie
        $this->setCookie('participant_hash', $hash, time() + (86400 * 30)); // La cookie expira en 30 días
    }
}
