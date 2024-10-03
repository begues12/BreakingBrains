<?php

namespace Plugins\Wave\BasicWave;

use Engine\Core\HTML;

class BasicWave extends HTML
{
    private $waveDiv;
    private $barCount;
    private $barHeight;

    public function __construct(int $barCount = 20, int $barHeight = 100)
    {
        parent::__construct('div');
        $this->setAttribute('id', 'wave-container');
        $this->setAttribute('class', 'wave w-100');

        // Configuración dinámica
        $this->barCount = $barCount;
        $this->barHeight = $barHeight;

        // Agregar la referencia al archivo CSS y JS
        $this->setCssFile('Plugins/Wave/BasicWave/Css/BasicWave.css');
        $this->setJsFile('Plugins/Wave/BasicWave/Js/BasicWave.js');

        $this->waveDiv = new HTML('canvas');
        $this->waveDiv->setId('barCanvas');
        $this->waveDiv->setAttribute('class', 'bar-container');

        // Llamar al método para añadir las barras
        $this->addBars();

        $this->compile();
    }

    private function compile()
    {
        // Agregamos el div de barras animadas (bar-container) al contenedor principal
        $this->addElement($this->waveDiv);
    }

    private function addBars()
    {
        // Generamos las barras dinámicamente según la cantidad y altura que se haya definido
        for ($i = 0; $i < $this->barCount; $i++) {
            $bar = new HTML('div');
            $bar->setAttribute('class', 'bar');
            $bar->setStyle([
                'border-radius' => '2px',  // Bordes redondeados
                'height' => rand(10, $this->barHeight) . 'px',
                'width' => '6px',  // Distribuir el ancho de cada barra uniformemente
            ]);

            // Agregamos cada barra al contenedor principal
            $this->waveDiv->addElement($bar);
        }


        #Get screen width and height
    }
}

?>
