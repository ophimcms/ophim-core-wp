<?php

class oController {
    public function __construct($options = array())
    {
    }
    public function getLastLog() {
        $log_path = WP_CONTENT_DIR  . '/crawl_ophim_logs';
        $log_filename = 'log_' . date('d-m-Y') . '.log';
        $log_data = $log_path.'/'.$log_filename;
        return array(
            'log_filename' => $log_filename,
            'log_data' => file_get_contents($log_data)
        );
    }
    public function getController($filename ='', $dir =''){

        //require_once OFIM_CONTROLLERS_PATCH. DS. 'backend'. DS.'AdminManager.php';
        //$obj = new OFim_AdminManager_Controller();
        $obj = new stdClass();
        $file = OFIM_CONTROLLERS_PATCH. DS. $dir. DS.$filename.'.php';
        if(file_exists($file)){
            require_once $file;
            $controllerName = OFIM_PREFIX.$filename.'_Controller';
            $obj = new $controllerName ;
        }
        return $obj;
    }

    public function getModel($filename ='', $dir =''){
        $obj = new stdClass();
        $file = OFIM_MODELS_PATCH. DS. $dir. DS.$filename.'.php';
        if(file_exists($file)){
            require_once $file;
            $modelName = OFIM_PREFIX.$filename.'_Model';
            $obj = new $modelName ;
        }
        return $obj;
    }

    public function getHelper(){

    }

    public function getView($filename ='', $dir =''){
        //require_once OFIM_TEMPLADE_PATCH.DS.'backend'.DS.'manager.php';
        $file = OFIM_TEMPLADE_PATCH.DS.$dir.DS.$filename;
        if(file_exists($file)){
            require_once $file;
        }
    }

    public function getValidate(){

    }

    public function getCssUrl(){

    }

    public function getImageUrl(){

    }
}