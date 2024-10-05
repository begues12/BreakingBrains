<?php
namespace MVC\Views\Sessions;

use Engine\Core\IView;
use Engine\Utils\Header;
use Engine\Core\HTML;
use Plugins\Wave\SoundWave\SoundWavePlayer;

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
            'display' => 'grid',
            'grid-template-columns' => 'repeat(auto-fit, minmax(300px, 1fr))',
            'gap' => '20px',
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
        $div_session->setStyle([
            'border' => '4px solid transparent',
            'background-color' => '#333',
            'padding' => '15px',
            'border-radius' => '10px',
            'margin-left' => 'auto',
            'margin-right' => 'auto',
        ]);
    
        // Crear el plugin SoundWavePlayer para cada sesión
        $soundwavePlayer = new SoundWavePlayer($session['image'], $session['audio'], $session['title']);
    
        // Añadir el SoundWavePlayer al div de la sesión
        $div_session->addElement($soundwavePlayer);
    
        // Añadir cada sesión a la lista de sesiones
        $this->div_sessions_list->addElement($div_session);
    }
}
?>
