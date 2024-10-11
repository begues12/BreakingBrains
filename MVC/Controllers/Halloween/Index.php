<?php

namespace MVC\Controllers\Halloween;

use Engine\Core\IController;
use Plugins\Alerts\BasicAlert\BasicAlert;
use Plugins\Tools\RequestJson;

class Index extends IController
{
    private $voteFilePath = 'Assets/Data/Halloween/halloween_votes.json';
    private $configFilePath = 'Assets/Data/Halloween/halloween_config.json';
    private $config;
    private $votes;
    private $requestJson;
    private $voted_cookie = 'voted_halloween';

    public function prepare()
    {
        $this->requestJson = new RequestJson();
        
        $this->loadConfig();
        $this->loadVotes();
        $this->setVar('votes', $this->votes);
        $this->setVar('is_actived', $this->config['is_actived']);
    }

    public function execute()
    {
        if (isset($_POST['vote'])) {
            $result = $this->vote($_POST['contestant_id']);
            $this->setVar('vote_result', $result);
        }

    }

    public function finish()
    {
    }

    private function loadVotes()
    {
        if (file_exists($this->voteFilePath)) {
            $jsonData       = file_get_contents($this->voteFilePath);
            $this->votes    = $jsonData ? json_decode($jsonData, true) : [];
        } else {
            $this->votes = [
                '1' => ['image' => 'Assets\Images\Halloween\halloween1.jpg', 'votes' => 0, 'name' => 'Halloween 1'],
                '2' => ['image' => 'Assets\Images\Halloween\halloween1.jpg', 'votes' => 0, 'name' => 'Halloween 2'],
                '3' => ['image' => 'Assets\Images\Halloween\halloween1.jpg', 'votes' => 0, 'name' => 'Halloween 3'],
            ];
        }
    }

    private function loadConfig()
    {
        if (file_exists($this->configFilePath)) {
            $jsonData       = file_get_contents($this->configFilePath);
            $this->config    = $jsonData ? json_decode($jsonData, true) : [];
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

        $this->requestJson->requestJsonEncode(['msg' => '¡Tu voto se ha guardo!', 'alert' => $alertVote->toString()],200);
        return;
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
            
        $this->requestJson->requestJsonEncode(['msg' => '¡Votos reiniciados!', 'alert' => $alertVote->toString()],200);

        return;
    }

    public function openVotes(): void
    {
        $this->config['is_actived'] = true;
        $this->config['is_finished'] = false;
        $this->saveConfig();

        $alertVote = new BasicAlert(true);
        $alertVote->setMessage("¡Votaciones abiertas!");

        $this->requestJson->requestJsonEncode(['msg' => '¡Votaciones abiertas!', 'alert' => $alertVote->toString()],200);
        return;
    }

    public function closeVotes(): void
    {
        $this->config['is_actived'] = false;
        $this->saveConfig();

        $alertVote = new BasicAlert(true);
        $alertVote->setMessage("¡Votaciones cerradas!");

        $this->requestJson->requestJsonEncode(['msg' => '¡Votaciones cerradas!', 'alert' => $alertVote->toString()],200);
        return;
    }

    public function finishVotes(): void
    {
        $this->config['is_finished'] = true;
        $this->saveConfig();

        $alertVote = new BasicAlert(true);
        $alertVote->setMessage("¡Votaciones finalizadas!");

        $this->requestJson->requestJsonEncode(['msg' => '¡Votaciones finalizadas!', 'alert' => $alertVote->toString()],200);
        return;
    }
  
}
