<?php
namespace Engine\Utils;

use Plugins\Headers\BasicHeader\BasicHeader;

class EditorHeader extends BasicHeader{

    public function __construct()
    {
        parent::__construct();
        $this->setTitle('Fountain Editor');
        $this->setTitleLink('?Ctrl=FrameworkEditor');
        $this->addHeaderLink('Home', '?Ctrl=FrameworkEditor', true);
        $this->addHeaderLink('Pages', '?Ctrl=FrameworkEditor&Do=Pages');
        $this->addHeaderLink('Status', '?Ctrl=FrameworkEditor&Do=Status');
        $this->addHeaderLink('Plugins', '?Ctrl=FrameworkEditor&Do=Plugins');
        $this->addHeaderLink('Entities', '?Ctrl=FrameworkEditor&Do=Entities');
        $this->addHeaderLink('Database', '?Ctrl=FrameworkEditor&Do=Database');
        $this->addHeaderLink('Configuration', '?Ctrl=FrameworkEditor&Do=Configuration');

        $this->addHeaderLink('Return to site', '?', null, ['bg-primary', 'text-white', 'rounded'], ['text-white']);
    }

}
