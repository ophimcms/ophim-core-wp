jQuery(function($){
    /*
     * Select/Upload image(s) event
     */
    $('body').on('click', '.ophim_upload_image_button', function(e){
        e.preventDefault();

        var button = $(this),
            custom_uploader = wp.media({
                title: 'Insert image',
                library : {
                    // uncomment the next line if you want to attach image to the current post
                    // uploadedTo : wp.media.view.settings.post.id,
                    type : 'image'
                },
                button: {
                    text: 'Use this image' // button label text
                },
                multiple: false // for multiple image selection set to true
            }).on('select', function() { // it also has "open" and "close" events
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                document.getElementById("poster").value = attachment.url.replace(window.location.origin, "");
                document.getElementById("imgPoster").src = attachment.url.replace(window.location.origin, "");
                /* if you sen multiple to true, here is some code for getting the image IDs
                var attachments = frame.state().get('selection'),
                    attachment_ids = new Array(),
                    i = 0;
                attachments.each(function(attachment) {
                    attachment_ids[i] = attachment['id'];
                    console.log( attachment );
                    i++;
                });
                */
            })
                .open();
    });
    $('body').on('click', '.ophim_upload_image_thumb_url', function(e){
        e.preventDefault();

        var button = $(this),
            custom_uploader = wp.media({
                title: 'Insert image',
                library : {
                    // uncomment the next line if you want to attach image to the current post
                    // uploadedTo : wp.media.view.settings.post.id,
                    type : 'image'
                },
                button: {
                    text: 'Use this image' // button label text
                },
                multiple: false // for multiple image selection set to true
            }).on('select', function() { // it also has "open" and "close" events
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                document.getElementById("thumb").value = attachment.url.replace(window.location.origin, "");
                document.getElementById("thumb_url").src = attachment.url.replace(window.location.origin, "");
                /* if you sen multiple to true, here is some code for getting the image IDs
                var attachments = frame.state().get('selection'),
                    attachment_ids = new Array(),
                    i = 0;
                attachments.each(function(attachment) {
                    attachment_ids[i] = attachment['id'];
                    console.log( attachment );
                    i++;
                });
                */
            })
                .open();
    });
    $('body').on('click', '.ophim_upload_image_logo_jwplayer', function(e){
        e.preventDefault();

        var button = $(this),
            custom_uploader = wp.media({
                title: 'Insert image',
                library : {
                    // uncomment the next line if you want to attach image to the current post
                    // uploadedTo : wp.media.view.settings.post.id,
                    type : 'image'
                },
                button: {
                    text: 'Use this image' // button label text
                },
                multiple: false // for multiple image selection set to true
            }).on('select', function() { // it also has "open" and "close" events
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                document.getElementById("logo_jwplayer").value = attachment.url.replace(window.location.origin, "");
                /* if you sen multiple to true, here is some code for getting the image IDs
                var attachments = frame.state().get('selection'),
                    attachment_ids = new Array(),
                    i = 0;
                attachments.each(function(attachment) {
                    attachment_ids[i] = attachment['id'];
                    console.log( attachment );
                    i++;
                });
                */
            })
                .open();
    });

});

jQuery(function ($) {
    var filterType = JSON.parse(localStorage.getItem("filterType")) != null ? JSON.parse(localStorage.getItem("filterType")) : [];
    var filterCategory = JSON.parse(localStorage.getItem("filterCategory")) != null ? JSON.parse(localStorage.getItem("filterCategory")) : [];
    var filterCountry = JSON.parse(localStorage.getItem("filterCountry")) != null ? JSON.parse(localStorage.getItem("filterCountry")) : [];

    var page_from = localStorage.getItem("page_from") ? localStorage.getItem("page_from") : 10;
    var page_to = localStorage.getItem("page_to") ? localStorage.getItem("page_to") : 1;
    $("input[name=page_from]").val(page_from);
    $("input[name=page_to]").val(page_to);

    var timeout_from = localStorage.getItem("timeout_from") ? localStorage.getItem("timeout_from") : 1000;
    var timeout_to = localStorage.getItem("timeout_to") ? localStorage.getItem("timeout_to") : 3000;
    $("input[name=timeout_from]").val(timeout_from);
    $("input[name=timeout_to]").val(timeout_to);

    $("input[name='filter_type[]']").each(function () {
        if (filterType.includes($(this).val())) {
            $(this).attr("checked", true);
        }
    });
    $("input[name='filter_category[]']").each(function () {
        if (filterCategory.includes($(this).val())) {
            $(this).attr("checked", true);
        }
    });
    $("input[name='filter_country[]']").each(function () {
        if (filterCountry.includes($(this).val())) {
            $(this).attr("checked", true);
        }
    });

    const buttonGetListMovies = $("div#get_list_movies");
    const inputPageFrom = $("input[name=page_from]");
    const inputPageTo = $("input[name=page_to]");
    const divMsg = $("div#msg");
    const divMsgText = $("p#msg_text");
    const textArealistMovies = $("textarea#result_list_movies");
    const buttonCrawlMovies = $("div#crawl_movies");
    const buttonRollMovies = $("div#roll_movies");
    const divMsgCrawlSuccess = $("div#result_success");
    const divMsgCrawlError = $("div#result_error");
    const textAreaResultSuccess = $("textarea#list_crawl_success");
    const textAreaResultError = $("textarea#list_crawl_error");

    buttonRollMovies.on("click", () => {
        var listLink = textArealistMovies.val();
        listLink = listLink.split("\n");
        listLink.sort(() => Math.random() - 0.5);
        listLink = listLink.join("\n");
        textArealistMovies.val(listLink);
    });

    buttonGetListMovies.on("click", () => {
        divMsg.show(300);
        textArealistMovies.show(300);
        crawl_page_callback(inputPageFrom.val());
    });
    const crawl_page_callback = (currentPage) => {
        var url_api = $("#url_api").val();

        var urlPageCrawl = url_api+`?page=${currentPage}`;

        if (currentPage < inputPageTo.val()) {

            var text = $("#result_list_movies").val();
            var lines = text.split(/\r|\r\n|\n/);
            var count = lines.length;
            divMsgText.html("Done! " + count +" Phim");
            buttonCrawlMovies.show(300);
            return false;
        }
        divMsgText.html(`Crawl Page: ${urlPageCrawl}`);
        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
                action: "crawl_ophim_page",
                url: urlPageCrawl,
            },
            beforeSend: function () {
                buttonGetListMovies.hide(300);
            },
            success: function (res) {
                let currentList = textArealistMovies.val();
                if (currentList != "") currentList += "\n" + res;
                else currentList += res;

                textArealistMovies.val(currentList);
                currentPage--;
                crawl_page_callback(currentPage);
            },
        });
    };

    var inputFilterType = [];
    var inputFilterCategory = [];
    var inputFilterCountry = [];

    buttonCrawlMovies.on("click", () => {
        divMsg.show(300);
        divMsgCrawlSuccess.show(300);
        divMsgCrawlError.show(300);

        $("input[name='filter_type[]']:checked").each(function () {
            inputFilterType.push($(this).val());
        });
        $("input[name='filter_category[]']:checked").each(function () {
            inputFilterCategory.push($(this).val());
        });
        $("input[name='filter_country[]']:checked").each(function () {
            inputFilterCountry.push($(this).val());
        });

        crawl_movies(false);
    });
    const crawl_movies = () => {
        var listLink = textArealistMovies.val();
        listLink = listLink.split("\n");
        let linkCurrent = listLink.shift();
        if (linkCurrent == "") {
            divMsgText.html(`Crawl Done!`);
            return false;
        }
        listLink = listLink.join("\n");
        textArealistMovies.val(listLink);
        divMsgText.html(`Crawl Movies: <b>${linkCurrent}</b>`);

        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
                action: "crawl_ophim_movies",
                url: linkCurrent,
                filterType: inputFilterType,
                filterCategory: inputFilterCategory,
                filterCountry: inputFilterCountry,
            },
            beforeSend: function () {
                buttonCrawlMovies.hide(300);
                buttonRollMovies.hide(300);
            },
            success: function (res) {
                console.log(res)
                let data = JSON.parse(res);
                if (data.status) {
                    let currentList = textAreaResultSuccess.val();
                    if (currentList != "") currentList += "\n" + linkCurrent;
                    else currentList += linkCurrent;
                    textAreaResultSuccess.val(currentList);
                } else {
                    let currentList = textAreaResultError.val();
                    if (currentList != "") currentList += "\n" + linkCurrent;
                    else currentList += linkCurrent;
                    textAreaResultError.val(currentList + "=====>>" + data.msg);
                }

                var wait_timeout = 1000;
                if (data.wait) {
                    let timeout_from = $("input[name=timeout_from]").val();
                    let timeout_to = $("input[name=timeout_to]").val();
                    let maximum = Math.max(timeout_from, timeout_to);
                    let minimum = Math.min(timeout_from, timeout_to);
                    wait_timeout = Math.floor(Math.random() * (maximum - minimum + 1)) + minimum;
                }
                divMsgText.html(`Wait timeout ${wait_timeout}ms`);
                setTimeout(() => {
                    crawl_movies();
                }, wait_timeout);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                let currentList = textAreaResultError.val();
                if (currentList != "") currentList += "\n" + linkCurrent;
                else currentList += linkCurrent;
                textAreaResultError.val(currentList);

                crawl_movies();
            },
        });
    };

    $("input[name='filter_type[]']").change(() => {
        var saveFilterData = [];
        $("input[name='filter_type[]']:checked").each(function () {
            saveFilterData.push($(this).val());
        });
        localStorage.setItem("filterType", JSON.stringify(saveFilterData));
    });

    $("input[name='filter_category[]']").change(() => {
        var saveFilterData = [];
        $("input[name='filter_category[]']:checked").each(function () {
            saveFilterData.push($(this).val());
        });
        localStorage.setItem("filterCategory", JSON.stringify(saveFilterData));
    });

    $("input[name='filter_country[]']").change(() => {
        var saveFilterData = [];
        $("input[name='filter_country[]']:checked").each(function () {
            saveFilterData.push($(this).val());
        });
        localStorage.setItem("filterCountry", JSON.stringify(saveFilterData));
    });

    $("input[name=page_from]").change((e) => {
        localStorage.setItem("page_from", $("input[name=page_from]").val());
    });
    $("input[name=page_to]").change((e) => {
        localStorage.setItem("page_to", $("input[name=page_to]").val());
    });
    $("input[name=timeout_from]").change((e) => {
        localStorage.setItem("timeout_from", $("input[name=timeout_from]").val());
    });
    $("input[name=timeout_to]").change((e) => {
        localStorage.setItem("timeout_to", $("input[name=timeout_to]").val());
    });


    // Crawler Schedule
    $("#save_crawl_ophim_schedule").on("click", () => {
        let pageFrom = $("input[name=page_from]").val();
        let pageTo = $("input[name=page_to]").val();
        let filterType = [];
        $("input[name='filter_type[]']:checked").each(function () {
            filterType.push($(this).val());
        });

        let filterCategory = [];
        $("input[name='filter_category[]']:checked").each(function () {
            filterCategory.push($(this).val());
        });

        let filterCountry = [];
        $("input[name='filter_country[]']:checked").each(function () {
            filterCountry.push($(this).val());
        });

        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
                action: "crawl_ophim_save_settings",
                pageFrom,
                pageTo,
                filterType,
                filterCategory,
                filterCountry
            },
            success: function (res) {
                alert("Lưu thành công!")
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert("Lưu cấu hình thất bại!");
            },
        });
    })

    $("#crawl_ophim_schedule_enable").on("click", (e) => {
        let enable = $("#crawl_ophim_schedule_enable").is(":checked");
        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
                action: "crawl_ophim_schedule_enable",
                enable
            },
            success: function (res) {

            },
            error: function (xhr, ajaxOptions, thrownError) {
            },
        });
    })
    $("#save_crawl_ophim_schedule_secret").on("click", (e) => {

        let secret_key = $("input[name='crawl_ophim_schedule_secret']").val();
        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
                action: "save_crawl_ophim_schedule_secret",
                secret_key
            },
            success: function (res) {
                alert("Lưu thành công!");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert("Lưu thất bại!");
            },
        });
    })

    $('.add-to-featured').click(function() {
        var postid = $(this).data("postid");
        var nonce = $(this).data("nonce");
        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
                 action: "dt_add_featured",
                 postid,
                 nonce,
            },
            success: function (res) {
                $("#feature-del-"+postid).show();
                $("#feature-add-"+postid).hide();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert("Lưu thất bại!");
            },
        });
    });
    $('.del-of-featured').click(function() {
        var postid = $(this).data("postid");
        var nonce = $(this).data("nonce");
        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
                 action: "dt_remove_featured",
                 postid,
                 nonce,
            },
            success: function (res) {
                $("#feature-del-"+postid).hide();
                $("#feature-add-"+postid).show();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert("Lưu thất bại!");
            },
        });
    });
    $('#add-server-btn').click(function() {
        let namesv = $("input[name='name-server-ophim']").val();
        var postid = $(this).data("postid");
        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
                action: "add_server_phim",
                namesv,
                postid
            },
            success: function (res) {
                location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert("Lưu thất bại!");
            },
        });
    });



    // save css js
    $("#save_config_cssjs").on("click", () => {
        var css = $("#ophim_css").val();
        var js = $("#ophim_js").val();
        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
                action: "ophim_save_config_cssjs",
                css,
                js,
            },
            success: function (res) {
                alert("Lưu thành công!")
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert("Lưu cấu hình thất bại!");
            },
        });
    })

});