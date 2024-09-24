<?php
namespace MVC\Controllers\Photos;

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
        $this->setVar('photos', $this->getPhotos());

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