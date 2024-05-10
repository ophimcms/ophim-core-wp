<?php

class OFim_AdminManager_Controller{

    public function __construct(){

    }

    public function display(){
        global $oController;
        $oController->getView('manager.php','/backend');


        $model = $oController->getModel('Movie','');
       // print_r($model->getAll());
    }

}