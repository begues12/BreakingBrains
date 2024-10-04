<?php
namespace Plugins\Wave\SoundWave;

use Engine\Core\HTML;

class SoundWavePlayer extends HTML
{
    private $audioSrc;
    private $imageSrc;
    private $trackName;
    private $canvas;
    private $audioElement;
    private $playButton;
    private $timeDisplay;

    public function __construct(string $imageSrc, string $audioSrc, string $trackName)
    {
        parent::__construct('div', ['class' => 'soundwave-player']);
        $this->audioSrc = $audioSrc;
        $this->imageSrc = $imageSrc;
        $this->trackName = $trackName;

        // Crear los elementos HTML necesarios
        $this->createPlayerElements();

        // Añadir el script externo para manejar la visualización de ondas de sonido
        $this->setJsFile('Plugins/Wave/SoundWave/Js/SoundWave.js');
        // Añadir el archivo de estilos CSS
        $this->setCssFile('Plugins/Wave/SoundWave/Css/SoundWave.css');
    }

    private function createPlayerElements()
    {
        // Imagen del track/artista
        $image = new HTML('img', ['src' => $this->imageSrc, 'alt' => $this->trackName]);
        $image->setStyle([
            'width' => '70px',
            'height' => '70px',
            'border-radius' => '50%',
            'border' => '2px solid #21d4fd',
            'object-fit' => 'cover',
            'margin-right' => '15px',
            'align-self' => 'center', // Centrando la imagen dentro del contenedor
        ]);

        // Contenedor de texto con el nombre del track
        $textContainer = new HTML('div', ['class' => 'text-container']);
        $textContainer->setStyle([
            'display' => 'flex',
            'flex-direction' => 'column',
            'justify-content' => 'center',
            'margin-bottom' => '10px',
            'align-items' => 'center'
        ]);

        // Título del track
        $trackTitle = new HTML('span', ['class' => 'track-title']);
        $trackTitle->setText($this->trackName);
        $trackTitle->setStyle([
            'color' => '#21d4fd',
        ]);

        $textContainer->addElement($image);
        $textContainer->addElement($trackTitle);

        // Reproductor de audio
        $this->audioElement = new HTML('audio', ['src' => $this->audioSrc, 'class' => 'audio-player']);
        $this->audioElement->setStyle(['display' => 'none']); // El elemento audio será controlado por el botón de Play

        // Botón de Play/Pausa
        $this->playButton = new HTML('button', ['class' => 'playPauseBtn']);
        $this->playButton->setStyle([
            'background-color' => 'transparent',
            'border' => 'none',
            'cursor' => 'pointer',
            'font-size' => '24px',
            'margin-right' => '15px',
            'color' => '#21d4fd',
        ]);
        $this->playButton->setText('▶'); // Icono de Play

        // Visualización del tiempo actual y duración total
        $this->timeDisplay = new HTML('span', ['class' => 'time-display']);
        $this->timeDisplay->setText('00:00/00:00');
        $this->timeDisplay->setStyle([
            'color' => '#21d4fd',
            'font-size' => '14px',
            'white-space' => 'nowrap',
            'margin-right' => '15px',
        ]);

        // Contenedor de controles (play, tiempo)
        $controlContainer = new HTML('div', ['class' => 'control-container']);
        $controlContainer->setStyle([
            'display' => 'flex',
            'align-items' => 'center',
            'justify-content' => 'center',
            'margin-bottom' => '10px',
        ]);

        // Añadir los controles al contenedor
        $controlContainer->addElement($this->playButton);
        $controlContainer->addElement($this->timeDisplay);

        // Canvas para la visualización de ondas de sonido
        $this->canvas = new HTML('canvas', ['class' => 'soundwave-canvas']);
        $this->canvas->setStyle([
            'width' => '100%',
            'height' => '70px',
            'background-color' => '#212529',
            'margin-top' => '10px',
        ]);

        // Añadir los elementos al contenedor principal (distribución en columna)
        $this->setStyle([
            'display' => 'flex',
            'flex-direction' => 'column',
            'align-items' => 'center',
            'width' => '100%',
            'flex-wrap' => 'wrap',
        ]);

        $this->addElement($textContainer);
        $this->addElement($controlContainer);
        $this->addElement($this->canvas);
        $this->addElement($this->audioElement);
    }
}
?>
