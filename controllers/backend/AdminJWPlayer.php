<?php

class OFim_AdminJWPlayer_Controller{

    public function __construct(){

    }

    public function display(){
        global $oController;
        $oController->getView('jwplayer.php','/backend');


    }

}