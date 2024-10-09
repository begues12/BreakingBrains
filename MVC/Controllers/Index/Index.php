<?php
namespace MVC\Controllers\Index;

use Engine\Core\IController;
use Plugins\Alerts\BasicAlert\BasicAlert;

class Index extends IController
{

    function __construct()
    {
        parent::__construct();
    }

    public function prepare()
    {
        $alert = new HTML('div', ['d-none']);
        if (!$this->getCookie('show_event_alert'))
        {
            $alert = new BasicAlert(true, 'info', 'fa-info-circle');
            $alert->setMessage('¡No te pierdas nuestro próximo evento!');
            
            $this->setCookie('show_event_alert', true, time() + 3600);
        }
        $this->setVar('eventAlert', $alert);

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

        $this->setVar('BBText', "BreakingBrains es un dinámico grupo de 3 DJs con sede en Barcelona, conocido por su energía inigualable y su talento excepcional para la música electrónica. Cada uno de los miembros aporta su propio estilo único, fusionando géneros y creando sets que llevan a su audiencia a un viaje sonoro inolvidable. Con su habilidad para leer al público y adaptarse a cualquier ambiente, se han convertido en una referencia en la escena local, destacando por su creatividad y técnica impecable. ");
        $this->setVar('BBText2', "No solo son excelentes en la cabina, sino que también son expertos en crear una atmósfera única que mantiene a las pistas de baile llenas de energía. BreakingBrains representa la evolución constante de la música electrónica en Barcelona, elevando el estándar con cada presentación.");
    }

    public function execute()
    {
    }

    public function finish()
    {   
    }
}

?>