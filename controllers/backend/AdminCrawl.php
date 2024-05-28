<?php

class OFim_AdminCrawl_Controller{

    public function __construct(){

    }

    public function display(){

        global $oController;

        $categoryFromApi = file_get_contents(API_DOMAIN . "/the-loai");
        $categoryFromApi = json_decode($categoryFromApi);

        $countryFromApi = file_get_contents(API_DOMAIN . "/quoc-gia");
        $countryFromApi = json_decode($countryFromApi);
        $schedule_log = $oController->getLastLog();
        include_once(OFIM_TEMPLADE_PATCH."/backend/crawl.php"); // included template file
    }

}