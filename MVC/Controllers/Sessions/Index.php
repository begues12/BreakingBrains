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
        $this->session_json = 'Assets\Data\Sessions.json';
    }

    public function prepare()
    {
        // Obtener todas las sesiones de audio del directorio con sus "metadatos" simples
        $this->setVar('sessions', $this->getSessions());
    }

    public function execute()
    {
        // Opcional: lógica de ejecución
    }

    public function finish()
    {
        // Opcional: lógica de finalización
    }

    // Método para obtener archivos de audio
    public function getSessions()
    {
        $this->setVar('sessions', json_decode(file_get_contents($this->session_json), true));
    }
}

