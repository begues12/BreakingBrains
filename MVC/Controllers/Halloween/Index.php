<?php

namespace MVC\Controllers\Halloween;

use Engine\Core\IController;
use Plugins\Alerts\BasicAlert\BasicAlert;
use Plugins\Tools\RequestJson;

class Index extends IController
{
    private $voteFilePath = 'Assets/Data/halloween_votes.json';
    private $votes;
    private $requestJson;

    public function prepare()
    {
        $this->requestJson = new RequestJson();

        $this->loadVotes();
        $this->setVar('votes', $this->votes);
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

    private function saveVotes()
    {
        file_put_contents($this->voteFilePath, json_encode($this->votes, JSON_PRETTY_PRINT));
    }

    public function vote(): void
    {
        $contestantId = $this->payload('id');
        
        if ($this->getCookie('voted_halloween')) {
            $alertVote = new BasicAlert(true, 'danger', 'fas fa-exclamation-triangle');
            $alertVote->setMessage("¡No puedes volver a votar!");

            $this->requestJson->requestJsonEncode(['msg' => "¡No puedes volver a votar!", 'alert' => $alertVote->toString()], 500);
            return;
        }

        if (isset($this->votes[$contestantId])) {
            $this->votes[$contestantId]['votes'] += 1;
        }

        $this->saveVotes();

        $this->setCookie('voted_halloween', true, time() + (86400 * 30));

        $alertVote = new BasicAlert(true);
        $alertVote->setMessage("¡Has votado!");

        $this->requestJson->requestJsonEncode(['msg' => '¡Tu voto se ha guardo!', 'alert' => $alertVote->toString()],200);
        return;
    }

    public function getVotes()
    {
        return is_array($this->votes) ? $this->votes : [];
    }
}
