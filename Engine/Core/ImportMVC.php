<?php
namespace Engine\Core;

use \Engine\Config;

class ImportMVC{

    public $ctrl;
    public $do;
    public $action;
    public $rootPath;
    public $Config;
    public $pathCtrl;
    public $pathView;
    public $pathAction;
    public $pathJs;
    public $pathCss;
    public $Vars = array();

    function __construct(){
        $this->ctrl = "Index";
        $this->do = "Index";
        $this->action = "";
        $this->Config = new Config();
    }

    public function getCtrl(){
        if (isset($_GET['Ctrl'])) {
            $this->setCtrl($_GET['Ctrl']);
        }
    }

    public function getDo(){
        if (isset($_GET['Do'])) {
            $this->setDo($_GET['Do']);
        }
    }

    public function getAction(){
        if (isset($_GET['Action'])) {
            $this->setAction($_GET['Action']);
        }
    }

    public function setCtrl($ctrl){
        $this->ctrl = $ctrl;
    }

    public function setDo($do){
        $do = str_replace("". DIRECTORY_SEPARATOR."", "". DIRECTORY_SEPARATOR."", $do);
        $this->do = $do;
    }

    public function setAction($action){
        $this->action = $action;
    }

    public function setVar($key, $value){
        $this->Vars[$key] = $value;
    }

    public function getVar($key){
        return $this->Vars[$key];
    }

    public function execute(){

        $this->getCtrl();
        $this->getDo();
        $this->getAction();

        $this->pathView   = "MVC". DIRECTORY_SEPARATOR."Views". DIRECTORY_SEPARATOR.$this->ctrl. DIRECTORY_SEPARATOR.$this->do;
        $this->pathCtrl   = "MVC". DIRECTORY_SEPARATOR."Controllers". DIRECTORY_SEPARATOR.$this->ctrl. DIRECTORY_SEPARATOR.$this->do;
        $this->pathAction = "MVC". DIRECTORY_SEPARATOR."Actions". DIRECTORY_SEPARATOR.$this->ctrl. DIRECTORY_SEPARATOR.$this->do. DIRECTORY_SEPARATOR.$this->action.".php";
        $this->pathJs     = "MVC". DIRECTORY_SEPARATOR."Js". DIRECTORY_SEPARATOR.$this->ctrl. DIRECTORY_SEPARATOR.$this->do.".js";
        $this->pathCss    = "MVC". DIRECTORY_SEPARATOR."Css". DIRECTORY_SEPARATOR.$this->ctrl. DIRECTORY_SEPARATOR.$this->do.".css";

        $this->pathCtrl   = str_replace("/", DIRECTORY_SEPARATOR, $this->pathCtrl);
        $this->action   = str_replace("/", DIRECTORY_SEPARATOR, $this->action);

        $this->pathCtrl   = str_replace("\\", DIRECTORY_SEPARATOR, $this->pathCtrl);
        $this->action   = str_replace("\\", DIRECTORY_SEPARATOR, $this->action);

        if(file_exists($this->pathCtrl.".php")){

            if($this->action != ""){

                try{

                    require_once $this->pathCtrl.".php";

                    $this->pathCtrl   = str_replace("/", "\\", $this->pathCtrl);
                    $this->action   = str_replace("/", "\\", $this->action);
                    
                    if ( class_exists($this->pathCtrl) ) {
                        if ( method_exists($this->pathCtrl, $this->action) ) {
                            try{
                                $contrl = $this->pathCtrl;
                                $controller = new $contrl();

                                if ($controller->isBlockedByIp())
                                {
                                    die('You dont have permission to access this page');
                                }

                                $controller->prepare();

                                call_user_func(array($controller, $this->action));

                            } catch(\Exception $e){
                                // http_response_code(500);
                            }
                            die();
                        }else{
                            die('Action not found '.$this->action);
                        }
                    }

                }catch(\Exception $e){
                    die($e);
                }

            }

        }else{
            die('Controller not found '.$this->pathCtrl.'.php');
        }

        $this->pathCtrl   = str_replace("/", DIRECTORY_SEPARATOR, $this->pathCtrl);
        $this->action   = str_replace("/", DIRECTORY_SEPARATOR, $this->action);

        $this->pathCtrl   = str_replace("\\", DIRECTORY_SEPARATOR, $this->pathCtrl);
        $this->action   = str_replace("\\", DIRECTORY_SEPARATOR, $this->action);

        if(file_exists($this->pathCtrl.".php")){
            
            if (file_exists($this->pathView.".php")) {

                try{
                    $this->pathCtrl   = str_replace("/", "\\", $this->pathCtrl);
                    $this->pathView   = str_replace("/", "\\", $this->pathView);

                    if ( class_exists($this->pathCtrl) ) {

                        $controller = new $this->pathCtrl;

                        if ($controller->isBlockedByIp())
                        {
                            die('You dont have permission to access this page');
                        }

                        $controller->setCtrlPath($this->pathCtrl);
                        $controller->setViewPath($this->pathView);

                        $controller->prepare();
                        
                        $view = new $this->pathView();
                        $view->setVars($controller->getVars());
                        $view->prepare();
                        $view->createObjects();
                        $view->compile();
                        $view->compileView();

                        if(file_exists($this->pathCss)){
                            echo "<link rel='stylesheet' href='".$this->pathCss."'>";
                        }
                        
                        $view->render();

                        if(file_exists($this->pathJs)){
                            echo "<script src='".$this->pathJs."'></script>";
                        }
                        
                    }else{
                        die('Class Controller not found '.$this->pathCtrl. "<br>In".$this->pathCtrl.".php");
                
                    }
                }catch(\Exception $e){
                    die('View File not found '.$this->pathView.".php<br>".$e);
                }
            
            }else{
                die('View File not found '.$this->Config->get('ROOT').$this->pathView.".php");
            }

        }else{
            die('Controller File not found '.$this->pathCtrl.".php");
        }

    }

}

?>