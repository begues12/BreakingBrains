<?php
namespace MVC\Controllers\Sessions;

use Engine\Core\IController;

class Index extends IController
{
    private $sessions;
    private $session_json;

    function __construct()
    {
        parent::__construct();
        // Definir el directorio donde se almacenan las sesiones de audio
        $this->session_json = 'Assets/Data/Sessions.json';
    }

    public function prepare()
    {
        $this->setVar('title', '📀 Sesiones');
        $this->setVar('sessions', $this->getSessions());
    }

    public function execute()
    {
    }

    public function finish()
    {
    }

    // Método para obtener archivos de audio
    public function getSessions()
    {
        return json_decode(file_get_contents($this->session_json), true);
    }
}

