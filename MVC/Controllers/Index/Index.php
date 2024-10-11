<?php
namespace MVC\Controllers\Index;

use Engine\Core\IController;
use Plugins\Alerts\LinkAlert\LinkAlert;

class Index extends IController
{

    function __construct()
    {
        parent::__construct();
    }

    public function prepare()
    {
        // Creación de la alerta para eventos
        $alert = new LinkAlert(true, 'dark', 'fa-ticket-simple');
        $alert->setMessage('🎃¡Nuevo evento de Halloween!🎃<br>👻¡No te lo pierdas!👻');
        $alert->setLink('?Ctrl=Halloween');

        $this->setVar('eventAlert', $alert);

        // Imágenes para la galería del equipo
        $this->setVar('galleryImages',
        [
            'Assets\Images\TeamPhoto\BielTheLake_SergiLopez 10.jpg',
            'Assets\Images\TeamPhoto\SadiTheLake_SergiLopez 1.jpg',
            'Assets\Images\TeamPhoto\FuentesTheLake_SergiLopez 2.jpg',
            'Assets\Images\TeamPhoto\BielTheLake_SergiLopez 18 (1).jpg',
            'Assets\Images\TeamPhoto\SadiTheLake_SergiLopez 9.jpg',
            'Assets\Images\TeamPhoto\FuentesTheLake_SergiLopez 1.jpg',
            'Assets\Images\TeamPhoto\BielTheLake_SergiLopez 18.jpg',
        ]);

        // Texto sobre el grupo BreakingBrains
        $this->setVar('BBText', "BreakingBrains es un destacado colectivo de DJs, radicado en Barcelona, conocido por su vibrante energía y talento incomparable en el ámbito de la música electrónica. Cada miembro aporta un estilo único, fusionando diversos géneros para crear sets envolventes que transportan a la audiencia a experiencias musicales inolvidables. Su habilidad para leer la atmósfera del público y adaptar su música los ha consolidado como referentes en la escena electrónica local, siendo reconocidos por su creatividad y precisión técnica.");
        $this->setVar('BBText2', "Más allá de su destreza técnica, BreakingBrains sabe cómo crear una atmósfera electrizante que mantiene a las pistas de baile vibrantes y llenas de energía. Como embajadores de la evolución constante de la música electrónica en Barcelona, elevan el nivel en cada una de sus actuaciones, destacando como uno de los grupos más innovadores y emocionantes de la actualidad.");
    }

    public function execute()
    {
    }

    public function finish()
    {   
    }
}
