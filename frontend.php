<?php

class oFim_Frontend
{

    public function __construct()
    {

    }

    function router()
    {
        $publicdir = OFIM_PUBLIC_URL;
        $title = get_bloginfo('name');
        $url = $this->getUrl();

        if (isset($url[2])) {
            if ($url[2] == 'admin' || str_contains($url[2],'login')) {

            } elseif ($url[2] == 'the-loai') {
                echo 'thể loại';
            } elseif ($url[2] == 'quoc-gia') {
                echo 'quoc-gia';
            } elseif ($url[2] == 'tu-khoa') {
                echo 'tu-khoa';
            } elseif ($url[2] == 'danh-sach') {
                echo 'danh-sach';
            } elseif ($url[2] == 'dien-vien') {
                echo 'dien-vien';
            } elseif ($url[2] == 'dao-dien') {
                echo 'dao-dien';
            } elseif ($url[2] == 'phim') {
                if (isset($url[4])) {
                    $this->getEpisode($url[3],$url[4]);
                } else {

                    $this->getMovieOverview($url[3]);
                }
            } else {
                $this->home();
            }
        } else {
            $this->home();
        }

    }

    function getUrl()
    {

        $url = rtrim($_SERVER['REQUEST_URI'], '/');

        $url = filter_var($url, FILTER_SANITIZE_URL);

        $url = explode('/', $url);

        return $url;

    }

    function getEpisode($slug,$tap)
    {
        global $oController;
        $movie = $oController->getModel('Movie', '');
        $fims = $movie->getBySlug($slug);
        $episode = $oController->getModel('Episode', '');
        $episodes = $episode->getByMovieId($fims->id);
        $embed = $episode->getByMovieIdSlug($fims->id,$tap);
        include_once("template/frontend/xingkong/episode.php");
    }

    function getMovieOverview($slug)
    {
        global $oController;
        $movie = $oController->getModel('Movie', '');
        $fims = $movie->getBySlug($slug);
        $episode = $oController->getModel('Episode', '');
        $episodes = $episode->getByMovieId($fims->id);
        include_once("template/frontend/xingkong/single.php");
    }

    function home()
    {
        global $oController;
        $movie = $oController->getModel('Movie', '');
        $fims = $movie->getAll();
        include_once("template/frontend/xingkong/index.php");
    }

}
