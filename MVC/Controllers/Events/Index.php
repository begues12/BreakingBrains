<?php
namespace MVC\Controllers\Events;

use Engine\Core\IController;

class Index extends IController
{
    private $events_json;

    function __construct()
    {
        parent::__construct();
        $this->events_json = 'Assets/Data/Events.json';
    }

    public function prepare()
    {
        // Get all photos from Assets\Images\TeamPhoto
       
        $this->setVar('events',$this->getEvents());

    }

    public function execute()
    {
    }

    public function finish()
    {   
    }

    public function getEvents()
    {
        return json_decode(file_get_contents($this->events_json), true);
    }

    public function editor()
    {
        
    }

}

?>