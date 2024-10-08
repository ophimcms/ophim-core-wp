<?php
//ajax future
if(!function_exists('dt_add_featured')){
    function dt_add_featured(){
        $postid	 = oIsset($_REQUEST,'postid');
        update_post_meta($postid, 'ophim_featured_post','1');
        die();
    }
    add_action('wp_ajax_dt_add_featured', 'dt_add_featured');
    add_action('wp_ajax_nopriv_dt_add_featured', 'dt_add_featured');
}

if(!function_exists('dt_remove_featured')){
    function dt_remove_featured(){
        $postid	= oIsset($_REQUEST,'postid');

        delete_post_meta( $postid, 'ophim_featured_post');
        die();
    }
    add_action('wp_ajax_dt_remove_featured', 'dt_remove_featured');
    add_action('wp_ajax_nopriv_dt_remove_featured', 'dt_remove_featured');
}

//end ajax


//ajax update ophim setting



add_action('wp_ajax_save_crawl_ophim_schedule_secret', 'save_crawl_ophim_schedule_secret');
function save_crawl_ophim_schedule_secret()
{
    update_option(CRAWL_OPHIM_OPTION_SECRET_KEY, $_POST['secret_key']);
    die();
}


add_action('wp_ajax_ophim_save_config_cssjs', 'ophim_save_config_cssjs');
function ophim_save_config_cssjs()
{
    update_option('ophim_include_css', stripslashes_deep($_POST['css']));
    update_option('ophim_include_js', stripslashes_deep($_POST['js']));
    die();
}

add_action('wp_ajax_crawl_ophim_schedule_enable', 'crawl_ophim_schedule_enable');
function crawl_ophim_schedule_enable()
{
    $schedule = array(
        'enable' => $_POST['enable'] === 'true' ? true : false
    );
    file_put_contents(CRAWL_OPHIM_PATH_SCHEDULE_JSON, json_encode($schedule));
    die();
}

add_action('wp_ajax_crawl_ophim_save_settings', 'crawl_ophim_save_settings');
function crawl_ophim_save_settings()
{
    $data = array(
        'pageFrom' => $_POST['pageFrom'] ?? 5,
        'pageTo' => $_POST['pageTo'] ?? 1,
        'crawl_resize_size_thumb' => $_POST['crawl_resize_size_thumb'] ?? null,
        'crawl_resize_size_thumb_w' => $_POST['crawl_resize_size_thumb_w'] ?? 0,
        'crawl_resize_size_thumb_h' => $_POST['crawl_resize_size_thumb_h'] ?? 0,
        'crawl_resize_size_poster' => $_POST['crawl_resize_size_poster'] ?? null,
        'crawl_resize_size_poster_w' => $_POST['crawl_resize_size_poster_w'] ?? 0,
        'crawl_resize_size_poster_h' => $_POST['crawl_resize_size_poster_h'] ?? 0,
        'crawl_convert_webp' => $_POST['crawl_convert_webp'] ?? null,
        'filterType' => $_POST['filterType'] ?? array(),
        'filterCategory' => $_POST['filterCategory'] ?? array(),
        'filterCountry' => $_POST['filterCountry'] ?? array(),
    );
    if (!get_option(CRAWL_OPHIM_OPTION_SETTINGS)) {
        add_option(CRAWL_OPHIM_OPTION_SETTINGS, json_encode($data));
    } else {
        update_option(CRAWL_OPHIM_OPTION_SETTINGS, json_encode($data));
    }
    die();
}

add_action('wp_ajax_crawl_ophim_page', 'crawl_ophim_page');
function crawl_ophim_page()
{
    echo crawl_ophim_page_handle($_POST['url']);
    die();
}

add_action('wp_ajax_add_server_phim', 'add_server_phim');
function add_server_phim()
{
    $pages_array =array();
    $data = get_post_meta($_POST['postid'], 'ophim_episode_list', true);
    if($data){
        foreach ($data as $d){
            $pages_array[] =$d;
        }
        $pages_array[] = array('server_name' => $_POST['namesv']);
    }else{
        $pages_array[] = array('server_name' => $_POST['namesv']);
    }

    update_post_meta($_POST['postid'], 'ophim_episode_list', $pages_array);
    echo $pages_array;
    die();
}

//end ajax

add_action('wp_ajax_search_film' , 'search_film');
add_action('wp_ajax_nopriv_search_film','search_film');
function search_film(){
    //$the_query = new WP_Query( array( 'posts_per_page' => $_POST['limit'], 's' => esc_attr( $_POST['keyword'] ), 'post_type' => 'ophim' ) );
    $meta_query = array();
    $args = array();
    $search_string =  $_POST['keyword'];

    $meta_query[] = array(
        'key' => 'ophim_original_title',
        'value' => $search_string,
        'compare' => 'LIKE'
    );
    if(count($meta_query) > 1) {
        $meta_query['relation'] = 'OR';
    }
    $args['post_type'] = "ophim";
    $args['_meta_or_title'] = $search_string; //not using 's' anymore
    $args['meta_query'] = $meta_query;
    $args['posts_per_page'] = $_POST['limit'];

    $the_query = new WP_Query($args);

    if( $the_query->have_posts() ) :
        while( $the_query->have_posts() ): $the_query->the_post();

            $post[] = array(
                'title' => get_the_title(),
                'original_title' => op_get_meta('original_title'),
                'year' => op_get_meta('year'),
                'total_episode' => op_get_meta('total_episode' ),
                'image' => op_get_meta('thumb_url'),
                'image_poster' => op_get_meta('poster_url'),
                'slug' => get_permalink(),
            );
        endwhile;
        wp_reset_postdata();
        else :
            $post = [];
    endif;
    echo json_encode( $post );
    die();
}
add_action( 'pre_get_posts', function( $q )
{
    if( $title = $q->get( '_meta_or_title' ) )
    {
        add_filter( 'get_meta_sql', function( $sql ) use ( $title )
        {
            global $wpdb;

            // Only run once:
            static $nr = 0;
            if( 0 != $nr++ ) return $sql;

            // Modified WHERE
            $sql['where'] = sprintf(
                " AND ( %s OR %s ) ",
                $wpdb->prepare( "{$wpdb->posts}.post_title like '%%%s%%'", $title),
                mb_substr( $sql['where'], 5, mb_strlen( $sql['where'] ) )
            );

            return $sql;
        });
    }
});