<?php
$default_tab = null;
$tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
?>

<h1>Ads</h1>
<div class="wrap">
    <nav class="nav-tab-wrapper">
        <a href="?page=ofim-manager-ads" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">Cấu hình</a>
        <a href="?page=ofim-manager-ads&tab=top" class="nav-tab <?php if($tab==='top'):?>nav-tab-active<?php endif; ?>">Top Banner</a>
        <a href="?page=ofim-manager-ads&tab=footer" class="nav-tab <?php if($tab==='footer'):?>nav-tab-active<?php endif; ?>">Catfish Banner</a>
        <a href="?page=ofim-manager-ads&tab=overlay" class="nav-tab <?php if($tab==='overlay'):?>nav-tab-active<?php endif; ?>">Popup Banner</a>
    </nav>
    <div class="tab-content">
        <?php


        switch($tab) :
            case 'top':
                if (isset($_POST['configads'])) {
                    $array = array();
                    if (is_array($_POST['data']['desktop'])) {
                        $array['desktop'] = array_values($_POST['data']['desktop']);
                    }
                    if (is_array($_POST['data']['mobile'])) {
                        $array['mobile'] = array_values($_POST['data']['mobile']);
                    }
                    update_option('ophim_adstop_list', json_encode($array));
                }

                $data = get_option('ophim_adstop_list');
                $data2 = json_decode($data, true);
                include_once 'adsform.php';
                break;
            case 'footer':
                if (isset($_POST['configads'])) {
                    $array = array();
                    if (is_array($_POST['data']['desktop'])) {
                        $array['desktop'] = array_values($_POST['data']['desktop']);
                    }
                    if (is_array($_POST['data']['mobile'])) {
                        $array['mobile'] = array_values($_POST['data']['mobile']);
                    }
                    update_option('ophim_footer_list', json_encode($array));
                }

                $data = get_option('ophim_footer_list');
                $data2 = json_decode($data, true);
                include_once 'adsform.php';
                break;
            case 'overlay':
                if (isset($_POST['configads'])) {
                    update_option('ophim_overlay_list', json_encode($_POST['data']));
                }
                $data = get_option('ophim_overlay_list');
                $data2 = json_decode($data, true);
                ?>
            <script>
                jQuery(function($){
                    $('body').on('click', '.desktop_img', function(e){
                        e.preventDefault();

                        var button = $(this),
                            custom_uploader = wp.media({
                                title: 'Insert image',
                                library : {
                                    type : 'image'
                                },
                                button: {
                                    text: 'Use this image' // button label text
                                },
                                multiple: false // for multiple image selection set to true
                            }).on('select', function() { // it also has "open" and "close" events
                                var attachment = custom_uploader.state().get('selection').first().toJSON();
                                document.getElementById("desktop_img_url").value = attachment.url.replace(window.location.origin, "");

                            })
                                .open();
                    });
                    $('body').on('click', '.mobile_img', function(e){
                        e.preventDefault();

                        var button = $(this),
                            custom_uploader = wp.media({
                                title: 'Insert image',
                                library : {
                                    type : 'image'
                                },
                                button: {
                                    text: 'Use this image' // button label text
                                },
                                multiple: false // for multiple image selection set to true
                            }).on('select', function() { // it also has "open" and "close" events
                                var attachment = custom_uploader.state().get('selection').first().toJSON();
                                document.getElementById("mobile_img_url").value = attachment.url.replace(window.location.origin, "");
                            })
                                .open();
                    });

                });
            </script>
                <div style="padding: 10px">
                    <form enctype="multipart/form-data"  action="<?php esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
                        <h2> Desktop</h2>
                        <div class="form-wrap">
                            <div class="form-field form-required term-name-wrap">
                                <label>Link </label>
                                <input name="data[desktop][link]" type="text" value="<?= $data2['desktop']['link'] ?? '' ?>">
                            </div>
                        </div>
                        <div class="form-wrap">
                            <div class="form-field form-required term-name-wrap">
                                <label>Image </label>
                                <input name="data[desktop][image]" id="desktop_img_url" type="text" value="<?= $data2['desktop']['image'] ?? '' ?>">
                            </div>
                            <a href="#" class="desktop_img button">Upload image</a>
                        </div>
                        <h2> Mobile</h2>
                        <div class="form-wrap">
                            <div class="form-field form-required term-name-wrap">
                                <label>Link </label>
                                <input name="data[mobile][link]" type="text" value="<?= $data2['mobile']['link'] ?? '' ?>">
                            </div>
                        </div>
                        <div class="form-wrap">
                            <div class="form-field form-required term-name-wrap">
                                <label>Image </label>
                                <input name="data[mobile][image]" id="mobile_img_url" type="text" value="<?= $data2['mobile']['image'] ?? '' ?>">
                            </div>
                            <a href="#" class="mobile_img button">Upload image</a>
                        </div>
                        <div class="form-wrap">
                            <div class="form-field form-required term-name-wrap">
                                <input type="submit" value="Save" name="configads" class="button">
                            </div>
                        </div>
                    </form>
                </div>
                <?php

                break;
            default:
                if (isset($_POST['configads'])) {
                    update_option('ophim_is_ads', $_POST['ophim_is_ads'] ?? null);
                    update_option('ophim_adstop', $_POST['ophim_adstop'] ?? null);
                    update_option('ophim_ads_footer', $_POST['ophim_ads_footer'] ?? null);
                    update_option('ophim_ads_overlay', $_POST['ophim_ads_overlay'] ?? null);
                    update_option('ophim_ads_link', $_POST['ophim_ads_link'] ?? null);
                    update_option('ophim_ads_link_value', $_POST['ophim_ads_link_value']);
                    update_option('ophim_ads_cache_time', $_POST['ophim_ads_cache_time'] ?? null);
                }
                ?>
                <div class="crawl_main">
                    <form enctype="multipart/form-data" name="frmRElect" action="<?php esc_url($_SERVER['REQUEST_URI']); ?>"
                          method="post">
                    <div class="crawl_filter notice notice-info" style="padding: 20px 20px">
                        <div class="filter_title"></div>
                        <div class="filter_item">
                            <label><input type="checkbox" name="ophim_is_ads" <?php  if(get_option('ophim_is_ads') == 'on') { echo 'checked'; }    ?> /> <strong>Bật quảng cáo</strong></label>
                            <label><input type="checkbox" name="ophim_adstop" <?php  if(get_option('ophim_adstop') == 'on') { echo 'checked'; }    ?> /> <strong>Top banner</strong></label>
                            <label><input type="checkbox" name="ophim_ads_footer" <?php  if(get_option('ophim_ads_footer') == 'on') { echo 'checked'; }    ?> /> <strong>Catfish banner</strong></label>
                            <label><input type="checkbox" name="ophim_ads_overlay" <?php  if(get_option('ophim_ads_overlay') == 'on') { echo 'checked'; }    ?> /> <strong>Popup banner</strong></label>
                        </div>

                        <div class="filter_title"></div>
                        <div class="filter_item">
                            <label><input type="checkbox" name="ophim_ads_link" <?php  if(get_option('ophim_ads_link') == 'on') { echo 'checked'; }    ?> /> <strong>Click link</strong></label>
                        </div> <hr>
                        <div class="form-field form-required term-name-wrap">
                            <label>Link </label>
                            <input name="ophim_ads_link_value" type="text" value="<?= get_option('ophim_ads_link_value') ?>">
                        </div>
                        <hr>
                        <div class="form-field form-required term-name-wrap">
                            <label>Cache (giây)</label>
                            <input name="ophim_ads_cache_time" type="number" value="<?= get_option('ophim_ads_cache_time') ?>">
                        </div>
                    </div>


                        <input type="submit" value="Save" name="configads" class="button">
                    </form>
                </div>

                <?php
                break;
        endswitch;
        ?>
    </div>
</div>
