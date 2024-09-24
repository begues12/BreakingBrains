<?php
namespace Plugins\Icons\FontAwesome;

use Engine\Core\HTML;

class LinkIcon extends HTML
{   
    private $button;
    private $iIcon;
    private $icon;
    private $size;
    private $color;
    private $href;
    private $toolTipTitle;
    private $classes;


    /*
    *   @param string $icon
    *   @param string $size
    *   @param string $color
    *   @param string $toolTipTitle
    *   @param array $classes
    */

    public function __construct(string $icon, string $size = '1x', string $color = 'black', string $href='', string $toolTipTitle = '', array $classes = [])
    {
        parent::__construct('a');
        $this->setAttribute('href', $href);
        $this->setStyle(['text-decoration' => 'none']);

        $this->button = new HTML('button');
        $this->button->setClasses(['btn', 'btn-transparent', 'border-0']);
        $this->iIcon = new HTML('i');
        $this->icon = $icon;
        $this->size = $size;
        $this->color = $color;
        $this->href = $href;
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
        $this->addElement($this->button);
        
        
        $this->setJsFile('Plugins\Icons\FontAwesome\Js\StartIcon.js');
    }

}

?>