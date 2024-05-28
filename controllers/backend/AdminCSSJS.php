<?php

class OFim_AdminCSSJS_Controller{

    public function __construct(){

    }

    public function display(){
        global $oController;
        $oController->getView('cssjs.php','/backend');


    }

}