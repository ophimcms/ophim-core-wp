<?php

function watchUrl(){
    $slugView = '/xem-phim/';
    $post_slug = basename(get_permalink(get_the_id()));;
    $listphim = get_post_meta(get_the_id(), 'ophim_episode_list', true);
    if (is_array($listphim)) {
        $tapdau = slugify(reset(reset($listphim)['server_data'])['name']);
         $episodeUrl = home_url("/") . $slugView . $post_slug . '/tap-' . $tapdau . '-sv-' . array_key_first($listphim);
         if(!$tapdau){
             return '';
         }
         return $episodeUrl;
    }
    return '';

}
function episodeList(){
    $episode_arr = [];
    $episode= get_post_meta(get_the_id(), 'ophim_episode_list', true);
    foreach ($episode as $sv => $list){
        $episode_arr[$sv]['server_name'] = $list['server_name'];
        foreach ($list['server_data'] as $l):
            $episode_arr[$sv]['server_data'][] = array(
                'svname' => $list['server_name'],
                'svkey' => $sv,
                'name' => $l['name'],
                'slug' => $l['slug'],
                'link_embed' => $l['link_embed'],
                'link_m3u8' => $l['link_m3u8'],
                'getUrl' => hrefEpisode($l["name"], $sv),
            );
        endforeach;
    }
    return $episode_arr;
}
function isEpisode(){
    global $wp;
    if (str_contains($wp->request, 'xem-phim') && episodeUrl($wp->request)) {
        return true;
    }
    return false;
}
function episodeName(){
    global $wp;
    $checkUrl = explode("/", $wp->request);
    $explode = explode("-sv-", $checkUrl[2]);
    return str_replace('tap-', '', $explode[0]);
}
function episodeSV(){
    global $wp;
    $checkUrl = explode("/", $wp->request);
    $explode = explode("-sv-", $checkUrl[2]);
    return  $explode[1];
}
function getCurrentUrl(){
    return get_permalink();
}
function hrefEpisode($episode,$sv){
    return home_url("xem-phim/" . basename(get_permalink(get_the_id()))) . '/tap-'. slugify($episode) . '-sv-' . $sv ;
}
function nextEpisodeUrl(){
    return episodeUrl()['next'];
}
function m3u8EpisodeUrl(){
    return episodeUrl()['link_m3u8'];
}
function embedEpisodeUrl(){
    return episodeUrl()['link_embed'];
}
function getEpisode(){
    return episodeUrl()['episode'];
}
function episodeUrl(){
    global $wp;
    $current_url =$wp->request;
    $slugView = '/xem-phim/';
    $post_slug = basename(get_permalink(get_the_id()));;
    $listphim = episodeList();
    $checkUrl = explode("/", $current_url);
    $explode = explode("-sv-", $checkUrl[2]);
    $tap = str_replace('tap-','',$explode[0]);
    $sv = $explode[1];
    if (!isset($listphim[$sv])){
        return '';
    }
    $iframe = $listphim[$sv];
    if($iframe){
        $keytap = null;
        foreach ($listphim[$sv]['server_data'] as $l=>$list){
            if (slugify($list['name']) == $tap) {
                $keytap = $l;
            }
        }
        if(isset($listphim[$sv]['server_data'][$keytap])){
            $data =  $listphim[$sv]['server_data'][$keytap];
            $data['episode'] = $listphim[$sv]['server_data'][$keytap];
            $data['next'] = '';
            if(isset($listphim[$sv]['server_data'][$keytap+1])){
                $next = home_url("/") . $slugView . $post_slug . '/tap-' . (slugify($listphim[$sv]['server_data'][$keytap+1]['name'])) . '-sv-' . $sv;
                $data['next'] = $next;
            }
            return $data;
        }
        return '';
    }
    return '';
}

function op_get_regions($end ='')
{
    $getslug = get_option('ophim_slug_regions');
    if($getslug){
        $slug = $getslug;
    }else{
        $slug = 'regions';
    }
    $html = "";
    $country = get_the_terms(get_the_ID(), "ophim_regions");
    if (is_array($country)) {
        foreach ($country as $ct) {
            $html .= "<a href=\"" . home_url($slug . "/" . $ct->slug) . "\" title=\"" . $ct->name . "\">" . $ct->name . "</a>". $end;
        }
    }
    return $html;
}


function op_get_region()
{
    return get_the_terms(get_the_ID(), "ophim_regions");
}

function op_get_years($end ='')
{
    $getslug = get_option('ophim_slug_years');
    if($getslug){
        $slug = $getslug;
    }else{
        $slug = 'years';
    }
    $html = "";
    $years = get_the_terms(get_the_ID(), "ophim_years");
    if (is_array($years)) {
        foreach ($years as $y) {
            $html .= "<a href=\"" . home_url($slug . "/" . $y->slug) . "\" title=\"" . $y->name . "\">" . $y->name . "</a>". $end;
        }
    }
    return $html;
}

function op_get_yeare()
{
    return get_the_terms(get_the_ID(), "ophim_years");
}

function op_get_genres($end ='')
{
    $getslug = get_option('ophim_slug_genres');
    if($getslug){
        $slug = $getslug;
    }else{
        $slug = 'genres';
    }
    $html = "";
    $genres = get_the_terms(get_the_ID(), "ophim_genres");
    if (is_array($genres)) {
        foreach ($genres as $genre) {
            $html .= "<a href=\"" . home_url($slug . "/" . $genre->slug) . "\" title=\"" . $genre->name . "\">" . $genre->name . "</a>".$end;
        }
    }
    return $html;
}

function op_get_genre()
{
    return get_the_terms(get_the_ID(), "ophim_genres");
}

function op_get_tags($end ='')
{
    $getslug = get_option('ophim_slug_tags');
    if($getslug){
        $slug = $getslug;
    }else{
        $slug = 'tags';
    }
    $html = "";
    $tags = get_the_terms(get_the_ID(), "ophim_tags");
    if (is_array($tags)) {
        foreach ($tags as $tag) {
            $html .= "<a href=\"" . home_url($slug . "/" . $tag->slug) . "\" title=\"" . $tag->name . "\">" . $tag->name . "</a>".$end;
        }
    }
    return $html;
}

function op_get_tag()
{
    return get_the_terms(get_the_ID(), "ophim_tags");
}
function op_get_actors($limit = 10,$end ='')
{
    $getslug = get_option('ophim_slug_actors');
    if($getslug){
        $slug = $getslug;
    }else{
        $slug = 'actors';
    }
    $html = "";
    $actors = get_the_terms(get_the_ID(), "ophim_actors");
    if (is_array($actors)) {
        foreach (array_slice($actors, 0, $limit) as $actor) {
            $html .= "<a href=\"" . home_url($slug . "/" . $actor->slug) . "\" title=\"" . $actor->name . "\">" . $actor->name . "</a>".$end;
        }
    }
    return $html;
}
function op_get_actor()
{
    return get_the_terms(get_the_ID(), "ophim_actors");
}
function op_get_directors($limit = 10,$end ='')
{
    $getslug = get_option('ophim_slug_directors');
    if($getslug){
        $slug = $getslug;
    }else{
        $slug = 'directors';
    }
    $html = "";
    $directors = get_the_terms(get_the_ID(), "ophim_directors");
    if (is_array($directors)) {
        foreach (array_slice($directors, 0, $limit) as $director) {
            $html .= "<a href=\"" . home_url($slug . "/" . $director->slug) . "\" title=\"" . $director->name . "\">" . $director->name . "</a>".$end;
        }
    }
    return $html;
}
function op_get_director()
{
    return get_the_terms(get_the_ID(), "ophim_directors");
}
function op_get_status()
{
    if(op_get_meta('movie_status') == 'trailer'){ return 'Sắp chiếu'; }
    if(op_get_meta('movie_status') == 'ongoing'){ return 'Đang chiếu'; }
    if(op_get_meta('movie_status') == 'completed'){ return 'Hoàn thành'; }
    return  'Sắp chiếu';
}
function op_get_notify()
{
    return op_get_meta('notify');
}
function op_get_showtime_movies()
{
    return op_get_meta('showtime_movies');
}
function op_get_original_title()
{
    return op_get_meta('original_title');
}
function op_get_poster_url()
{
    return op_get_meta('poster_url');
}
function op_get_thumb_url()
{
    return op_get_meta('thumb_url');
}
function op_get_runtime()
{
    return op_get_meta('runtime');
}
function op_get_episode()
{
    return op_get_meta('episode');
}
function op_get_total_episode()
{
    return op_get_meta('total_episode');
}
function op_get_featured_post()
{
    return op_get_meta('featured_post');
}
function op_get_quality()
{
    return op_get_meta('quality');
}
function op_get_lang()
{
    return op_get_meta('lang');
}
function op_get_is_copyright()
{
    return op_get_meta('is_copyright');
}
function op_get_trailer_url()
{
    return op_get_meta('trailer_url');
}
function op_get_year($end ='')
{
    $html = "";
    $years = get_the_terms(get_the_ID(), "ophim_years");
    if (is_array($years)) {
        foreach ($years as $y) {
            $html .= $y->name. $end;
        }
    }
    return $html;
}