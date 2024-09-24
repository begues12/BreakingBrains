<?php
namespace MVC\Views\Sessions;

use Engine\Core\IView;
use Engine\Utils\Header;
use Engine\Core\HTML;

class Index extends IView
{
    private $sessions;
    private $div_sessions_list;

    public function prepare()
    {
        $this->setHeader(new Header());
        $this->sessions = $this->getVar('sessions'); // Obtener las sesiones preparadas en el controlador
    }

    public function createObjects()
    {
        // Contenedor para la lista de sesiones
        $this->div_sessions_list = new HTML('div', ['class' => 'sessions-list']);
        $this->div_sessions_list->setStyle([
            'display' => 'flex',
            'flex-direction' => 'column',
            'align-items' => 'center',
            'width' => '100%',
            'margin-top' => '20px',
        ]);

        // Crear la lista de sesiones de audio
        $this->createSessionsList();
    }

    public function compile()
    {
        // Agregar la lista de sesiones a la vista
        $this->addBody($this->div_sessions_list);
    }

    private function createSessionsList()
    {
        foreach ($this->sessions as $session) {
            $this->createSessionItem($session);
        }
    }

    private function createSessionItem(array $session)
    {
        // Cada sesión es un div con su título, botón de reproducción, visualizador y reproductor de audio
        $div_session = new HTML('div', ['class' => 'session-item']);
        $div_session->setStyle([
            'padding' => '10px',
            'width' => '80%',
            'margin' => '10px 0',
            'display' => 'flex',
            'flex-direction' => 'column',
            'align-items' => 'center',
            'background-color' => '#333',
            'color' => '#fff',
            'border-radius' => '8px',
        ]);

        // Título de la sesión
        $session_title = new HTML('span');
        $session_title->setText($session['title']);

        // Botón para reproducir la sesión
        $play_button = new HTML('button');
        $play_button->setClasses(['btn', 'btn-light', 'playPauseBtn']);
        $play_button->setAttribute('data-audio-src', $session['audio']);
        $play_button->setAttribute('data-title', $session['title']);
        $play_button->setText('Reproducir');

        // Visualizador de audio
        $audio_visualizer = new HTML('canvas', ['class' => 'audioVisualizer']);
        $audio_visualizer->setStyle([
            'width' => '100%',
            'height' => '200px',
            'background-color' => '#222',
            'border-radius' => '10px',
            'margin-bottom' => '20px',
        ]);

        // Reproductor de audio
        $audio_player = new HTML('audio', ['class' => 'audio-player']);
        $audio_player->setAttribute('controls', true);
        $audio_player->setStyle(['display' => 'none']); // Oculto, se controla mediante el botón

        // Añadir los elementos a la sesión
        $div_session->addElement($session_title);
        $div_session->addElement($play_button);
        $div_session->addElement($audio_visualizer);
        $div_session->addElement($audio_player);

        // Añadir cada sesión a la lista de sesiones
        $this->div_sessions_list->addElement($div_session);
    }
}
?>
