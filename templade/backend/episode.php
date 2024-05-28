<input id="new-server-name" type="text" value="Thuyết minh #1" name="name-server-ophim" placeholder="Tên server" class="form-control">
<a type="button" data-postid="<?php echo $postid?>" id="add-server-btn" class="button">
    Thêm
    <i class="la la-plus"></i>
</a>
<style>
    .tabhigh{
        max-height: 900px!important;
    }
</style>
<div id="taxonomy-mishatabs" class="categorydiv">
    <ul id="mishatabs-tabs" class="category-tabs">
        <?php $key = 0; ?>
        <?php if ($postmneta) : foreach ($postmneta as $field) { $key++; ?>

            <li <?php if ($key == 1) echo 'class="tabs"'; ?> id="<?php echo $key?>-tab-li"><a id="click" href="#<?php echo $key?>-tab" ><?php if ($field['server_name'] != '') echo esc_attr($field['server_name']); ?></a></li>
        <?php } else : endif ?>
    </ul>
    <?php $key = 0; ?>
    <?php if ($postmneta) : foreach ($postmneta as $episode) { $key++;?>
        <div id="<?php echo $key?>-tab" class="tabs-panel tabhigh" <?php if ($key != 1) echo 'style="display:none"'; ?>>
            <div class="form-wrap">
                <div class="form-field form-required term-name-wrap">
                    <label>Tên server</label>
                    <input  name="episode[<?php echo $key ?>][server_name]" type="text" value="<?php echo $episode['server_name'] ?>"/>
                </div>
            </div>

            <table id="addrow-<?php echo $key ?>" width="100%" class="dt_table_admin ui-sortable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>M3U8</th>
                    <th>Embed</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($episode['server_data']) : foreach ($episode['server_data'] as $k=>$field) { ?>

                    <tr class="tritem" id="item">
                        <td class="draggable"><span class="dashicons dashicons-move"></td>
                        <td class="text_player"><input type="text" class="widefat" name="episode[<?php echo $key ?>][server_data][<?php echo $k ?>][name]"
                                                       value="<?php if ($field['name'] != '') echo esc_attr($field['name']); ?>"
                                                       required/></td>

                        <td class="text_player"><input type="text" class="widefat" name="episode[<?php echo $key ?>][server_data][<?php echo $k ?>][slug]"
                                                       value="<?php if ($field['slug'] != '') echo esc_attr($field['slug']); ?>"
                                                       required/></td>
                        <td>
                            <input type="text" class="widefat" name="episode[<?php echo $key ?>][server_data][<?php echo $k ?>][link_m3u8]" placeholder=""
                                   value="<?php if ($field['link_m3u8'] != '') echo esc_attr($field['link_m3u8']); else echo ''; ?>"/>
                        </td>

                        <td>
                            <input type="text" class="widefat" name="episode[<?php echo $key ?>][server_data][<?php echo $k ?>][link_embed]" placeholder=""
                                   value="<?php if ($field['link_embed'] != '') echo esc_attr($field['link_embed']); else echo ''; ?>"/>
                        </td>
                        <td><a class="button remove-row" href="#">Remove</a></td>
                    </tr>
                <?php } else : endif ?>


                </tbody>
            </table>

            <!-- Link Add Row -->

            <p class="repeater"><a id="add-row-<?php echo $key ?>" data-key="<?php echo $key ?>" class="add_row" >Thêm tập</a></p>
            <p class="repeater"><a style="background: rgba(255,0,0,0.58);color: #FFF" type="button" class="add_row delete-server-<?php echo $key?>" onclick="return confirm('Delete Server?')">Xóa Server</a></p>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $('.delete-server-<?php echo $key?>').on('click', function(){
                    $(this).closest("#<?php echo $key?>-tab").remove();
                    $('#<?php echo $key?>-tab-li').remove();
                    $('ul#mishatabs-tabs li:first').trigger('click')
                    document.getElementById('click').click();
                });

                $('#add-row-<?php echo $key ?>').on('click', function () {
                    const svrow =  $('#addrow-<?php echo $key ?>').find('tr').length
                    console.log(svrow)
                    const svname =<?php echo $key ?>;
                    const templateList = (i, row) => {
                        return ` <tr class="tritem">
                            <td class="draggable"><span class="dashicons dashicons-move"></span></td>
                            <td class="text_player"><input type="text" class="widefat" name="episode[${i}][server_data][${svrow}][name]"></td>
                            <td>
                                <input type="text" class="widefat" name="episode[${i}][server_data][${svrow}][slug]" placeholder="">
                            </td>
                            <td>
                                <input type="text" class="widefat" name="episode[${i}][server_data][${svrow}][link_m3u8]" placeholder="">
                            </td>
                            <td>
                                <input type="text" class="widefat" name="episode[${i}][server_data][${svrow}][link_embed]" placeholder="">
                            </td>
                            <td><a class="button remove-row" href="#">Remove</a></td>
                        </tr>`;
                    }
                    $("#addrow-<?php echo $key ?>").append(templateList(svname,svrow));
                });
            });
        </script>
    <?php } else : endif ?>
</div>

<!-- Player editor Table -->


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



