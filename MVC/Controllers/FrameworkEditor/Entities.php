<?php
namespace MVC\Controllers\FrameworkEditor;

use Engine\Core\IController;

class Entities extends IController
{

    function __construct()
    {
        parent::__construct();
        $this->BlockByIp();
    }

    public function prepare()
    {
    }

    public function execute()
    {
    }

    public function finish()
    {   
    }

    public function getStats()
    {
        $stats = [
            'cpu' => $this->getCpuStats(),
            'ram' => $this->getRamStats(),
            'disk' => 'Unknown',
            'os' => 'Unknown'
        ];

        echo json_encode($stats);
    }

    function getRamStats() {
    }
    
    function getCpuStats() {
    }
}
