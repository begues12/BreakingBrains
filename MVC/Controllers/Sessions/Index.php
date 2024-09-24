<?php
namespace MVC\Controllers\Sessions;

use Engine\Core\IController;

class Index extends IController
{
    private $photos;
    private $photo_dir;

    function __construct()
    {
        parent::__construct();
    }

    public function prepare()
    {
        // Get all photos from Assets\Images\TeamPhoto
        $this->setVar('sessions', 
        [
            ['title' => 'NTK - Session #2', 'audio' => 'Assets\Audio\Sessions\NTK - Session#2.wav'],
        ]);

    }

    public function execute()
    {
    }

    public function finish()
    {   
    }

    public function getPhotos()
    {
        $this->photos = scandir($this->photo_dir);

        foreach($this->photos as $key => $photo)
        {
            if($photo == '.' || $photo == '..')
            {
                unset($this->photos[$key]);
            }
        }

        return $this->photos;
    }

}

?>