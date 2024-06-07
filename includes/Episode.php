<?php

function watchUrl(){
    $slugView = '/xem-phim/';
    $post_slug = basename(get_permalink(get_the_id()));;
    $listphim = get_post_meta(get_the_id(), 'ophim_episode_list', true);
    if (is_array($listphim)) {
        $tapdau = slugify(reset($listphim)['server_data'][0]['name']);
         $episodeUrl = home_url("/") . $slugView . $post_slug . '/tap-' . $tapdau . '-sv-' . array_key_first($listphim);
         return $episodeUrl;
    }
    return '';

}
function episodeUrl($current_url){
    $listphim = get_post_meta(get_the_id(), 'ophim_episode_list', true);
    $checkUrl = explode("/", $current_url);
    $explode = explode("-sv-", $checkUrl[2]);
    $tap = str_replace('tap-','',$explode[0]);
    $sv = $explode[1];
    $iframe = $listphim[$sv];
    if($iframe){
        foreach ($listphim[$sv]['server_data'] as $l=>$list){
            if (slugify($list['name']) == $tap) {
                $keytap = $l;
            }
        }
        if(isset($listphim[$sv]['server_data'][$keytap])){
            return $listphim[$sv]['server_data'][$keytap];
        }
        return '';
    }
    return '';
}

function op_get_regions($end ='')
{
    global $post;
    $html = "";
    $country = get_the_terms($post->ID, "ophim_regions");
    if (is_array($country)) {
        foreach ($country as $ct) {
            $html .= "<a href=\"" . home_url(get_option('ophim_slug_regions') ? get_option('ophim_slug_regions') : 'regions' . "/" . $ct->slug) . "\" title=\"" . $ct->name . "\">" . $ct->name . "</a>". $end;
        }
    }
    return $html;
}

function op_get_genres($end ='')
{
    global $post;
    $html = "";
    $genres = get_the_terms($post->ID, "ophim_genres");
    if (is_array($genres)) {
        foreach ($genres as $genre) {
            $html .= "<a href=\"" . home_url(get_option('ophim_slug_genres') ? get_option('ophim_slug_genres') : 'genres' . "/" . $genre->slug) . "\" title=\"" . $genre->name . "\">" . $genre->name . "</a>".$end;
        }
    }
    return $html;
}

function op_get_tags($end ='')
{
    global $post;
    $html = "";
    $tags = get_the_terms($post->ID, "ophim_tags");
    if (is_array($tags)) {
        foreach ($tags as $tag) {
            $html .= "<a href=\"" . home_url(get_option('ophim_slug_tags') ? get_option('ophim_slug_tags') : 'tags' . "/" . $tag->slug) . "\" title=\"" . $tag->name . "\">" . $tag->name . "</a>".$end;
        }
    }
    return $html;
}
function op_get_actors($limit = 10,$end ='')
{
    global $post;
    $html = "";
    $actors = get_the_terms($post->ID, "ophim_actors");
    if (is_array($actors)) {
        foreach (array_slice($actors, 0, $limit) as $actor) {
            $html .= "<a href=\"" . home_url(get_option('ophim_slug_actors') ? get_option('ophim_slug_actors') : 'actors' . "/" . $actor->slug) . "\" title=\"" . $actor->name . "\">" . $actor->name . "</a>".$end;
        }
    }
    return $html;
}
function op_get_directors($limit = 10,$end ='')
{
    global $post;
    $html = "";
    $directors = get_the_terms($post->ID, "ophim_directors");
    if (is_array($directors)) {
        foreach (array_slice($directors, 0, $limit) as $director) {
            $html .= "<a href=\"" . home_url(get_option('ophim_directors') ? get_option('ophim_directors') : 'directors' . "/" . $director->slug) . "\" title=\"" . $director->name . "\">" . $director->name . "</a>".$end;
        }
    }
    return $html;
}
function op_get_status()
{
    if(op_get_meta('movie_status') == 'trailer'){ return 'Sắp chiếu'; }
    if(op_get_meta('movie_status') == 'ongoing'){ return 'Đang chiếu'; }
    if(op_get_meta('movie_status') == 'completed'){ return 'Hoàn thành'; }
}