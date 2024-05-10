<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2021 Doothemes. All rights reserved
* ----------------------------------------------------
*
* @since 2.5.0
*
*/



/**
 * @since 2.5.0
 * @version 1.0
 */
function doo_meta_isset($data, $meta){
    return (isset($data[$meta][0])) ? $data[$meta][0] : false;
}


/**
 * @since 2.5.0
 * @version 1.1
 */
function doo_postmeta_movies($post_id){
    // All post meta
    $cache = new DooPlayCache;
    $pdata = $cache->get($post_id.'_postmeta');
    // Verify cache
    if(!$pdata){
        // In database
        $post_meta = get_post_meta($post_id);
        // compose data
        $pdata = array(
            'dt_featured_post' => doo_meta_isset($post_meta,'dt_featured_post'),
            'ids'              => doo_meta_isset($post_meta,'ids'),
            'dt_poster'        => doo_meta_isset($post_meta,'dt_poster'),
            'dt_backdrop'      => doo_meta_isset($post_meta,'dt_backdrop'),
            'imagenes'         => doo_meta_isset($post_meta,'imagenes'),
            'youtube_id'       => doo_meta_isset($post_meta,'youtube_id'),
            'imdbRating'       => doo_meta_isset($post_meta,'imdbRating'),
            'imdbVotes'        => doo_meta_isset($post_meta,'imdbVotes'),
            'Rated'            => doo_meta_isset($post_meta,'Rated'),
            'Country'          => doo_meta_isset($post_meta,'Country'),
            'idtmdb'           => doo_meta_isset($post_meta,'idtmdb'),
            'original_title'   => doo_meta_isset($post_meta,'original_title'),
            'tagline'          => doo_meta_isset($post_meta,'tagline'),
            'release_date'     => doo_meta_isset($post_meta,'release_date'),
            'vote_average'     => doo_meta_isset($post_meta,'vote_average'),
            'vote_count'       => doo_meta_isset($post_meta,'vote_count'),
            'runtime'          => doo_meta_isset($post_meta,'runtime'),
            'dt_cast'          => doo_meta_isset($post_meta,'dt_cast'),
            'dt_dir'           => doo_meta_isset($post_meta,'dt_dir'),
            'dt_string'        => doo_meta_isset($post_meta,'dt_string'),
            'urating_avg'      => doo_meta_isset($post_meta,'_starstruck_avg'),
            'urating_total'    => doo_meta_isset($post_meta,'_starstruck_total'),
            'numreport'        => doo_meta_isset($post_meta,'numreport'),
            'dt_views_count'   => doo_meta_isset($post_meta,'dt_views_count'),
            'players'          => doo_meta_isset($post_meta,'repeatable_fields')
        );
        // Update cache
        $cache->set($post_id.'_postmeta', serialize($pdata));
    }else{
        $pdata = maybe_unserialize($pdata);
    }
    // The return
    return apply_filters('doo_postmeta_movies', $pdata, $post_id);
}



/**
 * @since 2.5.0
 * @version 1.0
 */
function doo_postmeta_tvshows($post_id){
    // All post meta
    $cache = new DooPlayCache;
    $pdata = $cache->get($post_id.'_postmeta');
    // Verify cache
    if(!$pdata){
        // In database
        $post_meta = get_post_meta($post_id);
        // compose data
        $pdata = array(
            'dt_featured_post'   => doo_meta_isset($post_meta,'dt_featured_post'),
            'clgnrt'             => doo_meta_isset($post_meta,'clgnrt'),
            'ids'                => doo_meta_isset($post_meta,'ids'),
            'dt_poster'          => doo_meta_isset($post_meta,'dt_poster'),
            'dt_backdrop'        => doo_meta_isset($post_meta,'dt_backdrop'),
            'imagenes'           => doo_meta_isset($post_meta,'imagenes'),
            'youtube_id'         => doo_meta_isset($post_meta,'youtube_id'),
            'original_name'      => doo_meta_isset($post_meta,'original_name'),
            'first_air_date'     => doo_meta_isset($post_meta,'first_air_date'),
            'last_air_date'      => doo_meta_isset($post_meta,'last_air_date'),
            'imdbRating'         => doo_meta_isset($post_meta,'imdbRating'),
            'imdbVotes'          => doo_meta_isset($post_meta,'imdbVotes'),
            'number_of_seasons'  => doo_meta_isset($post_meta,'number_of_seasons'),
            'number_of_episodes' => doo_meta_isset($post_meta,'number_of_episodes'),
            'dt_cast'            => doo_meta_isset($post_meta,'dt_cast'),
            'dt_creator'         => doo_meta_isset($post_meta,'dt_creator'),
            'urating_avg'        => doo_meta_isset($post_meta,'_starstruck_avg'),
            'urating_total'      => doo_meta_isset($post_meta,'_starstruck_total'),
            'episode_run_time'   => doo_meta_isset($post_meta,'episode_run_time'),
            'dt_views_count'     => doo_meta_isset($post_meta,'dt_views_count')
        );
        // Update cache
        $cache->set($post_id.'_postmeta', serialize($pdata));
    }else{
        $pdata = maybe_unserialize($pdata);
    }
    // The return
    return apply_filters('doo_postmeta_tvshows', $pdata, $post_id);
}


/**
 * @since 2.5.0
 * @version 1.0
 */
function doo_postmeta_seasons($post_id){
    // All post meta
    $cache = new DooPlayCache;
    $pdata = $cache->get($post_id.'_postmeta');
    // Verify cache
    if(!$pdata){
        // In database
        $post_meta = get_post_meta($post_id);
        // compose data
        $pdata = array(
            'ids'            => doo_meta_isset($post_meta,'ids'),
            'temporada'      => doo_meta_isset($post_meta,'temporada'),
            'clgnrt'         => doo_meta_isset($post_meta,'clgnrt'),
            'serie'          => doo_meta_isset($post_meta,'serie'),
            'air_date'       => doo_meta_isset($post_meta,'air_date'),
            'dt_views_count' => doo_meta_isset($post_meta,'dt_views_count')
        );
        // Update cache
        $cache->set($post_id.'_postmeta', serialize($pdata));
    }else{
        $pdata = maybe_unserialize($pdata);
    }
    // The return
    return apply_filters('doo_postmeta_seasons', $pdata, $post_id);
}



/**
 * @since 2.5.0
 * @version 1.1
 */
function doo_postmeta_episodes($post_id){
    // All post meta
    $cache = new DooPlayCache;
    $pdata = $cache->get($post_id.'_postmeta');
    // Verify cache
    if(!$pdata){
        // In database
        $post_meta = get_post_meta($post_id);
        // compose data
        $pdata = array(
            'ids'            => doo_meta_isset($post_meta,'ids'),
            'temporada'      => doo_meta_isset($post_meta,'temporada'),
            'episodio'       => doo_meta_isset($post_meta,'episodio'),
            'episode_name'   => doo_meta_isset($post_meta,'episode_name'),
            'serie'          => doo_meta_isset($post_meta,'serie'),
            'dt_backdrop'    => doo_meta_isset($post_meta,'dt_backdrop'),
            'imagenes'       => doo_meta_isset($post_meta,'imagenes'),
            'air_date'       => doo_meta_isset($post_meta,'air_date'),
            'dt_string'      => doo_meta_isset($post_meta,'dt_string'),
            'dt_views_count' => doo_meta_isset($post_meta,'dt_views_count'),
            'players'        => doo_meta_isset($post_meta,'repeatable_fields')
        );
        // Update cache
        $cache->set($post_id.'_postmeta', serialize($pdata));
    }else{
        $pdata = maybe_unserialize($pdata);
    }
    // The return
    return apply_filters('doo_postmeta_seasons', $pdata, $post_id);
}
