<?php
namespace MVC\Controllers\OurDjs;

use Engine\Core\IController;

class Index extends IController
{

    function __construct()
    {
        parent::__construct();
    }

    public function prepare()
    {
        
        $this->setVar('biel-text',[
            'src'           => 'Assets/Images/TeamPhoto/IMG_3489.JPG',
            'name'          => 'Biel',
            'description'   => 'Lo que realmente me apasiona del mundo del DJ es la capacidad de romper con lo convencional y sorprender al público con mezclas innovadoras y emocionantes. Creo firmemente que la música no debe ser plana ni predecible; por eso, siempre busco crear sets que destaquen y ofrezcan una experiencia única en cada presentación. Aunque mi especialidad es el tech house, disfruto explorando y fusionando diferentes géneros, lo que me permite adaptarme a cualquier estilo musical según el ambiente y la energía del público. Me considero un perfeccionista, y cada vez que me pongo detrás de los platos, intento superar mis propios límites, buscando mejorar y evolucionar constantemente en mi técnica y creatividad.',
        ]);

        $this->setVar('ntk-text',[
            'src'           => 'Assets\Images\TeamPhoto\FuentesTheLake_SergiLopez 3.jpg',
            'name'          => 'NTK',
            'description'   => 'La música siempre ha formado gran parte de mi vida, me encanta llegar a crear sonidos especiales, con gran capacidad de adaptación entre estilos, mis sessiones no se componen de un genero unico, ya que me gusta mezclar cambios entre generos generando un ambierte unico y especial, siempre intento que el publico se sienta identificado con la musica que pongo, y que disfruten de la experiencia de la musica en directo.',
        ]);

        $this->setVar('sadi-text', [
            'src'           => 'Assets\Images\TeamPhoto\DSC_0010.JPG',
            'name'          => 'Sadi',
            'description'   => 'Para mí, ser DJ es mucho más que mezclar canciones; es crear una atmósfera única y conectar con la energía de la gente. Lo que más disfruto es llevar al público en un viaje sonoro que los haga sentir, bailar y olvidar el mundo exterior. Mi estilo se mueve entre el deep house y el techno melódico, siempre buscando esos ritmos que resuenan en el alma y hacen vibrar el cuerpo. Cada set es una nueva oportunidad para experimentar y fusionar sonidos, manteniendo siempre un equilibrio entre lo familiar y lo inesperado. Mi objetivo es que cada presentación sea inolvidable, y para lograrlo, trabajo constantemente en perfeccionar mi técnica y ampliar mis conocimientos musicales. Soy un firme creyente en la evolución, tanto en la música como en mi carrera, y eso me impulsa a desafiarme en cada actuación.'
        ]);

    }

    public function execute()
    {
    }

    public function finish()
    {   
    }

}

?>