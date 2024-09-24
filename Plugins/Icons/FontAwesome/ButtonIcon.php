<?php
namespace Plugins\Icons\FontAwesome;

use Engine\Core\HTML;

class ButtonIcon extends HTML
{   
    private $iIcon;
    private $icon;
    private $size;
    private $color;
    private $toolTipTitle;
    private $classes;


    /*
    *   @param string $icon
    *   @param string $size
    *   @param string $color
    *   @param string $toolTipTitle
    *   @param array $classes
    */

    public function __construct(string $icon, string $size = '1x', string $color = 'black',string $toolTipTitle = '', array $classes = [])
    {
        parent::__construct('button');
        $this->setClasses(['btn', 'btn-transparent', 'border-0']);

        $this->iIcon = new HTML('i');
        $this->icon = $icon;
        $this->size = $size;
        $this->color = $color;
        $this->toolTipTitle = $toolTipTitle;
        $this->classes = $classes;

        $this->iIcon->setClasses([
            'fa',
            $this->icon,
            'fa-' . $this->size,
            'text-' . $this->color,
        ]);

        if ($this->toolTipTitle != '')
        {
            $this->iIcon->setAttributes([
                'data-toggle' => 'tooltip',
                'data-placement' => 'top',
                'title' => $this->toolTipTitle
            ]);
        }

        $this->setClasses($this->classes);

        $this->addElement($this->iIcon);
        
        $this->setJsFile('Plugins\Icons\FontAwesome\Js\StartIcon.js');
    }

}

?>