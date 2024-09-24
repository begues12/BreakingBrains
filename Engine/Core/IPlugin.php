<?php

namespace Engine\Core;

use Engine\Config;

class IPlguin
{

    private $name = '';
    private $version = '';
    private $author = '';
    private $description = '';
    private $url = '';
    private $path = '';
    private $config;
    private $enabled = false;

    public function __construct($name, $version, $author, $description, $url, $path, $enabled)
    {
        $this->config = new Config();
        $this->name = $name;
        $this->version = $version;
        $this->author = $author;
        $this->description = $description;
        $this->url = $this->config->get('plugins','url');
        $this->path = $this->config->get('plugins','path');
        $this->enabled = $enabled;
    }

    public function download()
    {
        $content = file_get_contents($this->url . '/'. $this->name.'.zip');

        if ($content !== false)
        {
            // Create the Directory
            if (!file_exists($this->path))
            {
                mkdir($this->path.'/'.$this->name, 0777, true);
            }

            if (file_put_contents($this->path.'/'.$this->name.'.zip', $content) !== false)
            {
                // Decompress the file
                $zip = new \ZipArchive;

                if ($zip->open($this->path.'/'.$this->name.'.zip') === true)
                {
                    $zip->extractTo($this->path."/".$this->name);
                    $zip->close();
                    unlink($this->path.'/'.$this->name.'.zip');

                    // Get folder files and except ".files"

                    return true;
                }
            }
        }

    }

    public function getInfo()
    {
    }

    public function install()
    {
        // Get file install.php class install only __construct
        
        $install = $this->path.'/'.$this->name.'/.install.php';

        require_once($install);

        $class = str_replace('/', '\\', $this->path.'/'.$this->name.'/install');

        $installer = new $class();

        $installer->install();

        return true;
    }

    public function getIcon()
    {
        return $this->url . '/icon.png';
    }

    public function getName()
    {
        return $this->name;
    }

}


?>