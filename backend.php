<?php

class oFim_Backend
{

    private $_menuSlug = 'ofim-manager';
    private $_page = '';

    public function __construct()
    {
        //echo __METHOD__;
        if (isset($_GET['page'])) $this->_page = $_GET['page'];
        add_action('admin_menu', array($this,'menus'));
    }


    public function menus()
    {

        add_menu_page('OFim', 'OFim', 'manage_options', $this->_menuSlug, array($this, 'dispatch_function'), '', 3);

        add_submenu_page($this->_menuSlug,'Tất cả phim','Tất cả phim','manage_options',
            $this->_menuSlug. '-allfim',array($this,'dispatch_function'));

        add_submenu_page($this->_menuSlug,'Thêm mới','Thêm mới','manage_options',
            $this->_menuSlug. '-addfim',array($this,'dispatch_function'));

        add_submenu_page($this->_menuSlug,'Thể loại','Thể loại','manage_options',
            $this->_menuSlug. '-theloai',array($this,'dispatch_function'));

        add_submenu_page($this->_menuSlug,'Tag','Tag','manage_options',
            $this->_menuSlug. '-tag',array($this,'dispatch_function'));

        add_submenu_page($this->_menuSlug,'Actors','Actors','manage_options',
            $this->_menuSlug. '-actors',array($this,'dispatch_function'));

        add_submenu_page($this->_menuSlug,'Directors','Directors','manage_options',
            $this->_menuSlug. '-directors',array($this,'dispatch_function'));

        add_submenu_page($this->_menuSlug,'Release','Release','manage_options',
            $this->_menuSlug. '-release',array($this,'dispatch_function'));

        add_submenu_page($this->_menuSlug,'Crawl','Crawl','manage_options',
            $this->_menuSlug. '-crawl',array($this,'dispatch_function'));
    }

    public function dispatch_function()
    {
        $page= $this->_page;
        global $oController;
        if($page =='ofim-manager'){
            $obj = $oController->getController('AdminManager','/backend');
            $obj->display();
        }
        if($page =='ofim-manager-allfim'){
            $obj = $oController->getController('AdminAllFim','/backend');
            $obj->display();
        }
        if($page =='ofim-manager-crawl'){
            $obj = $oController->getController('AdminCrawl','/backend');
            $obj->display();
        }
    }
}