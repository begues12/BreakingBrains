<?php

namespace MVC\Views\FrameworkEditor\Database;

use Engine\Core\IView;
use Engine\Core\HTML;
use Plugins\Icons\FontAwesome\Icon;

class ShowDataTable extends IView
{
    private $dataBaseName = '';
    private $tableName = '';
    private $columns = [];
    private $tableData = [];

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
        $this->dataBaseName = $this->getVar('data-database');
        $this->tableName    = $this->getVar('data-table');
        $this->columns      = $this->getVar('data-columns');
        $this->tableData    = $this->getVar('data-tabledata');
    }

    public function compile()
    {
    }

    public function createObjects()
    {
        $this->divHeaderContainer = new HTML('div');
        $this->divHeaderContainer->setClasses(['p-2']);
        $this->divHeaderContainer->setStyle([
            'position' => 'fixed',
            'z-index' => '90',
            'transform' => 'translateX(-100%)',
        ]);

        $this->buttonBack = new HTML('button');
        $this->buttonBack->setClasses(['btn', 'p-1', 'btn-primary']);
        $this->buttonBack->setAttributes([
            'onclick' => 'showTable(this)',
            'href' => '?Ctrl=FrameworkEditor&Do=Database&Action=getTables&Database='.$this->dataBaseName
        ]);

        $this->iconBack = new Icon('fa-arrow-left', '1x', 'white');
        $this->labelBack = new HTML('span');
        $this->labelBack->setText('   Return');

        $this->buttonBack->addElements([$this->iconBack, $this->labelBack]);

        $this->divHeaderContainer->addElement($this->buttonBack);

        $this->addBody($this->divHeaderContainer);

        $this->h3subtitle = new HTML('h3');
        $this->h3subtitle->setText('Data of '.$this->tableName." [".$this->dataBaseName."]");

        $this->addBody($this->h3subtitle);

        $table = new HTML('table');

        $table->setClasses(['table', 'table-striped', 'table-hover']);

        $table->addElement($this->createTableHeader());

        $table->addElement($this->createTableData());

        $this->addBody($table);
       
    }

    private function createTableHeader() : HTML
    {
        $thead = new HTML('thead');

        $tr = new HTML('tr');
        $tr->setClasses(['sticky-top', 'bg-white']);

        foreach($this->columns as $column)
        {
            $th = new HTML('th');

            // If is primary key, set color to red
            if($column['Key'] == 'PRI')
            {
                $icon = new Icon('fa-key', '1x', 'primary', ['d-inline']);
                $icon->setStyle(['margin-right' => '5px']);
                $th->addElement($icon);
            }else if($column['Key'] == 'MUL') {
                $icon = new Icon('fa-key', '1x', 'secondary', ['d-inline']);
                $icon->setStyle(['margin-right' => '5px']);
                $th->addElement($icon);
            }
            $label = new HTML('label');
            $label->setClasses(['d-inline']);
            $label->setText($column['Field']);
            $th->addElement($label);

            $tr->addElement($th);
        }

        $thead->addElement($tr);

        return $thead;
    }

    private function createTableData() : HTML
    {
        $tbody = new HTML('tbody');

        foreach($this->tableData as $row)
        {
            $tr = new HTML('tr');

            foreach($row as $column)
            {
                $td = new HTML('td');
                $td->setText($column);
                $tr->addElement($td);
            }

            $tbody->addElement($tr);
        }

        return $tbody;
    }

} 
?>