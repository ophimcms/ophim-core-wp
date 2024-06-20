<div id=overlay></div>
<div id=footer_fixed_ads></div>
<link href="<?= OFIM_PUBLIC_URL ?>/ads/ad_c_c.css" rel="stylesheet">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script>
    var topAdsConf = <?= get_option('ophim_adstop_list') ?>;
    var footerFixAds = <?= get_option('ophim_footer_list') ?>;
    var overlayAds = <?= get_option('ophim_overlay_list') ?>;
    $(document).ready(function () {
        <?php
        if(get_option('ophim_adstop') == 'on') { echo 'showTopads(); '; }
        if(get_option('ophim_ads_footer') == 'on') { echo 'showFooterFixAds(); '; }
        if(get_option('ophim_ads_overlay') == 'on') { echo 'showOverlayAds(); '; }
         ?>
    });

<?php if(get_option('ophim_ads_link') == 'on') { ?>
    document.body.addEventListener("click", function (event) {
        if (!jQuery(event.target).closest("#overlay a, #overlay, #top_addd a, #top_addd, #footer_fixed_ads a, #footer_fixed_ads, center a").length) {
            window.open('<?= get_option('ophim_ads_link_value') ?>');
        }
    });
<?php } ?>
</script>
<script>
    var ovObj = ovObj || {};
    ovObj.time = {
        lc: 8 * 60 * 60 * 1000, // lifecycle: 8 hour
        bw: 5 * 60, // time between : 5 min
    }
    ovObj.cookie = {
        lc_ck: 'ov_cycle',
        num_ck: 'ov_num',
        atc: 'ov_after',
    }
    ovObj.num = 0;
    ovObj.createPo = function () {
        let num = $.cookie(this.cookie.num_ck) != null ? parseInt($.cookie(this.cookie.num_ck)) : 0;
        if($.cookie(this.cookie.lc_ck) == null)
        {
            var expDate = new Date();
            let curTime = expDate.getTime();
            if (num === 0) {
                $.cookie(this.cookie.num_ck, 1, { path: '/', expires: 7 });
                $.cookie(this.cookie.atc, curTime, { path: '/', expires: 7 });
                $('#overlay').show();
            } else if(num === 1) {
                if($.cookie(this.cookie.atc) !== null)
                {
                    let atc = parseInt($.cookie(this.cookie.atc));
                    let minus = (curTime - atc) / 1000;
                    if (minus >= this.time.bw) {
                        $.removeCookie(this.cookie.num_ck);
                        $.removeCookie(this.cookie.atc);
                        var expDate = new Date();
                        expDate.setTime(expDate.getTime() + this.time.lc);
                        $.cookie(this.cookie.lc_ck, 'ok', { path: '/', expires: expDate });
                        $('#overlay').show();
                    }
                }
            }
        }
    }
    ovObj.createPo();
</script>
<script>
    function detectMob() {
        const toMatch = [
            /Android/i,
            /webOS/i,
            /iPhone/i,
            /iPad/i,
            /iPod/i,
            /BlackBerry/i,
            /Windows Phone/i
        ];

        return toMatch.some((toMatchItem) => {
            return navigator.userAgent.match(toMatchItem);
        });
    }


    function closeFloatFooter(__this){
        __this.closest('.banner-sticky-footer-wrapper').remove();
    }

    function showOverlayAds() {
        var itemAds = '';
        if (detectMob() || jQuery(window).width() <=768) {
            itemAds = `<div class="overlay_content">
				<div class="overlay_wrapper">
					<div class="overlay_block">
						<a href="javascript:void(0)" class="cls_ov ads">Đóng quảng cáo [&times;]</a>
						<a target="_blank" class="ads" rel="nofollow sponsored" href="`+overlayAds.mobile.link+`"><img src="`+overlayAds.mobile.image+`"/></a>
					</div>
				</div>
			</div>`;
        } else {
            itemAds = `<div class="overlay_content">
				<div class="overlay_wrapper">
					<div class="overlay_block">
						<a href="javascript:void(0)" class="cls_ov ads">Đóng quảng cáo [&times;]</a>
						<a target="_blank" class="ads" rel="nofollow sponsored" href="`+overlayAds.desktop.link+`"><img src="`+overlayAds.desktop.image+`"/></a>
					</div>
				</div>
			</div>`;
        }
        $('#overlay').html(itemAds);


    }
    function randomIntFromInterval(min, max) { // min and max included
        return Math.floor(Math.random() * (max - min + 1) + min)
    }
    function shuffleArray(d) {
        for (var c = d.length - 1; c > 0; c--) {
            var b = Math.floor(Math.random() * (c + 1));
            var a = d[c];
            d[c] = d[b];
            d[b] = a;
        }
        return d
    }
    function showTopads() {
        var itemAds = '';
        //const arrayRan = [[1,2], [3,4]];
        const arrayRan = [8,9];
        var random = randomIntFromInterval(0,1);
        var showAd = [arrayRan[random]];
        if (detectMob() || jQuery(window).width() <=768) {
            if (topAdsConf.hasOwnProperty('mobile') && topAdsConf.mobile.length > 0) {
                $.each(topAdsConf.mobile, function(i, item) {
                    if (!showAd.includes(i)) {
                        let altImg = item.hasOwnProperty('alt') ? item.alt : 'bet';
                        itemAds += `<div class="text-center">
					<a rel="nofollow sponsored" target="_blank" href="`+item.link+`">
						<img width="320" height="40" class="ads" src="`+item.image+`" alt="`+altImg+`" />
					</a>
				</div>`;
                    }
                });
            }
        } else {
            if (topAdsConf.hasOwnProperty('desktop') && topAdsConf.desktop.length > 0) {
                $.each(topAdsConf.desktop, function(i, item) {
                    if (!showAd.includes(i)) {
                        let altImg = item.hasOwnProperty('alt') ? item.alt : 'bet';
                        itemAds += `<div class="text-center">
						<a rel="nofollow sponsored" target="_blank" href="`+item.link+`">
							<img width="728" height="60" class="ads" src="`+item.image+`" alt="`+altImg+`" />
						</a>
					</div>`;
                    }
                });
            }
        }
        if ((detectMob() || jQuery(window).width() <=768) && $('.abover-player').length > 0) {
            $('.abover-player').html(itemAds);
        } else {
            $('#top_addd').html(itemAds);
        }
    }
    function showFooterFixAds() {
        var itemAds = '';
        let closeButton = `<div class="ad_close_popup" id="ad_close_popup2" onclick="closeFloatFooter($(this));" style="height: 30px;"><img width="30" height="30" src="<?= OFIM_PUBLIC_URL ?>/ads/close_button.png" alt="close" title="close"></div>`;
        if (detectMob() || jQuery(window).width() <=768) {
            if (footerFixAds.hasOwnProperty('mobile') && footerFixAds.mobile.length > 0) {
                $.each(footerFixAds.mobile, function(i, item) {
                    if (i > 0) {
                        closeButton = '';
                    }
                    let altImg = item.hasOwnProperty('alt') ? item.alt : 'bet';
                    itemAds += `<div class="banner-sticky-footer-ad" style="max-width:100%;">
<div class="banner-flex">
	${closeButton}
	<div class="ad-sticky-content" style="max-height:100px;overflow:hidden; text-align:center;" id="ad_pc_bottom_float">
	<a rel="nofollow sponsored" target="_blank" href="`+item.link+`">
		<img width="320" height="40" class="ads" src="`+item.image+`" title="`+altImg+`" alt="`+altImg+`"/>
	</a>
	</div>
</div>
</div>`;
                });
            }
        } else {
            if (footerFixAds.hasOwnProperty('desktop') && footerFixAds.desktop.length > 0) {
                $.each(footerFixAds.desktop, function(i, item) {
                    if (i > 0) {
                        closeButton = '';
                    }
                    let altImg = item.hasOwnProperty('alt') ? item.alt : 'bet';
                    itemAds += `<div class="banner-sticky-footer-ad" style="max-width:728px;">
<div class="banner-flex">
	${closeButton}
	<div class="ad-sticky-content" style="max-height:100px;overflow:hidden; text-align:center;" id="ad_pc_bottom_float">
	<a rel="nofollow sponsored" target="_blank" href="`+item.link+`">
		<img width="728" height="60" class="ads" src="`+item.image+`" title="`+altImg+`" style="max-width:100%; overflow:hidden;" alt="`+altImg+`"/>
	</a>
	</div>
</div>
</div>`;
                });
            }
        }
        //var htmlAdsSequent = showCatfishSequentially();
        var htmlAdsSequent = '';
        var htmlAds = '';
        if (itemAds != '') {
            htmlAds = '<div class="banner-sticky-footer-wrapper"><div class="banner-sticky-footer-container container">'+htmlAdsSequent+itemAds+'</div></div>';
            $('#footer_fixed_ads').html(htmlAds);
        }
    }

    jQuery(window).on('resize', function () {
        //showTopads();
        //showFooterFixAds();
        //showOverlayAds();
    });
    $('body').on('click', '#overlay .overlay_content .cls_ov', function () {
        $(this).closest('#overlay').hide();
    });


</script>