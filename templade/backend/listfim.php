<div id="wpbody" role="main">

    <div id="wpbody-content">
        <div id="screen-meta" class="metabox-prefs">

        </div>
        <div id="screen-meta-links">
            <div id="screen-options-link-wrap" class="hide-if-no-js screen-meta-toggle">
                <button type="button" id="show-settings-link" class="button show-settings"
                        aria-controls="screen-options-wrap" aria-expanded="false">Tùy chọn hiển thị
                </button>
            </div>
            <div id="contextual-help-link-wrap" class="hide-if-no-js screen-meta-toggle">
                <button type="button" id="contextual-help-link" class="button show-settings"
                        aria-controls="contextual-help-wrap" aria-expanded="false">Trợ giúp
                </button>
            </div>
        </div>
        <div class="wrap">
            <h1 class="wp-heading-inline">
                Danh sách phim</h1>

            <a href="#" class="page-title-action">Thêm bài phim</a>
            <hr class="wp-header-end">


            <form id="posts-filter" method="get">


                <h2 class="screen-reader-text">Danh sách bài viết</h2>
                <table class="wp-list-table widefat fixed striped table-view-list posts">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (count($books_data) > 0) {

                        foreach ($books_data as $key => $value) {
                            ?>
                            <tr>
                                <td><?php echo $value->name ?></td>
                                <td>
                                    <?php
                                    if (!empty($value->poster_url)) {
                                        ?>
                                        <img src="<?php echo $value->poster_url; ?>" style="height: 50px;width: 50px;"/>
                                        <?php
                                    } else {
                                        echo "<i>No Image</i>";
                                    }
                                    ?>

                                </td>
                                <td><?php echo $value->status  ?></td>
                                <td>
                                    <button class="button action" data-id="<?php echo $value->id; ?>">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>


                </table>


            </form>


            <div id="ajax-response"></div>
            <div class="clear"></div>
        </div>

        <div class="clear"></div>
    </div><!-- wpbody-content -->
    <div class="clear"></div>
</div>