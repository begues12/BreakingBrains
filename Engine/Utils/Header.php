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
        
        $this->addHeaderLink('Home', '?', true, iconClass: 'fas fa-home');
        $this->addHeaderLink('Sessions', '?Ctrl=Sessions', iconClass: 'fas fa-music');
        $this->addHeaderLink('Photos', '?Ctrl=Photos', iconClass: 'fas fa-camera');
        // $this->addHeaderLink('About Us', '?Ctrl=AboutUs', iconClass: 'fas fa-microphone');
        $this->addHeaderLink('Contact Us', '?Ctrl=Contact', iconClass: 'fas fa-headset');

        if(in_array($_SERVER['REMOTE_ADDR'], $config->get('ipEditor')['whitelist']))
        {
            // $this->addHeaderLink('Framework Editor', '?Ctrl=FrameworkEditor', null, ['bg-primary', 'text-white', 'rounded'], ['text-white']);
        }
    }

}

?>