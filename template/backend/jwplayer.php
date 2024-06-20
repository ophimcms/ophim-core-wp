
<?php
if (isset($_POST['submit1'])) {

    //$uri = get_template_directory_uri().'/xmlupload/';
    $uri = wp_upload_dir();
    $target_dir = $uri['basedir'] . '/';
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $filename = basename($_FILES["fileToUpload"]["name"]);
    $filetypenew = wp_check_filetype($filename);
    $uploadOk = 1;
    $FileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "<br/><br/>Sorry, your file is too large.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if ($FileType != "xml") {
        echo "<br/><br/>Sorry, only XML files are allowed.";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {

        update_option('ophim_jwplayer_advertising_file', $_POST['ophim_jwplayer_advertising_file']);
        echo "<br/><br/>Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "<br/><br/>The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded successfully!!.";
            $xml = simplexml_load_file($target_file);
            $filename = '/wp-content/uploads/' . basename($_FILES["fileToUpload"]["name"]);
            update_option('ophim_jwplayer_advertising_file', $filename);
        }
    }


    update_option('ophim_jwplayer_license', $_POST['ophim_jwplayer_license']);
    update_option('ophim_jwplayer_logo_file', $_POST['ophim_jwplayer_logo_file']);
    update_option('ophim_jwplayer_logo_link', $_POST['ophim_jwplayer_logo_link']);
    update_option('ophim_jwplayer_logo_position', $_POST['ophim_jwplayer_logo_position']);
    update_option('ophim_jwplayer_advertising_skipoffset', $_POST['ophim_jwplayer_advertising_skipoffset']);

}
?>
<h1>JWPlayer</h1>
<div class="wrap" style="width: 800px">
    <form enctype="multipart/form-data" name="frmRElect" action="<?php esc_url($_SERVER['REQUEST_URI']); ?>"
          method="post">
        <div class="form-wrap">
            <div class="form-field form-required term-name-wrap">
                <label>Jwplayer license </label>
                <input name="ophim_jwplayer_license" type="text" value="<?= get_option('ophim_jwplayer_license') ?>">
            </div>
        </div>

        <div class="form-wrap">
            <div class="form-field form-required term-name-wrap">
                <label>Jwplayer logo image </label>
                <input name="ophim_jwplayer_logo_file" id="logo_jwplayer" type="text"
                       value="<?= get_option('ophim_jwplayer_logo_file') ?>">
            </div>
        </div>
        <a href="#" class="ophim_upload_image_logo_jwplayer button">Upload image</a>

        <div class="form-wrap">
            <div class="form-field form-required term-name-wrap">
                <label>Jwplayer logo link</label>
                <input name="ophim_jwplayer_logo_link" type="text"
                       value="<?= get_option('ophim_jwplayer_logo_link') ?>">
            </div>
        </div>

        <div class="form-wrap">
            <div class="form-field form-required term-name-wrap">
                <?php
                $jwplayer_logo_position = get_option('ophim_jwplayer_logo_position');
                ?>
                <label>Jwplayer logo position  </label>
                <select name="ophim_jwplayer_logo_position" style="width: 100%;">

                    <?php
                    $f = array('' => __('-', 'ophim'), 'top-left' => __('Top left', 'ophim'), 'top-right' => __('Top right', 'ophim'), 'bottom-right' => __('Bottom right', 'ophim'), 'bottom-left' => __('Bottom left', 'ophim'), 'control-bar' => __('Control bar', 'ophim'));
                    foreach ($f as $x => $n) { ?>
                        <option <?php if (isset($jwplayer_logo_position)) {
                            selected($x, $jwplayer_logo_position, true);
                        } ?> value="<?php echo $x ?>"><?php echo $n ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-wrap">
            <div class="form-field form-required term-name-wrap">
                <label>Jwplayer advertising vast file </label>
                <input name="ophim_jwplayer_advertising_file" id="jwplayer_advertising_file" type="text"
                       value="<?= get_option('ophim_jwplayer_advertising_file') ?>">
            </div>
        </div>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <div class="form-wrap">
            <div class="form-field form-required term-name-wrap">
                <label>Jwplayer advertising skipoffset </label>
                <input name="ophim_jwplayer_advertising_skipoffset" type="number"
                       value="<?= get_option('ophim_jwplayer_advertising_skipoffset') ?>">
            </div>
        </div>
        <input type="submit" value="Save" name="submit1" class="button">
    </form>
</div>
