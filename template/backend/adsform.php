<script>
    function desktopImg(id) {
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
                document.getElementById("desktop_img_"+id).value = attachment.url.replace(window.location.origin, "");

            })
                .open();
    }
    function mobileImg(id) {
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
                document.getElementById("mobile_img_"+id).value = attachment.url.replace(window.location.origin, "");

            })
                .open();
    }
</script>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#add-row-mobile').on('click', function () {
            const svrows = $('#addrow-mobile').find('tr').length
            const templateList = (i, row) => {
                return ` <tr class="tritem" id="item">
                            <td class="draggable"><span class="dashicons dashicons-move"></span></td>
                            <td class="text_player"><input type="text" class="widefat" name="data[mobile][${svrows}][link]"></td>
                            <td class="text_player"><input type="text" class="widefat" id="desktop_img_${svrows}" name="data[mobile][${svrows}][image]"></td>
                            <td><a class="button" onclick="desktopImg(${svrows})">Select image</a></td>
                            <td><a class="button remove-row" href="#">Remove</a></td>
                        </tr>`;
            }
            $("#addrow-mobile").append(templateList(svrows));
        });
    });
</script>

<script type="text/javascript">
    jQuery(document).ready(function ($) {

        $('.remove-row').on('click', function () {
            $(this).parents('tr').remove();
            return false;
        });
        $('.dt_table_admin').sortable({
            items: '.tritem',
            opacity: 0.8,
            cursor: 'move',
        });


    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function ($) {

        $('#add-row-desktop').on('click', function () {
            const svrow = $('#addrow-desktop').find('tr').length
            console.log(svrow)
            const templateList = (i, row) => {
                return ` <tr class="tritem" id="item">
                            <td class="draggable"><span class="dashicons dashicons-move"></span></td>
                            <td class="text_player"><input type="text" class="widefat" name="data[desktop][${svrow}][link]"></td>
                            <td class="text_player"><input type="text" class="widefat" id="desktop_img_${svrow}" name="data[desktop][${svrow}][image]"></td>
                            <td><a class="button" onclick="desktopImg(${svrow})">Select image</a></td>
                            <td><a class="button remove-row" href="#">Remove</a></td>
                        </tr>`;
            }
            $("#addrow-desktop").append(templateList(svrow));
        });
    });
</script>

<form enctype="multipart/form-data" action="<?php esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
    <h2>Desktop</h2>
    <table id="addrow-desktop" width="100%" class="dt_table_admin ui-sortable">
        <thead>
        <tr>
            <th>#</th>
            <th>Link</th>
            <th>Image</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (isset($data2['desktop'])) : foreach ($data2['desktop'] as $k => $field) { ?>
            <tr class="tritem" id="item">
                <td class="draggable"><span class="dashicons dashicons-move"></td>
                <td class="text_player"><input type="text" class="widefat"
                                               name="data[desktop][<?php echo $k ?>][link]"
                                               value="<?php if ($field['link'] != '') echo esc_attr($field['link']); ?>"
                                               required/></td>

                <td class="text_player"><input type="text" class="widefat" id="desktop_img_<?php echo $k ?>"
                                               name="data[desktop][<?php echo $k ?>][image]"
                                               value="<?php if ($field['image'] != '') echo esc_attr($field['image']); ?>"
                                               required/></td>

                <td><a class="button" onclick="desktopImg(<?php echo $k ?>)">Select image</a></td>
                <td><a class="button remove-row" href="#">Remove</a></td>
            </tr>
        <?php } else : endif ?>


        </tbody>
    </table>

    <!-- Link Add Row -->

    <p class="repeater"><a id="add-row-desktop" data-key="" class="add_row">Thêm</a></p>


    <h2>Mobile</h2>
    <table id="addrow-mobile" width="100%" class="dt_table_admin ui-sortable">
        <thead>
        <tr>
            <th>#</th>
            <th>Link</th>
            <th>Image</th>
        </tr>
        </thead>
        <tbody>

        <?php
        if (isset($data2['mobile'])) : foreach ($data2['mobile'] as $k => $field) { ?>
            <tr class="tritem" id="item">
                <td class="draggable"><span class="dashicons dashicons-move"></td>
                <td class="text_player"><input type="text" class="widefat"
                                               name="data[mobile][<?php echo $k ?>][link]"
                                               value="<?php if ($field['link'] != '') echo esc_attr($field['link']); ?>"
                                               required/></td>

                <td class="text_player"><input type="text" class="widefat"
                                               name="data[mobile][<?php echo $k ?>][image]" id="mobile_img_<?php echo $k ?>"
                                               value="<?php if ($field['image'] != '') echo esc_attr($field['image']); ?>"
                                               required/></td>
                <td><a class="button" onclick="mobileImg(<?php echo $k ?>)">Select image</a></td>
                <td><a class="button remove-row" href="#">Remove</a></td>
            </tr>
        <?php } else : endif ?>


        </tbody>
    </table>

    <!-- Link Add Row -->

    <p class="repeater"><a id="add-row-mobile" data-key="" class="add_row">Thêm</a></p>
    <input type="submit" value="Save" name="configads" class="button">
</form>