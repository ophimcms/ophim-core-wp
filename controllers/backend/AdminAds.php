<?php

class OFim_AdminAds_Controller{

    public function __construct(){

    }

    public function display(){
        global $oController;
        $oController->getView('ads.php','/backend');
    }

}