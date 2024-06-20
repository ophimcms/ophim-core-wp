<?php

class OFim_AdminCrawl_Controller{
    private $cache;
    public function __construct(){
        $this->cache = new oCache();
    }

    public function display(){

        global $oController;

        $categoryFromApi = $this->cache->remember('ophim_the_loai', OFIM_CACHE_TIME, function() {
            try {
                $data = file_get_contents(API_DOMAIN . '/the-loai');
                $data = json_decode($data);
                return $data;
            } catch (Exception $e) {
                return null;
            }
        });

        $countryFromApi = $this->cache->remember('ophim_quoc_gia', OFIM_CACHE_TIME, function() {
            try {
                $data = file_get_contents(API_DOMAIN . '/quoc-gia');
                $data = json_decode($data);
                return $data;
            } catch (Exception $e) {
                return null;
            }
        });

        $schedule_log = $oController->getLastLog();
        include_once(OFIM_TEMPLADE_PATCH."/backend/crawl.php"); // included template file
    }

}