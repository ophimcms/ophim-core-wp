<?php
/**
 * Plugin Name: OPhim
 * Plugin URI: http://OPhim.net
 * Description: OPhim
 * Version: 1.0
 * Author: NTB
 * Author URI: http://ntb.com //
 */
if ( ! defined( 'WPINC' ) ) {
    die;
}
require_once 'define.php';
require_once OFIM_INCLUDE_PATCH.'/Controller.php';
require_once OFIM_INCLUDE_PATCH.'/Tax.php';

global $oController;
$oController = new oController();

if (is_admin()){
    require_once 'backend.php';
    new oFim_Backend();
}else{

}
