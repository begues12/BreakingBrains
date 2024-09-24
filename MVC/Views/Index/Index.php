<?php

namespace MVC\Views\Index;

use Engine\Core\IView;
use Engine\Core\HTML;
use Engine\Utils\Header;
use Plugins\Wave\BasicWave\BasicWave;
use Plugins\Icons\FontAwesome\LinkIcon;

class Index extends IView{

    private $div_title;
    private $img_breaking;
    private $div_buttons;
    private $linkIcon_showMusic;
    private $linkIcon_showPhots;
    private $linkIcon_aboutUs;
    private $linkIcon_contactUs;
    private $linkIcon_instagram;
    private $waveEffect;

    public function prepare()
    {
        $this->setHeader(new Header());
    }

    public function createObjects()
    {

        $this->div_title = new HTML('div');
        $this->div_title->setClasses([
            'container',
            'text-center'
        ]);


        $this->img_breaking = new HTML('img');
        $this->img_breaking->setClasses([
            'ligthing-icon'
        ]);
        $this->img_breaking->setAttributes([
            'src' => 'Assets/Images/BreakingBrains/BreakingBrainsVinil.png',
            'alt' => 'Breaking Brains',
            'width' => '250px',
            'height' => '250px'
        ]);

        $this->div_buttons = new HTML('div');
        $this->div_buttons->setClasses([
            'container',
            'd-flex',
            'align-items-between',
            'justify-content-center',
            'w-50'
        ]);
        $this->div_buttons->setStyle([
            'margin-top' => '20px'
        ]);
        $this->div_buttons->setAttributes([
            'id' => 'buttons'
        ]);
        

        $button_classes = ['btn', 'btn-futuristic', 'mt-3', 'mx-2'];

        $this->linkIcon_showMusic = new LinkIcon(
            'fa-compact-disc', 
            '2x', 
            'white', 
            '?Ctrl=Sessions',
            'Sessions',
            $button_classes
        );

        $this->linkIcon_showPhots = new LinkIcon(
            'fa-camera-retro', 
            '2x', 
            'white', 
            '?Ctrl=Photos',
            'Photos',
            $button_classes
        );

        $this->linkIcon_aboutUs = new LinkIcon(
            'fa-microphone', 
            '2x', 
            'white',
            '?Ctrl=AboutUs', 
            'About Us', 
            $button_classes
        );

        $this->linkIcon_contactUs = new LinkIcon(
            'fa-headset', 
            '2x', 
            'white', 
            '?Ctrl=ContactUs',
            'Contact Us', 
            $button_classes);
        
        $this->linkIcon_instagram = new LinkIcon(
            'fa-square-instagram', 
            '2x', 
            'white', 
            'https://www.instagram.com/breakingbrainsdj/',
            'Instagram', 
            $button_classes
        );
        $this->waveEffect = new BasicWave(30, 100);


    }

    public function compile()
    {
        $this->addBody($this->div_title);
        $this->div_title->addElement($this->img_breaking);
        $this->addBody($this->div_buttons);
        $this->div_buttons->addElement($this->linkIcon_showMusic);
        $this->div_buttons->addElement($this->linkIcon_showPhots);
        // $this->div_buttons->addElement($this->linkIcon_aboutUs);
        $this->div_buttons->addElement($this->linkIcon_instagram);
        $this->div_buttons->addElement($this->linkIcon_contactUs);


        $this->addBody($this->waveEffect);
    }

}

?>