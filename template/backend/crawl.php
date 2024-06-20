<?php
$default_tab = null;
$tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
?>
<div class="wrap">
    <nav class="nav-tab-wrapper">
        <a href="?page=ofim-manager-crawl" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">Thủ công</a>
        <a href="?page=ofim-manager-crawl&tab=schedule" class="nav-tab <?php if($tab==='schedule'):?>nav-tab-active<?php endif; ?>">Tự động</a>
    </nav>
    <div class="tab-content">
        <?php


        switch($tab) :
            case 'schedule':
                $crawl_ophim_settings = json_decode(get_option(CRAWL_OPHIM_OPTION_SETTINGS, []));
                ?>

                <div class="crawl_page">
                    <div class="postbox">
                        <div class="inside">
                            <b>Hưỡng dẫn cấu hình crontab</b>
                            <div>
                                <p>
                                    Thời gian thực hiện (<a href="https://crontab.guru/" target="_blank">Xem thêm</a>)
                                </p>
                                <p>
                                    Cấu hình crontab: <code><i style="color:blueviolet">*/10 * * * *</i> cd <i style="color:blueviolet">/path/to/</i>wp-content/plugins/ophim-core/ && php -q schedule.php <i style="color:blueviolet">{secret_key}</i></code>
                                </p>
                                <p>
                                    Ví dụ:
                                    <br />
                                    Mỗi 5 phút: <code>*/5 * * * * cd <?php echo OFIM_PLUGIN_PATCH; ?> && php -q schedule.php <i style="color:blueviolet"><?php echo get_option(CRAWL_OPHIM_OPTION_SECRET_KEY, ''); ?></i></code>
                                    <br />
                                    Mỗi 10 phút: <code>*/10 * * * * cd <?php echo OFIM_PLUGIN_PATCH; ?> && php -q schedule.php <i style="color:blueviolet"><?php echo get_option(CRAWL_OPHIM_OPTION_SECRET_KEY, ''); ?></i></code>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="crawl_page">
                    <div class="postbox">
                        <div class="inside">
                            <b>Cấu hình tự động</b>
                            <div>
                                <p>
                                    Secret Key: <input type="text" name="crawl_ophim_schedule_secret" value="<?php echo get_option(CRAWL_OPHIM_OPTION_SECRET_KEY, ''); ?>">
                                    <button id="save_crawl_ophim_schedule_secret" class="button">Lưu mật khẩu</button>
                                </p>
                            </div>
                            <div>
                                <p>
                                    Kích hoạt:
                                    <input type="checkbox" class="wppd-ui-toggle" id="crawl_ophim_schedule_enable" name="crawl_ophim_schedule_enable"
                                           value=""
                                        <?php echo (json_decode(file_get_contents(CRAWL_OPHIM_PATH_SCHEDULE_JSON))->enable === true) ? 'checked' : ''; ?>
                                    >
                                </p>
                            </div>
                            <div>
                                <p>Trạng thái: <?php echo (int) get_option(CRAWL_OPHIM_OPTION_RUNNING, 0) === 1 ? "<code style='color: blue'>Đang chạy...</code>" : "<code style='color: chocolate'>Dừng</code>"; ?></p>
                            </div>
                            <div>
                                <p>Bỏ qua định dạng: <code style="color: red"><?php echo join(', ', $crawl_ophim_settings->filterType);?></code></p>
                                <p>Bỏ qua thể loại: <code style="color: red"><?php echo join(', ', $crawl_ophim_settings->filterCategory);?></code></p>
                                <p>Bỏ qua quốc gia: <code style="color: red"><?php echo join(', ', $crawl_ophim_settings->filterCountry);?></code></p>
                            </div>
                            <div>
                                <p>Page đầu: <code style="color: blue"><?php echo $crawl_ophim_settings->pageFrom;?></code></p>
                                <p>Page cuối: <code style="color: blue"><?php echo $crawl_ophim_settings->pageTo;?></code></p>
                            </div>

                            <div class="notice notice-success">
                                <p>File logs: <code style="color:brown"><?php echo $schedule_log['log_filename'];?></code></p>
                                <textarea style="width: 100%" rows="10" id="schedule_log" class="" readonly><?php echo $schedule_log['log_data'];?></textarea>
                            </div>

                        </div>
                    </div>
                </div>
                <?php
                break;
            case 'about':
                ?>
                <div class="crawl_page">
                    <div class="postbox">
                        <div class="inside">
                            Ophim1.CC là website dữ liệu phim miễn phí vĩnh viễn. Cập nhật nhanh, chất lượng cao, ổn định và lâu dài. Tốc độ phát cực nhanh với đường truyền băng thông cao, đảm bảo đáp ứng được lượng xem phim trực tuyến lớn. Đồng thời giúp nhà phát triển website phim giảm thiểu chi phí của các dịch vụ lưu trữ và stream. <br />
                            - Hàng ngày chạy tools tầm 10 đến 20 pages đầu (tùy số lượng phim được cập nhật trong ngày) để update tập mới hoặc thêm phim mới!<br />
                            - Trộn link vài lần để thay đổi thứ tự crawl & update. Giúp tránh việc quá giống nhau về content của các website!<br />
                            - API được cung cấp miễn phí: <a href="https://ophim1.cc/api-document" target="_blank">https://ophim1.cc/api-document</a> <br />
                            - Tham gia trao đổi tại: <a href="https://t.me/+QMfjBOtNpkZmNTc1" target="_blank">https://t.me/+QMfjBOtNpkZmNTc1</a> <br />
                        </div>
                    </div>
                </div>
                <?php
                break;
            default:
                $crawl_ophim_settings = json_decode(get_option(CRAWL_OPHIM_OPTION_SETTINGS, '[]'));
                ?>
                <div class="crawl_main">
                    <div class="crawl_filter notice notice-info">
                        <div class="filter_title"><strong>Bỏ qua định dạng</strong></div>
                        <div class="filter_item">
                            <label><input type="checkbox" class="" name="filter_type[]" value="single"> Phim lẻ</label>
                            <label><input type="checkbox" class="" name="filter_type[]" value="series"> Phim bộ</label>
                            <label><input type="checkbox" class="" name="filter_type[]" value="hoathinh"> Hoạt hình</label>
                            <label><input type="checkbox" class="" name="filter_type[]" value="tvshows"> Tv shows</label>
                        </div>

                        <div class="filter_title"><strong>Bỏ qua thể loại</strong></div>
                        <div class="filter_item">
                            <?php
                            foreach($categoryFromApi as $category) {
                                ?>
                                <label><input type="checkbox" class="" name="filter_category[]" value="<?php echo $category->name;?>"> <?php echo $category->name;?></label>
                                <?php
                            }
                            ?>
                        </div>

                        <div class="filter_title"><strong>Bỏ qua quốc gia</strong></div>
                        <div class="filter_item">
                            <?php
                            foreach($countryFromApi as $country) {
                                ?>
                                <label><input type="checkbox" class="" name="filter_country[]" value="<?php echo $country->name;?>"> <?php echo $country->name;?></label>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="filter_title"><strong>Tải ảnh</strong></div>
                        <div class="filter_item">
                            <label>  <input type="checkbox" name="crawl_download_img" <?php  if($crawl_ophim_settings->crawl_download_img == 'on') { echo 'checked'; }    ?> /></label>
                        </div>
                        <p>

                        <div id="save_crawl_ophim_schedule" class="button">Lưu cấu hình cho crawl tự động</div>
                        </p>
                    </div>

                    <div class="crawl_page">
                        Page Crawl: From <input type="number" name="page_from" value="">
                        To <input type="number" name="page_to" value="">
                    </div>

                    <div class="crawl_page">
                        Url API <input type="text" id="url_api" value="<?php echo API_DOMAIN;?>/danh-sach/phim-moi-cap-nhat" style="width: 70%">
                        <div id="get_list_movies" class="primary">Get List Movies</div>
                    </div>

                    <div class="crawl_page">
                        Wait Timeout Random: From  <input type="number" name="timeout_from" value="">(ms) -
                        To <input type="number" name="timeout_to" value=""> (ms)
                    </div>

                    <div class="crawl_page">
                        <div style="display: none" id="msg" class="notice notice-success">
                            <p id="msg_text"></p>
                        </div>
                        <textarea style="width: 100%" rows="10" id="result_list_movies" class="list_movies"></textarea>
                        <div id="roll_movies" class="roll">Trộn Link</div>
                        <div id="crawl_movies" class="primary">Crawl Movies</div>

                        <div style="display: none;" id="result_success" class="notice notice-success">
                            <p>Crawl Thành Công</p>
                            <textarea style="width: 100%" rows="10" id="list_crawl_success"></textarea>
                        </div>

                        <div style="display: none;" id="result_error" class="notice notice-error">
                            <p>Crawl Lỗi</p>
                            <textarea style="width: 100%" rows="10" id="list_crawl_error"></textarea>
                        </div>
                    </div>
                </div>


                <?php
                break;
        endswitch;
        ?>
    </div>
</div>