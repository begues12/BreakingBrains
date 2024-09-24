<?php

namespace MVC\Views\FrameworkEditor\Database;

use Engine\Core\IView;
use Engine\Core\HTML;
use Plugins\Icons\FontAwesome\Icon;

class ShowDatabase extends IView
{
    private $databaseList = [];
    private $titleBase;

    public function __construct()
    {
        parent::__construct();
        $this->isNotAPage();
    }

    public function prepare()
    {
        $this->databaseList = $this->getVar('databaseList');

        $this->titleBase = new HTML('h3');
        $this->titleBase->setText('Databases');

        $this->addBody($this->titleBase);
        
        $i = 0;
        foreach($this->databaseList as $database)
        {
            $div = $this->createDatabaseObject($database);

            if ($i % 2 == 0)
            {
                $div->setStyle(['background-color' => '#f2f2f2']);
            }

            $this->addBody($div);
            $i++;
        }
    }

    public function compile()
    {
    }

    public function createObjects()
    {
    }

    private function createDatabaseObject(string $name) : HTML
    {
        // Icon database in left side and name of database in right side
        $divContainer = new HTML('div');
        $divContainer->setClasses(['database-container', 'col-12', 'p-2']);

        $icon = new Icon('fa-database', '1x', 'primary', ['mt-auto', 'mb-auto']);

        $aDatabase = new HTML('a');
        $aDatabase->setStyle(['margin-left' => '10px']);
        $aDatabase->setAttributes([
            'href' => '?Ctrl=FrameworkEditor&Do=Database&Action=getTables&Database='.$name,
            'onclick' => 'showTable(this); return false;'
        ]);

        $labelName = new HTML('label');
        $labelName->setClasses(['database-name', 'font-weight-bold', 'text-primary']);
        $labelName->setStyle(['font-size' => '15px', 'cursor' => 'pointer']);
        $labelName->setText($name);

        $divContainer->addElements([$icon, $aDatabase]);
        $aDatabase->addElement($labelName);

        return $divContainer;
    }

} 
?>