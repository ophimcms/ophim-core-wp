<?php

class OFim_AdminCrawl_Controller{
    private $cache;
    public function __construct(){
        $this->cache = new oCache();
    }

    public function display(){
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

        $schedule_log = $this->getLastLog();
        include_once(OFIM_TEMPLADE_PATCH."/backend/crawl.php"); // included template file
    }
    public function getLastLog() {
        $log_path = WP_CONTENT_DIR  . '/crawl_ophim_logs';
        $log_filename = 'log_' . date('d-m-Y') . '.log';
        $log_data = $log_path.'/'.$log_filename;
        if (file_exists($log_data)) {
            $log = file_get_contents($log_data);
        }else{
            $log = "The file $log_filename does not exist";
        }
        return array(
            'log_filename' => $log_filename,
            'log_data' => $log
        );
    }

}