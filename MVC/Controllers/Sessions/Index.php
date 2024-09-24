<?php
namespace MVC\Controllers\Sessions;

use Engine\Core\IController;
use getID3;

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
        // Obtener todas las sesiones de audio del directorio
        $this->setVar('sessions', $this->getSessionsWithMetadata());
    }

    // Método para obtener archivos de audio y sus metadatos
    public function getSessionsWithMetadata()
    {
        $getID3 = new getID3();  // Instancia de getID3
        $sessions = [];

        // Escanear el directorio de sesiones
        foreach (scandir($this->session_dir) as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            $filePath = $this->session_dir . '/' . $file;
            $fileInfo = $getID3->analyze($filePath);  // Obtener metadatos del archivo

            // Solo procesar archivos de audio
            if (isset($fileInfo['playtime_string'])) {
                $sessions[] = [
                    'title' => $fileInfo['tags']['id3v2']['title'][0] ?? pathinfo($file, PATHINFO_FILENAME),
                    'artist' => $fileInfo['tags']['id3v2']['artist'][0] ?? 'Desconocido',
                    'image' => $this->getCoverArt($fileInfo),
                    'audio' => $filePath,
                    'duration' => $fileInfo['playtime_string']
                ];
            }
        }

        return $sessions;
    }

    // Obtener la imagen de portada si está presente
    private function getCoverArt($fileInfo)
    {
        if (isset($fileInfo['id3v2']['APIC'][0]['data'])) {
            $imageData = $fileInfo['id3v2']['APIC'][0]['data'];
            $imageType = $fileInfo['id3v2']['APIC'][0]['image_mime'];
            return 'data:' . $imageType . ';base64,' . base64_encode($imageData);
        }
        return 'Assets/Images/default-cover.jpg';  // Imagen por defecto
    }

    public function render()
    {
        $this->renderView('Sessions/Index');
    }

    public function getTitle()
    {
        return 'Sesiones';
    }

    public function execute()
    {
        $this->prepare();
        $this->render();
    }
}
