<?php

//view count
function op_get_post_view()
{
    $count = get_post_meta(get_the_ID(), 'ophim_view', true);
    return $count ?: 0;
}

function op_get_rating()
{
    $count = get_post_meta(get_the_ID(), 'ophim_rating', true);
    return $count ? round($count, 1) : 0;
}

function op_get_rating_count()
{
    $count = get_post_meta(get_the_ID(), 'ophim_votes', true);
    return $count ?: 0;
}

function op_get_meta($name)
{
    $data = get_post_meta(get_the_ID(), 'ophim_' . $name, true);
    return $data;
}

function op_the_poster()
{
    echo '<img src="' . get_post_meta(get_the_ID(), 'ophim_poster_url', true) . '" style="width:100%" >';
}

function op_the_thumbnail()
{
    echo '<img src="' . get_post_meta(get_the_ID(), 'ophim_thumb_url', true) . '" style="width:100%" >';
}

function op_the_logo($style = '')
{
    if (has_custom_logo()): ?>
        <?php
        $custom_logo_id = get_theme_mod('custom_logo');
        $custom_logo_data = wp_get_attachment_image_src($custom_logo_id, 'full');
        $custom_logo_url = $custom_logo_data[0];
        ?>
        <img style="<?= $style ?>" src="<?php echo esc_url($custom_logo_url); ?>"
             alt="<?php echo esc_attr(get_bloginfo('name')); ?>"/>
    <?php else: ?>
        <h2><?php bloginfo('name'); ?></h2>
    <?php endif;
}


function op_remove_domain($url)
{
    return str_replace(explode("/wp-content/", $url)[0], '', $url);
}

function op_set_post_view()
{
    $key = 'ophim_view';
    $post_id = get_the_ID();
    $count = (int)get_post_meta($post_id, $key, true);
    $count++;
    update_post_meta($post_id, $key, $count);
}

/*
Copy the code below and paste it into single.php file in the while loop.
        <?php op_set_post_view(); ?>
          <?= op_get_post_view(); ?>
 */
//end view cont


//include admin css
add_action('wp_head', 'config_css');
function config_css()
{
    echo get_option('ophim_include_js_tag_head');
    echo "\n<style type='text/css'>\n";
    echo get_option('ophim_include_css');
    echo "</style>\n";

}

add_action('wp_footer', 'config_js');
function config_js()
{
    echo get_option('ophim_include_js_tag_footer');
    echo "\n<script>\n";
    echo get_option('ophim_include_js', '');
    echo "</script>\n";
}

add_action('wp_footer', 'config_ads');
function config_ads()
{
    if (get_option('ophim_is_ads') == 'on') {
        include_once OFIM_TEMPLADE_PATCH . '/frontend/ads.php';
    }
}
function op_jwpayer_js()
{
  echo '
    <script src="'.OFIM_PUBLIC_URL.'/js/jwplayer-8.9.3.js"></script>
    <script src="'.OFIM_PUBLIC_URL.'/js/hls.min.js"></script>
    <script src="'.OFIM_PUBLIC_URL.'/js/jwplayer.hlsjs.min.js"></script>';

}
function op_wordpress_logo() {
?>
<style type="text/css">
    body.login div#login h1 a {
        background-image: url(/wp-content/plugins/ophim-core/public/image/logo-ophim-6.png);
    }
</style>
<?php }
add_action( 'login_enqueue_scripts', 'op_wordpress_logo' );
function op_get_menu_array($current_menu)
{
    $menu_name = $current_menu;
    $locations = get_nav_menu_locations();
    $menu = wp_get_nav_menu_object(oIsset($locations,$menu_name));
    if(isset($menu->term_id)):
    $array_menu = wp_get_nav_menu_items($menu->term_id);
    $menu = array();
    foreach ($array_menu as $m) {
        if (empty($m->menu_item_parent)) {
            $menu[$m->ID] = array();
            $menu[$m->ID]['ID'] = $m->ID;
            $menu[$m->ID]['title'] = $m->title;
            $menu[$m->ID]['url'] = $m->url;
            $menu[$m->ID]['children'] = array();
        }
    }
    $submenu = array();
    foreach ($array_menu as $m) {
        if ($m->menu_item_parent) {
            $submenu[$m->ID] = array();
            $submenu[$m->ID]['ID'] = $m->ID;
            $submenu[$m->ID]['title'] = $m->title;
            $submenu[$m->ID]['url'] = $m->url;
            $menu[$m->menu_item_parent]['children'][$m->ID] = $submenu[$m->ID];
        }
    }
    else:
        $menu = array();
    endif;
    return $menu;
}
