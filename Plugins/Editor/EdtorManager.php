<?php

namespace Plugins\Editor;

use Engine\Core\HTML;
use Plugins\Editor\EditorView;

class EditorManager extends HTML
{

    private $config_file;
    private $data;

    public function __construct(string $config_file)
    {
        $this->config_file = $config_file;
    }

    public function initView(): HTMl
    {
        return new HTML('div');
    }

    private function getData(): void
    {
        // Get info from JSON
    }

    private function setDataType(): void
    {
        // Get from Data the type of the field
    }

    public function save(): void
    {
        // Get data and transform to
    }



}