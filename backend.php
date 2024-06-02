<?php

class oFim_Backend
{

    private $_menuSlug = 'ofim-manager';
    private $_page = '';

    public function __construct()
    {
        (new oFim_Permalink())->register();
        if (isset($_GET['page'])) $this->_page = $_GET['page'];
        add_action('admin_menu', array($this, 'menus'));
        if (isset($_GET['page'])) {
            if ($_GET['page'] == 'ofim-manager-crawl' || $_GET['page'] == 'ofim-manager-css-js') {
                add_action('admin_enqueue_scripts', array($this, 'css'));
            }
        }
        add_action('admin_enqueue_scripts', array($this, 'codemirror_enqueue_scripts'));
    }


    public function codemirror_enqueue_scripts($hook)
    {
        $cm_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'text/css'));
        wp_localize_script('jquery', 'cm_settings', $cm_settings);
    }

    public function css()
    {
        wp_enqueue_style('admin_css', OFIM_CSS_URL . '/style.css', false, '');
    }

    public function menus()
    {

        add_menu_page('OFim', 'Cài đặt oPhim', 'manage_options', $this->_menuSlug, array($this, 'dispatch_function'), '', 3);
        add_submenu_page($this->_menuSlug, 'Crawl', 'Crawl', 'manage_options', $this->_menuSlug . '-crawl', array($this, 'dispatch_function'));
        add_submenu_page($this->_menuSlug, 'CSS&JS', 'JWPlayer', 'manage_options', $this->_menuSlug . '-jwplayer', array($this, 'dispatch_function'));
        add_submenu_page($this->_menuSlug, 'CSS&JS', 'CSS&JS', 'manage_options', $this->_menuSlug . '-css-js', array($this, 'dispatch_function'));
        add_submenu_page($this->_menuSlug, 'Ads', 'Ads', 'manage_options', $this->_menuSlug . '-ads', array($this, 'dispatch_function'));
    }

    public function dispatch_function()
    {
        $page = $this->_page;
        global $oController;
        if ($page == 'ofim-manager-crawl') {
            $obj = $oController->getController('AdminCrawl', '/backend');
            $obj->display();
        }
        if ($page == 'ofim-manager') {
            $obj = $oController->getController('AdminManager', '/backend');
            $obj->display();
        }
        if ($page == 'ofim-manager-css-js') {
            $obj = $oController->getController('AdminCSSJS', '/backend');
            $obj->display();
        }
        if ($page == 'ofim-manager-jwplayer') {
            $obj = $oController->getController('AdminJWPlayer', '/backend');
            $obj->display();
        }
        if ($page == 'ofim-manager-ads') {
            $obj = $oController->getController('AdminAds', '/backend');
            $obj->display();
        }
    }


}