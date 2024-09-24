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
        // Cada sesión es un div con su título, imagen, visualizador y reproductor de audio
        $div_session = new HTML('div', ['class' => 'session-item']);

        // Imagen del artista con clase futurista
        $img = new HTML('img', ['src' => $session['image'], 'alt' => $session['title']]);
        $img->setClasses(['rotateVinyl']);
        $img->setStyle([
            'width' => '70px',
            'height' => '70px',
            'border-radius' => '50%',
            'border' => '2px solid #21d4fd',
            'object-fit' => 'cover',
            'margin-right' => '15px',
        ]);

        // Contenedor para el texto (Artista - Título)
        $text_container = new HTML('div', ['class' => 'text-container']);
        $text_container->setStyle([
            'flex-grow' => '1',
            'display' => 'flex',
            'flex-direction' => 'column',
        ]);

        // Título de la sesión (Artista - Título)
        $session_title = new HTML('span', ['class' => 'session-title']);
        $session_title->setText($session['title']);
        $session_title->setStyle([
            'color' => '#21d4fd',
        ]);

        // Contenedor para la barra de progreso y el texto de tiempo
        $progress_container = new HTML('div', ['class' => 'progress-container']);
        $progress_container->setStyle([
            'display' => 'flex',
            'align-items' => 'center',
            'margin-top' => '10px',
        ]);

        // Barra de progreso del audio
        $audio_progress = new HTML('input', ['type' => 'range', 'class' => 'audio-progress']);
        $audio_progress->setStyle([
            'flex-grow' => '1',
            'margin-right' => '10px',
        ]);
        $audio_progress->setAttribute('value', '0');
        $audio_progress->setAttribute('max', '100');
        $audio_progress->setAttribute('step', '1');

        // Contenedor de tiempo (mm:ss/mm:ss)
        $time_display = new HTML('span', ['class' => 'time-display']);
        $time_display->setText('00:00/00:00');
        $time_display->setStyle([
            'color' => '#21d4fd',
            'font-size' => '14px',
            'white-space' => 'nowrap',
        ]);

        // Reproductor de audio
        $audio_player = new HTML('audio', ['class' => 'audio-player']);
        $audio_player->setAttribute('src', $session['audio']);
        $audio_player->setStyle(['display' => 'none']); // Oculto, se controla mediante el botón

        // Botón de Play/Pausa
        $play_button = new HTML('button', ['class' => 'playPauseBtn']);
        $play_button->setStyle([
            'background-color' => 'transparent',
            'border' => 'none',
            'cursor' => 'pointer',
            'font-size' => '24px',
            'margin-right' => '10px',
            'color' => '#21d4fd',
        ]);
        $play_button->setAttribute('data-audio-src', $session['audio']);
        $play_button->setText('▶'); // Icono de Play

        // Añadir los elementos a los contenedores
        $progress_container->addElement($audio_progress);
        $progress_container->addElement($time_display);

        // Añadir los elementos al contenedor de texto
        $text_container->addElement($session_title);
        $text_container->addElement($progress_container);

        // Añadir los elementos al div de la sesión
        $div_session->addElement($img);          // Imagen del artista
        $div_session->addElement($play_button);  // Botón de Play/Pausa
        $div_session->addElement($text_container); // Contenedor del título y barra de progreso
        $div_session->addElement($audio_player); // Reproductor de audio

        // Añadir cada sesión a la lista de sesiones
        $this->div_sessions_list->addElement($div_session);
    }
}
?>
