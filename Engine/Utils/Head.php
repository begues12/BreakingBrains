<?php

namespace Engine\Utils;

use Plugins\Heads\BasicHead;
use Engine\Core\HTML;

class Head extends BasicHead
{

    public function __construct()
    {
        parent::__construct();
        
        $Title = new HTML('title');
        $Title->setText('BreakingBrains.es');
        $this->addElement($Title);

        $Icon = new HTML('link');
        $Icon->setAttribute('rel', 'icon');
        $Icon->setAttribute('type', 'image/x-icon');
        $Icon->setAttribute('href', 'Assets\Images\BreakingBrains\breakingbrains_transparent.png');
        $this->addElement($Icon);

        $LinkBootstrap = new HTML('link');
        $LinkBootstrap->setAttribute('rel', 'stylesheet');
        $LinkBootstrap->setAttribute('href', 'Engine\Utils\Apis\Bootstrap\5.0.2\bootstrap.min.css');

        $LinkMaterialIcons = new HTML('link');
        $LinkMaterialIcons->setAttribute('rel', 'stylesheet');
        $LinkMaterialIcons->setAttribute('href', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined');

        $LinkJquery = new HTML('script');
        $LinkJquery->setAttribute('src', 'Engine\Utils\Apis\jquery\jquery-3.6.0.min.js');

        $LinkBootstrapJs = new HTML('script');
        $LinkBootstrapJs->setAttribute('src', 'Engine\Utils\Apis\Bootstrap\5.0.2\bootstrap.bundle.min.js');

        $FontAwsome = new HTML('link');
        $FontAwsome->setAttribute('rel', 'stylesheet');
        $FontAwsome->setAttribute('href', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');

        $Meta = new HTML('meta');
        $Meta->setAttribute('name', 'viewport');
        $Meta->setAttribute('content', 'width=device-width, initial-scale=1');

        $this->addElements([
            $LinkBootstrap, 
            $LinkMaterialIcons, 
            $LinkJquery, 
            $LinkBootstrapJs, 
            $FontAwsome,
            $Meta
        ]);
    }

}