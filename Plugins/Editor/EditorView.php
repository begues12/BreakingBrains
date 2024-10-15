<?php

namespace Plugins\Editor;

use Engine\Core\HTML;

class EditorView extends HTML
{
    
    private $field = [];

    public function __construct(string $config_file)
    {
        parent::__construct('div');
        
        $this->field = [];
    }

    public function addField(string $type, string $name, array $attrib)
    {

        switch ($type){
            case "text":
                $this->addTextField($hash, $name)
        }

    }
    
    private function addTextField(string $hash, string $name)
    {
        
        $this->field[][] = [
            "type" => "text",
            "name" => $name,
        ];
    }


}