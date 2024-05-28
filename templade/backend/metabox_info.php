
<div id="api_table">
    <table class="options-table-responsive dt-options-table">
        <tbody>
        <tr>
            <td class="label"><label>Trạng thái</label></td>
            <td class="field">
                <?php
                $ophim_movie_status = op_get_meta('movie_status');
                ?>
                <?php
                $f = array( 'trailer' => __('Sắp chiếu', 'ophim'), 'ongoing' => __('Đang chiếu', 'ophim'), 'completed' => __('Hoàn thành', 'ophim'));
                foreach ($f as $x => $n ) { ?>
                    <label for="<?php echo $ophim_movie_status ?>_<?php echo $x ?>">
                        <input id="<?php echo $ophim_movie_status; ?>_<?php echo $x ?>" class="<?php echo $x ?>" name="ophim[ophim_movie_status]" type="radio" value="<?php echo $x ?>" <?php if (isset($ophim_movie_status)) { checked( $x, $ophim_movie_status, true ); } ?> /> <?php echo $n ?>
                    </label>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td class="label"><label>Tiêu đề gốc</label></td>
            <td class="field">

                <input name="ophim[ophim_original_title]" type="text" value="<?= op_get_meta('original_title') ?>">
            </td>
        </tr>
        <tr>
            <td class="label"><label>Đường dẫn trailer</label></td>
            <td class="field">
                <input name="ophim[ophim_trailer_url]" type="text" value="<?= op_get_meta('trailer_url') ?>">
            </td>
        </tr>
        <tr>
            <td class="label">
                <label>Thời lượng</label>
            </td>
            <td class="field">
                <input name="ophim[ophim_runtime]" type="text" value="<?= op_get_meta('runtime') ?>">
            </td>
        </tr>
        <tr>
            <td class="label">
                <label>Năm</label>
            </td>
            <td class="field">
                <input name="ophim[ophim_year]" type="text" value="<?= op_get_meta('year') ?>">
            </td>
        </tr>
        <tr>
            <td class="label">
                <label>Đánh giá </label>
            </td>
            <td class="field">
                <input name="ophim[ophim_rating]" type="text" value="<?= op_get_meta('rating') ?>">
            </td>
        </tr>
        <tr>
            <td class="label">
                <label>Phiếu </label>
            </td>
            <td class="field">
                <input name="ophim[ophim_votes]" type="text" value="<?= op_get_meta('votes') ?>">
            </td>
        </tr>
        <tr>
            <td class="label">
                <label>Tập hiện tại </label>
            </td>
            <td class="field">
                <input name="ophim[ophim_episode]" type="text" value="<?= op_get_meta('episode') ?>">
            </td>
        </tr>
        <tr>
            <td class="label">
                <label>Tổng tập </label>
            </td>
            <td class="field">
                <input name="ophim[ophim_total_episode]" type="text" value="<?= op_get_meta('total_episode') ?>">
            </td>
        </tr>
        <tr>
            <td class="label">
                <label>Chất lượng</label>
            </td>
            <td class="field">
                <input name="ophim[ophim_quality]" type="text" value="<?= op_get_meta('quality') ?>">
            </td>
        </tr>
        <tr>
            <td class="label">
                <label>Ngôn ngữ</label>
            </td>
            <td class="field">
                <input name="ophim[ophim_lang]" type="text" value="<?= op_get_meta('lang') ?>">
            </td>
        </tr>
        <tr>
            <td class="label">
                <label>Showtime</label>
            </td>
            <td class="field">
                <input name="ophim[ophim_showtime_movies]" type="text" value="<?= op_get_meta('showtime_movies') ?>">
            </td>
        </tr>
        <tr>
            <td class="label">
                <label>Thông báo</label>
            </td>
            <td class="field">
                <input name="ophim[ophim_notify]" type="text" value="<?= op_get_meta('notify') ?>">
            </td>
        </tr>
        <tr>
            <td class="label">
                <label>Bản quyền</label>
            </td>
            <td class="field">
                <input type="checkbox" name="ophim[ophim_is_copyright]" <?php  if(op_get_meta('is_copyright') == 'on') { echo 'checked'; }    ?> />
            </td>
        </tr>
        <tr>
            <td class="label">
                <label>Đường dẫn gốc </label>
            </td>
            <td class="field">
                <input name="ophim[ophim_fetch_info_url]" type="text" value="<?= op_get_meta('fetch_info_url') ?>">
            </td>
        </tr>
        <tr>
            <td class="label">
                <label>ID API </label>
            </td>
            <td class="field">
                <input name="ophim[ophim_fetch_ophim_id]" type="text" value="<?= op_get_meta('fetch_ophim_id') ?>">
            </td>
        </tr>
        <tr>
            <td class="label"><label>Thời gian cập nhập</label></td>
            <td class="field">
                <input name="ophim[ophim_fetch_ophim_update_time]" type="text" value="<?= op_get_meta('fetch_ophim_update_time') ?>">
            </td>
        </tr>
        <tr>
            <td class="label">
                <label>Ảnh thumb</label>
            </td>
            <td class="field">
                <input name="ophim[ophim_thumb_url]" id="thumb" type="text" value="<?= op_get_meta('thumb_url') ?>">
                <img id="thumb_url" src="<?= op_get_meta('thumb_url') ?>" alt="" style="max-height: 100px">
            </td>
        </tr>
        <tr>
        <tr>
            <td class="label">
            </td>
            <td class="field">
                <a href="#" class="ophim_upload_image_thumb_url button">Upload image</a>
            </td>
        </tr>
            <td class="label">
                <label>Ảnh poster</label>
            </td>
            <td class="field">
                <input name="ophim[ophim_poster_url]" id="poster" type="text" value="<?= op_get_meta('poster_url') ?>">
                <img id="imgPoster" src="<?= op_get_meta('poster_url') ?>" alt="" style="max-height: 100px">
            </td>
        </tr>
        <tr>
            <td class="label">
            </td>
            <td class="field">
                <a href="#" class="ophim_upload_image_button button">Upload image</a>
            </td>
        </tr>
        </tbody>
    </table>
</div>
