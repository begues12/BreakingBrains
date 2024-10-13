<?php

namespace Engine\Utils;

use Engine\Config;
use Plugins\Headers\BasicHeader\BasicHeader;

class Header extends BasicHeader{

    public function __construct()
    {
        parent::__construct();

        $config = new Config();

        $this->setCssFile('MVC\Css\Header\Index.css');
        
        $this->addHeaderLink('🏠 Menú',         '?', true, iconClass: 'fas fa-home');
        $this->addHeaderLink('📀 Sessiones',    '?Ctrl=Sessions', iconClass: 'fas fa-music');
        $this->addHeaderLink('📷 Galería',      '?Ctrl=Gallery', iconClass: 'fas fa-camera');
        $this->addHeaderLink('📅 Eventos',      '?Ctrl=Events', iconClass: 'fas fa-calendar-alt');
        $this->addHeaderLink('​🎛️​ Nuestros Djs', '?Ctrl=OurDjs', iconClass: 'fas fa-user');
        $this->addHeaderLink('🎧​ Contacto',     '?Ctrl=Contact', iconClass: 'fas fa-headset');

        if(in_array($_SERVER['REMOTE_ADDR'], $config->get('ipEditor')['whitelist']))
        {
            // $this->addHeaderLink('Framework Editor', '?Ctrl=FrameworkEditor', null, ['bg-primary', 'text-white', 'rounded'], ['text-white']);
        }
    }

}

?>