<?php

add_action('init', 'framework_core', 0);
function wporg_add_custom_box()
{
    $screens = ['ophim'];
    foreach ($screens as $screen) {
        add_meta_box('wporg_box_id',                 // Unique ID
            'Movie Info',      // Box title
            'wporg_custom_box_html',  // Content callback, must be of type callable
            $screen                            // Post type
        );
    }
}

add_action('add_meta_boxes', 'wporg_add_custom_box');


function wporg_custom_box_html($post)
{
    $value = get_post_meta($post->ID, '_wporg_meta_key', true);
    ?>
    <div class="inside">
        <!-- Player editor Table -->
        <table id="repeatable-fieldset-one" width="100%" class="dt_table_admin ui-sortable">
            <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Type</th>
                <th>URL source or Shortcode</th>
                <th>Flag Language</th>
                <th>Control</th>
            </tr>
            </thead>
            <tbody>
            <tr class="tritem">
                <td class="draggable"><span class="dashicons dashicons-move"></span></td>
                <td class="text_player"><input type="text" class="widefat" name="name[]"></td>
                <td>
                    <select name="select[]" style="width: 100%;">
                        <option value="iframe">URL Embed</option>
                        <option value="mp4">URL MP4</option>
                        <option value="dtshcode">Shortcode or HTML</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="widefat" name="url[]" placeholder="">
                </td>
                <td>
                    <select name="idioma[]" style="width: 100%;">
                        <option value="">---------</option>
                        <option value="vn">Vietnam</option>
                    </select>
                </td>
                <td><a class="button remove-row" href="#">Remove</a></td>
            </tr>
            <tr class="empty-row screen-reader-text tritem">
                <td class="draggable"><span class="dashicons dashicons-move"></span></td>
                <td class="text_player"><input type="text" class="widefat" name="name[]"></td>
                <td>
                    <select name="select[]" style="width: 100%;">
                        <option value="iframe">URL Embed</option>
                    </select>
                </td>
                <td><input type="text" class="widefat" name="url[]" placeholder=""></td>
                <td>
                    <select name="idioma[]" style="width: 100%;">
                        <option value="">---------</option>

                        <option value="vn">Vietnam</option>
                    </select>
                </td>
                <td><a class="button remove-row" href="#">Remove</a></td>
            </tr>
            </tbody>
        </table>

        <!-- Link Add Row -->
        <p class="repeater"><a id="add-row" class="add_row" href="#">Add new row</a></p>

        <!-- JQuery -->
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $('#add-row').on('click', function () {
                    var row = $('.empty-row.screen-reader-text').clone(true);
                    row.removeClass('empty-row screen-reader-text');
                    row.insertBefore('#repeatable-fieldset-one tbody>tr:last');
                    return false;
                });
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
    </div>
    <?php
}


function framework_core()
{
    framework_create_post_type('ophim', 'OPhim', 'OPhim', 'ophim', ['title', 'editor', 'thumbnail'], 'dashicons-admin-page');
    framework_create_taxonomies('ophim_directors', 'ophim', 'Directors', 'Directors', 'ophim_directors');
    framework_create_taxonomies('ophim_categories', 'ophim', 'Categories', 'Categories', 'ophim_categories');
    framework_create_taxonomies('ophim_actors', 'ophim', 'Actors', 'Categories', 'ophim_actors');
    framework_create_taxonomies('ophim_genres', 'ophim', 'Genres', 'Genres', 'ophim_genres');
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function framework_create_post_type($post_type, $singular_name, $plural_name, $slug, $support = ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'], $menu_icon)
{
    $labels = array('name' => _x($plural_name, 'post type general name', 'Ophim'), 'singular_name' => _x($singular_name, 'post type singular name', 'Ophim'), 'menu_name' => _x($plural_name, 'admin menu', 'Ophim'), 'name_admin_bar' => _x($singular_name, 'add new on admin bar', 'Ophim'), 'add_new' => _x('Add New', $post_type, 'Ophim'), 'add_new_item' => __('Add New ' . $singular_name, 'Ophim'), 'new_item' => __('New ' . $singular_name, 'Ophim'), 'edit_item' => __('Edit ' . $singular_name, 'Ophim'), 'view_item' => __('View ' . $singular_name, 'Ophim'), 'all_items' => __('All ' . $plural_name, 'Ophim'), 'search_items' => __('Search ' . $singular_name . 's', 'Ophim'), 'parent_item_colon' => __('Parent ' . $singular_name . ':', 'Ophim'), 'not_found' => __('No ' . $singular_name . ' found.', 'Ophim'), 'not_found_in_trash' => __('No ' . $singular_name . ' found in Trash.', 'Ophim'),);
    $args = array('labels' => $labels, 'description' => __('Description.', 'Ophim'), 'public' => ($post_type === 'process') ? false : true, 'publicly_queryable' => true, 'show_ui' => true, 'show_in_menu' => true, 'query_var' => true, 'rewrite' => ($post_type === 'process') ? false : array('slug' => $slug), 'capability_type' => 'post', 'has_archive' => true, 'hierarchical' => false, 'menu_position' => null, 'menu_icon' => $menu_icon, 'supports' => $support,);
    register_post_type($post_type, $args);
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function framework_create_taxonomies($taxonomy_name, $post_type, $singular_name, $plural_name, $slug)
{
    $labels = array('name' => _x($plural_name, 'taxonomy general name', 'Ophim'), 'singular_name' => _x($singular_name, 'taxonomy singular name', 'Ophim'), 'search_items' => __('Search ' . $plural_name, 'Ophim'), 'all_items' => __('All ' . $plural_name, 'Ophim'), 'parent_item' => __('Parent ' . $singular_name, 'Ophim'), 'parent_item_colon' => __('Parent ' . $singular_name . ':', 'Ophim'), 'edit_item' => __('Edit ' . $singular_name, 'Ophim'), 'update_item' => __('Update ' . $singular_name, 'Ophim'), 'add_new_item' => __('Add New ' . $singular_name, 'Ophim'), 'new_item_name' => __('New ' . $singular_name . ' Name', 'Ophim'), 'menu_name' => __($singular_name, 'Ophim'),);
    $args = array('hierarchical' => true, 'labels' => $labels, 'show_ui' => true, 'show_admin_column' => true, 'query_var' => true, 'rewrite' => array('slug' => $slug),);
    register_taxonomy($taxonomy_name, array($post_type), $args);
}