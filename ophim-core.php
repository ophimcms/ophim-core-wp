<?php
/**
 * Plugin Name: OPhim Core
 * Description: OPhim Core cho wordpress. CMS tạo website xem phim với nhiều giao diện đa dạng, dữ liệu phim miễn phí. Chỉ nên tải mã nguồn chính thức từ diễn đàn <a href="https://forum.ophim.cc/">https://forum.ophim.cc/</a>
 * Version: 1.0.0
 * Author: OPhimCC
 * Author URI: https://ophim.cc
 */
if ( ! defined( 'WPINC' ) ) {
    die;
}
require_once 'define.php';
require_once OFIM_INCLUDE_PATCH.'/Controller.php';
require_once OFIM_INCLUDE_PATCH.'/Permalink.php';
require_once OFIM_INCLUDE_PATCH.'/Tax.php';
require_once OFIM_INCLUDE_PATCH.'/Shortcuts.php';
require_once OFIM_INCLUDE_PATCH.'/Ajax.php';
require_once 'crawl_movies.php';

global $oController;
$oController = new oController();

if (is_admin()){
    require_once 'backend.php';
    new oFim_Backend();
}else{
    require_once OFIM_INCLUDE_PATCH.'/Episode.php';
}
