<?php

namespace MVC\Controllers\Halloween;

use Engine\Core\IController;
use Plugins\Alerts\BasicAlert\BasicAlert;
use Plugins\Tools\RequestJson;
use Exception;

class Votes extends IController
{
    private $votesFilePath          = 'Assets/Data/Halloween/halloween_votes.json';
    private $participantFilePath    = 'Assets/Data/Halloween/halloween_participants.json';
    private $configFilePath         = 'Assets/Data/Halloween/halloween_config.json';
    private $participants;
    private $votes;
    private $requestJson;
    private $config;
    private $participant_hash;


    public function prepare()
    {
        $this->requestJson = new RequestJson();

        // Cargar participantes y configuración del concurso
        $this->loadParticipants();
        $this->loadVotes();
        $this->loadConfig();

        $this->setVar('votes', $this->votes);
        $this->setVar('hash', $this->get('hash'));
    }

    public function execute()
    {
    }

    public function finish()
    {
    }

    private function loadParticipants()
    {
        if (file_exists($this->participantFilePath)) {
            $jsonData = file_get_contents($this->participantFilePath);
            $this->participants = json_decode($jsonData, true) ?? [];
        } else {
            $this->participants = [];
        }
    }

    private function loadVotes()
    {
        if (file_exists($this->votesFilePath)) {
            $jsonData = file_get_contents($this->votesFilePath);
            $this->votes = json_decode($jsonData, true) ?? [];
        } else {
            $this->votes = [];
        }
    }

    private function loadConfig()
    {
        if (file_exists($this->configFilePath)) {
            $jsonData = file_get_contents($this->configFilePath);
            $this->config = json_decode($jsonData, true);
        } else {
            $this->config = ['status' => 'closed'];
        }
    }


    public function vote(): void
    {
        try {
            $this->requestJson = new RequestJson();

            $this->loadVotes();
            $this->loadParticipants();
            
            $contestantId   = $this->payload('contestant_id') ?? $_REQUEST['contestant_id'];
            $userHash       = $this->payload('hash') ?? $_REQUEST['hash'];
            $userVoted      = $this->userVote($userHash);
            
            if ($contestantId === null || $userHash === null) {
                $alertError = new BasicAlert(alertType: 'danger', icon: 'fas fa-exclamation-triangle');
                $alertError->setMessage('Error al registrar el voto');

                $this->requestJson->requestJsonEncode([
                    'success' => false,
                    'message' => 'Error al registrar el voto',
                    'alert' => $alertError->toString()
                ],400);
            }

            if (!$userVoted) {

                $this->addVote($contestantId, $userHash);

                $alertSuccess = new BasicAlert(alertType: 'success', icon: 'fas fa-check-circle');
                $alertSuccess->setMessage('Voto registrado correctamente');

                $this->requestJson->requestJsonEncode([
                    'success' => true,
                    'message' => 'Voto registrado correctamente',
                    'alert' => $alertSuccess->toString()
                ],200);

            } else {

                $alertError = new BasicAlert(alertType: 'danger', icon: 'fas fa-exclamation-triangle');
                $alertError->setMessage('Usted ya ha votado');

                $this->requestJson->requestJsonEncode([
                    'success' => false,
                    'message' => 'Usted ya ha votado',
                    'alert' => $alertError->toString()
                ],200);
            }
        } catch (Exception $e) {
            $alertError = new BasicAlert(alertType: 'danger', icon: 'fas fa-exclamation-triangle');
            $alertError->setMessage('Error al registrar el voto');

            $this->requestJson->requestJsonEncode([
                'success' => false,
                'message' => 'Error al registrar el voto',
                'alert' => $alertError->toString()
            ],500);
        }
    }

    private function saveVotes()
    {
        // If have permission to write
        if (!is_writable($this->votesFilePath)) {
            throw new Exception('No se puede escribir en el archivo de votos');
        }

        file_put_contents($this->votesFilePath, json_encode($this->votes, JSON_PRETTY_PRINT));
    }

    private function addVote($contestantId, $userHash)
    {   
        try {
            $this->votes[$contestantId]['votes'][] = $userHash;
            $this->saveVotes();
        } catch (Exception $e) {
            throw new Exception('Error al registrar el voto');
        }
    }

    private function userVote($userHash): bool
    {
        $voted = false;
        foreach($this->votes as $vote) {
            if (in_array($userHash, $vote['votes'])) {
                $voted = true;
                break;
            }
        }

        return $voted;
    }

}
