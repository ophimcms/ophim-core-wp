<h1>CSS & JS</h1>

<script>
    jQuery(document).ready(function($) {
        var cm_editor =wp.codeEditor.initialize($('#ophim_css'), cm_settings);
        var cm_editor_js =wp.codeEditor.initialize($('#ophim_js'), cm_settings);
        $(document).on('keyup', '.CodeMirror-code', function(){
            $('#ophim_css').html(cm_editor.codemirror.getValue());
            $('#ophim_css').trigger('change');
            $('#ophim_js').html(cm_editor_js.codemirror.getValue());
            $('#ophim_js').trigger('change');
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
            <h4>CSS</h4>
            <textarea style="width: 100%" id="ophim_css" class="list_movies"><?php echo get_option('ophim_include_css', ''); ?></textarea>
            <h4>JS</h4>
            <textarea style="width: 100%" id="ophim_js" class="list_movies"><?php echo get_option('ophim_include_js', ''); ?></textarea>
            <p><div id="save_config_cssjs" class="button">Lưu</div></p>
        </div>

    </div>
</div>