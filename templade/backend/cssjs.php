<h1>CSS & JS</h1>
<?php
if (isset($_POST['submit1'])) {
    update_option('ophim_include_css', stripslashes_deep($_POST['css']));
    update_option('ophim_include_js', stripslashes_deep($_POST['js']));
    update_option('ophim_include_js_tag_head', stripslashes_deep($_POST['js_tag_head']));
    update_option('ophim_include_js_tag_footer', stripslashes_deep($_POST['js_tag_footer']));

}
?>
<script>
    jQuery(document).ready(function($) {
        var cm_editor =wp.codeEditor.initialize($('#ophim_css'), cm_settings);
        var cm_editor_js =wp.codeEditor.initialize($('#ophim_js'), cm_settings);
        var cm_editor_js_head =wp.codeEditor.initialize($('#ophim_js_tag_head'), cm_settings);
        var cm_editor_js_footer =wp.codeEditor.initialize($('#ophim_js_tag_footer'), cm_settings);
        $(document).on('keyup', '.CodeMirror-code', function(){
            $('#ophim_css').html(cm_editor.codemirror.getValue());
            $('#ophim_css').trigger('change');
            $('#ophim_js').html(cm_editor_js.codemirror.getValue());
            $('#ophim_js').trigger('change');
            $('#ophim_js_tag_head').html(cm_editor_js_head.codemirror.getValue());
            $('#ophim_js_tag_head').trigger('change');
            $('#ophim_js_tag_footer').html(cm_editor_js_footer.codemirror.getValue());
            $('#ophim_js_tag_footer').trigger('change');
        });
    })
</script>
<style>
    .CodeMirror {
        /* Set height, width, borders, and global font properties here */
        font-family: monospace;
        height: 500px;
    }
</style>
<div class="wrap">

    <div class="tab-content">
        <div class="crawl_main">
            <form enctype="multipart/form-data" name="frmRElect" action="<?php esc_url($_SERVER['REQUEST_URI']); ?>"   method="post">
            <h4>CSS</h4>
            <textarea style="width: 100%" name="css" id="ophim_css" class="list_movies"><?php echo get_option('ophim_include_css', ''); ?></textarea>
            <h4>JS</h4>
            <textarea style="width: 100%" name="js" id="ophim_js" class="list_movies"><?php echo get_option('ophim_include_js', ''); ?></textarea>
            <h4>Google analytics script tag</h4>
            <textarea style="width: 100%" name="js_tag_head" id="ophim_js_tag_head" class="list_movies"><?php echo get_option('ophim_include_js_tag_head', ''); ?></textarea>
            <h4>Facebook JS SDK script tag</h4>
            <textarea style="width: 100%" name="js_tag_footer" id="ophim_js_tag_footer" class="list_movies"><?php echo get_option('ophim_include_js_tag_footer', ''); ?></textarea>
                <br>
            <input type="submit" value="Save" name="submit1" class="button">
            </form>
        </div>

    </div>
</div>