<?php
namespace Plugins\Icons\FontAwesome;

use Engine\Core\HTML;

class Icon extends HTML
{
    private $icon;
    private $size;
    private $color;
    private $classes;

    public function __construct(string $icon, string $size = '1x', string $color = 'black', array $classes = [])
    {
        parent::__construct('i');
        $this->icon = $icon;
        $this->size = $size;
        $this->color = $color;
        $this->classes = $classes;
        $this->setTag('i');

        $this->setClasses([
            'fa',
            $this->icon,
            'fa-' . $this->size,
            'text-' . $this->color
        ]);

        $this->setClasses($this->classes);

        $this->setJsFile('Plugins\Icons\FontAwesome\Js\StartIcon.js');
        
    }

}

?>