<?php
namespace MVC\Controllers\Events;

use Engine\Core\IController;

class Index extends IController
{
    private $photos;
    private $photo_dir;

    function __construct()
    {
        parent::__construct();
        $this->photo_dir = 'Assets/Images/TeamPhoto';
    }

    public function prepare()
    {
        // Get all photos from Assets\Images\TeamPhoto
        $events = [
            [
                'src' => 'Assets\Images\Events\AmericanLake.jpeg',
                'name' => 'Summer Fest',
                'date' => '2024-09-30',
                'description' => 'The ultimate summer music festival. Join us for unforgettable nights filled with music and dance.'
            ],
            [
                'src' => 'Assets\Images\Events\AmericanLake.jpeg',
                'name' => 'Winter Ball',
                'date' => '2024-12-15',
                'description' => 'An exclusive winter gala event featuring top DJs and winter-themed decorations.'
            ],
            [
                'src' => 'Assets\Images\Events\AmericanLake.jpeg',
                'name' => 'Spring Break Bash',
                'date' => '2024-04-05',
                'description' => 'Celebrate spring break with us with amazing performances and special guests.'
            ],
            [
                'src' => 'Assets\Images\Events\AmericanLake.jpeg',
                'name' => 'Fall Fest',
                'date' => '2024-11-26',
                'description' => 'Join us for a fun-filled day of music, food, and games at our annual fall festival.'
            ]
            // Agregar más eventos según sea necesario
        ];
        $this->setVar('events',$events);

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