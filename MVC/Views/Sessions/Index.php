<?php
namespace MVC\Views\Sessions;

use Engine\Core\IView;
use Engine\Utils\Header;
use Engine\Core\HTML;

class Index extends IView
{
    private $sessions;
    private $div_player;
    private $div_sessions_list;
    private $div_visualizer;

    public function prepare()
    {
        $this->setHeader(new Header());
        $this->sessions = $this->getVar('sessions'); // Obtener las sesiones preparadas en el controlador
    }

    public function createObjects()
    {
        // Contenedor del reproductor
        $this->div_player = new HTML('div', ['class' => 'audio-player-container']);
        $this->div_player->setStyle([
            'width' => '100%',
            'max-width' => '600px',
            'margin' => '50px auto'
        ]);

        // Contenedor del canvas para visualización de ondas
        $this->div_visualizer = new HTML('canvas', ['id' => 'audioVisualizer']);
        $this->div_visualizer->setStyle([
            'width' => '100%',
            'height' => '200px',
            'background-color' => '#222',
            'border-radius' => '10px',
            'margin-bottom' => '20px'
        ]);

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
        // Agregar el canvas para visualización de ondas y el reproductor de audio
        $this->addBody($this->div_visualizer);
        $this->addBody($this->div_player);
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
        // Cada sesión es un div con su título y un botón de reproducir
        $div_session = new HTML('div', ['class' => 'session-item']);
        $div_session->setStyle([
            'padding' => '10px',
            'width' => '80%',
            'margin' => '10px 0',
            'display' => 'flex',
            'justify-content' => 'space-between',
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
        $play_button->setClasses(['btn', 'btn-light']);
        $play_button->setAttribute('onclick', "playSession('" . $session['audio'] . "', '" . $session['title'] . "')");
        $play_button->setText('Reproducir');

        $div_session->addElement($session_title);
        $div_session->addElement($play_button);

        // Añadir cada sesión a la lista de sesiones
        $this->div_sessions_list->addElement($div_session);
    }
}

?>
