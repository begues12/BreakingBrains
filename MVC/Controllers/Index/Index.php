<?php
namespace MVC\Controllers\Index;

use Engine\Core\IController;

class Index extends IController
{

    function __construct()
    {
        parent::__construct();
    }

    public function prepare()
    {
        $this->setVar('galleryImages',
        [
            'Assets\Images\TeamPhoto\BielTheLake_SergiLopez 10.jpg',
            'Assets\Images\TeamPhoto\SadiTheLake_SergiLopez 1.jpg',
            'Assets\Images\TeamPhoto\FuentesTheLake_SergiLopez 2.jpg',
            'Assets\Images\TeamPhoto\BielTheLake_SergiLopez 18 (1).jpg',
            'Assets\Images\TeamPhoto\SadiTheLake_SergiLopez 9.jpg',
            'Assets\Images\TeamPhoto\FuentesTheLake_SergiLopez 1.jpg',
            'Assets\Images\TeamPhoto\BielTheLake_SergiLopez 18.jpg',
        ]);
    }

    public function execute()
    {
    }

    public function finish()
    {   
    }
}

?>