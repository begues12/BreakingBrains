<?php
namespace MVC\Controllers\Sessions;

use Engine\Core\IController;

class Index extends IController
{
    private $sessions;
    private $session_dir;

    function __construct()
    {
        parent::__construct();
        // Definir el directorio donde se almacenan las sesiones de audio
        $this->session_dir = 'Assets/Audio/Sessions';
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
        $sessions = [];

        // Escanear el directorio de sesiones
        foreach (scandir($this->session_dir) as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            // Solo procesar archivos de audio (puedes agregar más validaciones si necesitas)
            $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
            if (in_array(strtolower($fileExtension), ['mp3', 'wav', 'flac'])) {
                $filePath = $this->session_dir . '/' . $file;
                
                // Crear sesión con información básica
                $sessions[] = [
                    'title' => pathinfo($file, PATHINFO_FILENAME),  // El nombre del archivo sin extensión como título
                    'artist' => 'Artista Desconocido',              // Artista predeterminado
                    'image' => 'Assets\Images\BreakingBrains\BreakingBrainsVinil.png',   // Imagen predeterminada
                    'audio' => $filePath,                           // Ruta del archivo de audio
                    'duration' => 'Desconocido'                     // No podemos obtener la duración sin getID3
                ];
            }
        }

        return $sessions;
    }
}

