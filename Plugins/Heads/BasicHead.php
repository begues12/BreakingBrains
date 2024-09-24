<?php

namespace Plugins\Heads;

use \Engine\Core\HTML;

class BasicHead extends HTML
{

    public function __construct()
    {
        parent::__construct('head');
        $this->compile();
    }

    private function compile()
    {
    }

}

?>