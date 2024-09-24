<?php
namespace MVC\Controllers\FrameworkEditor;

use Engine\Core\IController;

class Pages extends IController
{

    function __construct()
    {
        parent::__construct();
        $this->BlockByIp();
    }

    public function prepare()
    {
        // Get tree of files in MVC Controller, Views Js and Css
        $tree = $this->orderTree($this->getTree());
        pre_array($tree);
    }

    public function execute()
    {
    }

    public function finish()
    {   
    }

    private function getTree($path = 'MVC') : array
    {
        /*
        strucutre => [
            'PageName' => [
                'Controller' => 'ControllerFile', 
                'Views' => 'viewsFile', 
                'Js' => 'jsFile', 
                'Css' => 'cssFile'
                ]
        ]*/

        $paths = [

        ];

        $files = scandir($path);

        foreach($files as $file)
        {
            if ($file != '.' && $file != '..')
            {
                if (is_dir($path . '/' . $file))
                {
                    $paths[$file] = $this->getTree($path . '/' . $file);
                }
                else
                {
                    $paths[$file] = $file;
                }
            }
        }
        return $paths;
    }

    private function orderTree(array $tree): array
    {

        $orderderTree = [];

        

        return $tree;
    }
}

?>