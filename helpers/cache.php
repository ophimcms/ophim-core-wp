<?php
class oCache {
    private $cacheDir;

    public function __construct($cacheDir = OFIM_CACHE_DIR) {
        $this->cacheDir = $cacheDir;
    }

    public function remember($cacheFile, $lifeTime, $callback) {
        if(intval($lifeTime) <= 0) $lifeTime = OFIM_CACHE_TIME * 365;

        $cfile = $this->cacheDir . $cacheFile;
        if (file_exists($cfile) && filemtime($cfile) + $lifeTime >= time()) {
            $dataFromCache = file_get_contents($cfile);
            $data = maybe_unserialize($dataFromCache);
        } else {
            $data = $callback();
            if($data) file_put_contents($cfile, serialize($data));
        }
        return $data;
    }
}
