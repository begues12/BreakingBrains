<?php

namespace MVC\Views\FrameworkEditor\Database;

use Engine\Core\IView;
use Engine\Core\HTML;
use Plugins\Icons\FontAwesome\Icon;
use Plugins\Icons\FontAwesome\ButtonIcon;

class ShowTables extends IView
{
    private $dataBaseName = '';
    private $tablesList = [];

    private $divHeaderContainer;
    private $buttonBack;
    private $iconBack;
    private $labelBack;
    private $h3subtitle;

    public function __construct()
    {
        parent::__construct();
        $this->isNotAPage();

        
    }

    public function prepare()
    {
        $this->dataBaseName = $this->getVar('dataBaseName');
        $this->tablesList = $this->getVar('tablesList');
      
    }

    public function compile()
    {
    }

    public function createObjects()
    {
        $this->divHeaderContainer = new HTML('div');
        $this->divHeaderContainer->setClasses(['bg-white', 'p-2']);
        $this->divHeaderContainer->setStyle([
            'position' => 'fixed',
            'z-index' => '90',
            'transform' => 'translateX(-100%)',
        ]);

        $this->buttonBack = new HTML('button');
        $this->buttonBack->setClasses(['btn', 'btn-primary', 'mb-2', 'p-1', 'd-fixed']);
        $this->buttonBack->setAttributes([
            'onclick' => 'showTable(this)',
            'href' => '?Ctrl=FrameworkEditor&Do=Database&Action=getDataBases',
        ]);

        $this->iconBack = new Icon('fa-arrow-left', '1x', 'white');
        $this->labelBack = new HTML('span');
        $this->labelBack->setText('    Return');

        $this->buttonBack->addElements([$this->iconBack, $this->labelBack]);

        $this->divHeaderContainer->addElement($this->buttonBack);

        $this->addBody($this->divHeaderContainer);

        $this->h3subtitle = new HTML('h3');
        $this->h3subtitle->setText('Tables of '.$this->dataBaseName);

        $this->addBody($this->h3subtitle);
        $i = 0;
        foreach($this->tablesList as $table)
        {
            $div = $this->createTableObject($table['Tables_in_'.$this->dataBaseName]);
            if ($i % 2 == 0)
            {
                $div->setStyle(['background-color' => '#f2f2f2']);
            }

            $this->addBody($div);
            $i++;
        }
    }

    private function createTableObject(string $tableName) : HTML
    {

       


        // Icon database in left side and name of database in right side
        $divContainer = new HTML('div');
        $divContainer->setClasses(['database-container','col-12', 'p-2']);

        $divTableContainer = new HTML('div');
        $divTableContainer->setClasses(['row', 'm-0', 'p-0']);

        $divATable = new HTML('div');
        $divATable->setClasses(['col-8', 'm-0', 'p-0']);

        $icon = new Icon('fa-table', '1x', 'primary', ['mt-auto', 'mb-auto']);

        $aTable = new HTML('a');
        $aTable->setStyle(['margin-left' => '10px']);
        $aTable->setAttributes([
            'href' => '?Ctrl=FrameworkEditor&Do=Database&Action=getColumns',
            'onclick' => 'showDataTable(this); return false;',
            'data-database' => $this->dataBaseName,
            'data-table' => $tableName
        ]);

        $labelName = new HTML('label');
        $labelName->setClasses(['database-name', 'float-left', 'font-weight-bold']);
        $labelName->setStyle(['font-size' => '15px', 'cursor' => 'pointer']);
        $labelName->setText($tableName);
        $labelName->setAttributes([
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => 'Show table '.$tableName,
        ]);
        
        $aTable->addElement($labelName);

        $divATable->addElements([$icon, $aTable]);

        $divActions = $this->getTableActionButtons($tableName);

        $divTableContainer->addElements([$divATable, $divActions]);

        $divContainer->addElement($divTableContainer);

        return $divContainer;
    }


    function getTableActionButtons(string $tableName) : HTML
    {
        $divActions = new HTML('div');
        $divActions->setClasses(['col-4', 'p-0']);

        $iconCreateEntity = new ButtonIcon('fa-code', '1x', 'primary', 'Create Entity');
        $iconCreateEntity->setAttribute('data-table-name', $tableName);
        $iconCreateEntity->setStyle(['margin-left' => '10px']);

        $iconDeleteTable = new ButtonIcon('fa-trash', '1x', 'danger', 'Delete Table');
        $iconDeleteTable->setAttribute('data-table-name', $tableName);
        $iconDeleteTable->setStyle(['margin-left' => '10px']);

        return $divActions->addElements([$iconCreateEntity, $iconDeleteTable]);
    }
} 
?>