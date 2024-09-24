<?php
namespace MVC\Controllers\FrameworkEditor;

use Engine\Core\IController;
use Plugins\Database\MySqli;
use Plugins\Alerts\BasicAlert\BasicAlert;
use Engine\Config;

class Database extends IController
{

    private $config;

    function __construct()
    {
        parent::__construct();
        $this->BlockByIp();
        $this->config = new Config();
        $database = $this->config->get('database');

        $this->setVar('username',  $database['username']);
        $this->setVar('password',  $database['password']);
        $this->setVar('host',      $database['host']);
        $this->setVar('port',      $database['port']);
    }

    public function prepare()
    {
     
    }

    public function execute()
    {
    }

    public function finish()
    {   
    }

    public function autenticateSQL() : void
    {

        // Obtener datos de conexión
        $bdUser     = $this->post('username');
        $bdPassword = $this->post('password');
        $bdHost     = $this->post('host');
        $bdPort     = $this->post('port');

        try{

            // Conectar a la base de datos
            $mysqli = new MySqli($bdHost, $bdUser, $bdPassword, (int)$bdPort, '');
            $status = $mysqli->testConnection();

            if ($status) {

                // Guardar datos de conexión en el archivo de configuración
                $config = new Config();
                $config->set('database', 'host', $bdHost);
                $config->set('database', 'username', $bdUser);
                $config->set('database', 'password', $bdPassword);
                $config->set('database', 'port', $bdPort);

                $alert = new BasicAlert(true);
                $alert->setMessage(' Conexión exitosa');
            }else{
                $alert = new BasicAlert(true, 'danger', 'fa-times-circle');
                $alert->setMessage(' Conexión fallida');
            }
        
        } catch (\Exception $e) {
            $alert = new BasicAlert(true, 'danger', 'fa-times-circle');
            $alert->setMessage(' Conexión fallida');
            $status = false;
        }
        
        // Enviar respuesta
        $data = [
            'status' => $status,
            'html' => $alert->toString()
        ];

        echo json_encode($data);
    }

    public function getDataBases()
    { 
        $database = $this->config->get('database');
        $mysqli = new MySqli($database['host'], $database['username'], $database['password'], (int)$database['port'], '');
        $data = $mysqli->getDataBases();

        $dataBases = [];
        foreach ($data as $key => $value) {
            $dataBases[] = $value['Database'];
        }

        $view = new \MVC\Views\FrameworkEditor\Database\ShowDatabase();
        $view->setVars(['databaseList' => $dataBases]);
        echo $this->getOtherView($view);
    }

    public function getTables()
    {
        $database = $this->config->get('database');
        $mysqli = new MySqli($database['host'], $database['username'], $database['password'], (int)$database['port'], '');
        $data = $mysqli->getTables($this->get('Database'));

        $view = new \MVC\Views\FrameworkEditor\Database\ShowTables();
        $view->setVars(['dataBaseName' => $this->get('Database'), 'tablesList' => $data]);
        echo $this->getOtherView($view);
    }

    public function getColumns()
    {
        $databaseName   = $this->post('data-database');
        $tableName      = $this->post('data-table');

        $database   = $this->config->get('database');
        $mysqli     = new MySqli(
            $database['host'],
            $database['username'],
            $database['password'],
            (int)$database['port'],
            $databaseName
        );

        $columnsNames   = $mysqli->getColumns($databaseName, $tableName);
        $tableData      = $mysqli->select($tableName);

        $view = new \MVC\Views\FrameworkEditor\Database\ShowDataTable();
        $view->setVars([
            'data-database' => $databaseName,
            'data-table'    => $tableName,
            'data-columns'  => $columnsNames,
            'data-tabledata' => $tableData
        ]);

        echo $this->getOtherView($view);
    }
}

?>