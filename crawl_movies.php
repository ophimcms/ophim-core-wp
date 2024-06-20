<?php

function crawl_ophim_page_handle($url)
{

    $sourcePage 			=  file_get_contents($url);
    $sourcePage       = json_decode($sourcePage);
    $listMovies 			= [];
    if(isset($sourcePage->items)){
        $sourcePage = $sourcePage->items;
    }
    if(isset($sourcePage->data->items)){
        $sourcePage = $sourcePage->data->items;
    }

    if(count($sourcePage) > 0) {
        foreach ($sourcePage as $key => $item) {
            array_push($listMovies, API_DOMAIN . "/phim/{$item->slug}|{$item->_id}|{$item->modified->time}|{$item->name}|{$item->origin_name}|{$item->year}");
        }
        return join("\n", $listMovies);
    }
    return $listMovies;
}

add_action('wp_ajax_crawl_ophim_movies', 'crawl_ophim_movies');
function crawl_ophim_movies()
{
	$data_post 					= $_POST['url'];
	$url 								= explode('|', $data_post)[0];
	$ophim_id 					= explode('|', $data_post)[1];
	$ophim_update_time 	= explode('|', $data_post)[2];
	$title 							= explode('|', $data_post)[3];
	$org_title 					= explode('|', $data_post)[4];
	$year 							= explode('|', $data_post)[5];
	
	$filterType 				= $_POST['filterType'] ?: [];
	$filterCategory 		= $_POST['filterCategory'] ?: [];
	$filterCountry 			= $_POST['filterCountry'] ?: [];

	$result = crawl_ophim_movies_handle($url, $ophim_id, $ophim_update_time, $filterType, $filterCategory, $filterCountry);
	echo $result;
	die();
}

function crawl_ophim_movies_handle($url, $ophim_id, $ophim_update_time, $filterType, $filterCategory, $filterCountry)
{

	try {
		$args = array(
            'post_type'     => 'ophim',
            'meta_query' => array(
                array(
                    'key' => 'ophim_fetch_info_url',
                    'value' => $url,
                    'compare' => 'LIKE',
                )
            )
		);
		$wp_query = new WP_Query($args);

		$total = $wp_query->found_posts;

        if ($total > 0) { # Trường hợp đã có

            $args = array(
                'post_type'     => 'ophim',
                'meta_query' => array(
                    array(
                        'key' => 'ophim_fetch_info_url',
                        'value' => $url,
                        'compare' => 'LIKE',
                    )
                )
            );
            $wp_query = new WP_Query($args);
            if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();
                global $post;
                $get_fetch_time = get_post_meta($post->ID, 'ophim_fetch_ophim_update_time', true);
                if($get_fetch_time == $ophim_update_time) { // Không có gì cần cập nhật
                    $result = array(
                        'status'   			=> true,
                        'post_id' 			=> $post->ID,
                        'list_episode' 	=> [],
                        'msg' 					=> 'Nothing needs updating!',
                        'wait'					=> false,
                        'schedule_code' => SCHEDULE_CRAWLER_TYPE_NOTHING
                    );
                    return json_encode($result);
                }

                $api_url 			= str_replace('ophim.tv', 'ophim1.com', $url);
                $sourcePage 	=  file_get_contents($api_url);
                $sourcePage 	= json_decode($sourcePage, true);
                $data 				= create_data($sourcePage, $url, $ophim_id, $ophim_update_time);

                $status = getStatus($data['status']);

                // Re-Update Movies Info
                $formality 		= ($data['type'] == 'tv_series') ? 'tv_series' : 'single_movies';
                //
                $post_id = $post->ID;

                update_post_meta($post_id, 'ophim_movie_formality', $formality);
                update_post_meta($post_id, 'ophim_movie_status', $status);
                update_post_meta($post_id, 'ophim_fetch_info_url', $data['fetch_url']);
                update_post_meta($post_id, 'ophim_fetch_ophim_id', $data['fetch_ophim_id']);
                update_post_meta($post_id, 'ophim_fetch_ophim_update_time', $data['fetch_ophim_update_time']);
                update_post_meta($post_id, 'ophim_original_title', $data['org_title']);
                update_post_meta($post_id, 'ophim_trailer_url', $data['trailer_url']);
                update_post_meta($post_id, 'ophim_runtime', $data['duration']);
                update_post_meta($post_id, 'ophim_episode', $data['episode']);
                update_post_meta($post_id, 'ophim_total_episode', $data['total_episode']);
                update_post_meta($post_id, 'ophim_quality', $data['lang'] . ' - ' . $data['quality']);
                update_post_meta($post_id, 'ophim_showtime_movies', $data['showtime'] );
                update_post_meta($post_id, 'ophim_showtime_movies', $data['showtime'] );

                // Re-Update Episodes
                $list_episode = get_list_episode($sourcePage, $post->ID);
                $result = array(
                    'status'				=> true,
                    'post_id' 			=> $post->ID,
                    'data'					=> $data,
                    'list_episode' 	=> $list_episode,
                    'wait'					=> true,
                    'schedule_code' => SCHEDULE_CRAWLER_TYPE_UPDATE
                );
                //wp_update_post($post);
                return json_encode($result);
            endwhile;
            endif;
        }

		$api_url 		= str_replace('ophim.tv', 'ophim1.com', $url);
		$sourcePage =  file_get_contents($api_url);
		$sourcePage = json_decode($sourcePage, true);
		$data 			= create_data($sourcePage, $url, $ophim_id, $ophim_update_time, $filterType, $filterCategory, $filterCountry);
		$post_id 		= add_posts($data);
        $list_episode = get_list_episode($sourcePage, $post_id);
        $result = array(
            'status'				=> true,
            'post_id' 			=> $post_id,
            'data'					=> $url,
            'list_episode' 	=> 'Add new',
            'wait'					=> true,
            'schedule_code' => SCHEDULE_CRAWLER_TYPE_INSERT
        );
        return json_encode($result);
  } catch (Exception $e) {
		$result = array(
			'status'				=> false,
			'post_id' 			=> null,
			'data'					=> null,
			'list_episode' 	=> null,
			'msg' 					=> $e->getMessage(),
			'wait'					=> false,
			'schedule_code' => SCHEDULE_CRAWLER_TYPE_ERROR
		);
		return json_encode($result);
  }
}

function create_data($sourcePage, $url, $ophim_id, $ophim_update_time, $filterType = [], $filterCategory = [], $filterCountry = []) {
	if(in_array($sourcePage["movie"]["type"], $filterType))  {
		return array(
			'crawl_filter' => true,
		);
	}

	if($sourcePage["movie"]["type"] == "single") {
		$type = "single_movies";
	} else {
		$type	= "tv_series";
	}

	$arrCat = [];
	$arrGenres = [];
	foreach ($sourcePage["movie"]["category"] as $key => $value) {
		if(in_array($value["name"], $filterCategory))  {
			return array(
				'crawl_filter' => true,
			);
		}
		array_push($arrGenres, $value["name"]);
	}
    if($sourcePage["movie"]["type"] == "single_movies") {
        array_push($arrCat, "Phim Lẻ");
    }
	if($sourcePage["movie"]["type"] == "hoathinh") {
		array_push($arrCat, "Hoạt Hình");
		$type = (count(reset($sourcePage["episodes"])['server_data'] ?? []) > 1 ? 'series' : 'single');
	}
	if($sourcePage["movie"]["type"] == "tvshows") {
		array_push($arrCat, "TV Shows");
	}
	if($sourcePage["movie"]["type"] == "series") {
		array_push($arrCat, "Phim bộ");
	}
	if($sourcePage["movie"]["type"] == "tv_series") {
		array_push($arrCat, "Phim bộ");
	}
	if($sourcePage["movie"]["type"] == "single") {
		array_push($arrCat, "Phim Lẻ");
	}
    if($sourcePage["movie"]["chieurap"] == true) {
        array_push($arrCat, "Phim Chiếu Rạp");
    }

	$arrCountry 	= [];
	foreach ($sourcePage["movie"]["country"] as $key => $value) {
		if(in_array($value["name"], $filterCountry))  {
			return array(
				'crawl_filter' => true,
			);
		}
		array_push($arrCountry, $value["name"]);
	}

	$arrTags 			= [];
	array_push($arrTags, $sourcePage["movie"]["name"]);
	if($sourcePage["movie"]["name"] != $sourcePage["movie"]["origin_name"])
        array_push($arrTags, $sourcePage["movie"]["origin_name"]);

	$data = array(
		'crawl_filter'						=> false,
		'fetch_url' 							=> $url,
		'fetch_ophim_id' 					=> $ophim_id,
		'fetch_ophim_update_time' => $ophim_update_time,
		'title'     							=> $sourcePage["movie"]["name"],
		'org_title' 							=> $sourcePage["movie"]["origin_name"],
		'thumbnail' 							=> $sourcePage["movie"]["thumb_url"],
		'poster'   		 						=> $sourcePage["movie"]["poster_url"],
		'trailer_url'   		 			=> $sourcePage["movie"]["trailer_url"],
		'episode'									=> $sourcePage["movie"]["episode_current"],
		'total_episode'						=> $sourcePage["movie"]["episode_total"],
		'tags'      							=> $arrTags,
		'content'   							=> strip_tags(preg_replace('/\\r?\\n/s', '', $sourcePage["movie"]["content"])),
		'actor'										=> implode(',', $sourcePage["movie"]["actor"]),
		'director'								=> implode(',', $sourcePage["movie"]["director"]),
		'country'									=> $arrCountry,
		'cat'											=> $arrCat,
		'genres'											=> $arrGenres,
		'type'										=> $type,
		'lang'										=> $sourcePage["movie"]["lang"],
		'showtime'								=> $sourcePage["movie"]["showtimes"],
		'year'										=> $sourcePage["movie"]["year"],
		'is_copyright'										=> $sourcePage["movie"]["is_copyright"],
		'status'									=> $sourcePage["movie"]["status"],
		'duration'								=> $sourcePage["movie"]["time"],
		'quality'									=> $sourcePage["movie"]["quality"]
	);

	return $data;
}

function add_posts($data)
{

    $director  = explode(',', sanitize_text_field($data['director']));
    $actor     = explode(',', sanitize_text_field($data['actor']));

    $cat_id = array();
    foreach ($data['cat'] as $cat) {
        if (!term_exists($cat) && $cat != '') {
            wp_insert_term($cat, 'ophim_categories');
        }
    }
    foreach ($data['tags'] as $tag) {
        if (!term_exists($tag) && $tag != '') {
            wp_insert_term($tag, 'ophim_tags');
        }
    }
    $formality = ($data['type'] == 'tv_series') ? 'tv_series' : 'single_movies';
    $post_data = array(
        'post_title'   		=> $data['title'],
        'post_content' 		=> $data['content'],
        'post_status'  		=> 'publish',
        'post_type'  		=> 'ophim',
        'comment_status' 	=> 'closed',
        'ping_status'  		=> 'closed',
        'post_author'  		=> get_current_user_id()
    );
    $post_id 						= wp_insert_post($post_data);

    if(json_decode(get_option(CRAWL_OPHIM_OPTION_SETTINGS, false))->crawl_download_img == 'on'){
        if($data['poster'] && $data['poster'] != "") {
            $res 								= save_images($data['poster'], $post_id, $data['title']);
            $poster_image_url 	= str_replace(get_site_url(), '', $res['url']);
        }
        $res_thumb =    save_images($data['thumbnail'], $post_id, $data['title'], true);
        $thumb_image_url 		= str_replace(get_site_url(), '', $res_thumb['url']);
    }else{
        $poster_image_url =$data['poster'];
        $thumb_image_url = $data['thumbnail'];
    }
    $status = getStatus($data['status']);
    //
    update_post_meta($post_id, 'ophim_movie_formality', $formality);
    update_post_meta($post_id, 'ophim_movie_status', $status);
    update_post_meta($post_id, 'ophim_fetch_info_url', $data['fetch_url']);
    update_post_meta($post_id, 'ophim_fetch_ophim_id', $data['fetch_ophim_id']);
    update_post_meta($post_id, 'ophim_fetch_ophim_update_time', $data['fetch_ophim_update_time']);
    update_post_meta($post_id, 'ophim_poster_url', $poster_image_url);
    update_post_meta($post_id, 'ophim_thumb_url', $thumb_image_url);
    update_post_meta($post_id, 'ophim_original_title', $data['org_title']);
    update_post_meta($post_id, 'ophim_trailer_url', $data['trailer_url']);
    update_post_meta($post_id, 'ophim_runtime', $data['duration']);
    update_post_meta($post_id, 'ophim_rating', '');
    update_post_meta($post_id, 'ophim_votes', '');
    update_post_meta($post_id, 'ophim_episode', $data['episode']);
    update_post_meta($post_id, 'ophim_total_episode', $data['total_episode']);
    update_post_meta($post_id, 'ophim_quality', $data['quality']);
    update_post_meta($post_id, 'ophim_lang', $data['lang']);
    update_post_meta($post_id, 'ophim_showtime_movies', $data['showtime'] );
    update_post_meta($post_id, 'ophim_year', $data['year'] );
    update_post_meta($post_id, 'ophim_is_copyright', $data['is_copyright'] );
    //
    wp_set_object_terms($post_id, $status, 'status', false);

    wp_set_object_terms($post_id, $director, 'ophim_directors', false);
    wp_set_object_terms($post_id, $actor, 'ophim_actors', false);
    wp_set_object_terms($post_id, sanitize_text_field($data['year']), 'ophim_years', false);
    wp_set_object_terms($post_id, $data['country'], 'ophim_regions', false);
    wp_set_object_terms($post_id, $data['cat'],'ophim_categories',false);
    wp_set_object_terms($post_id, $data['tags'],'ophim_tags',false);
    wp_set_object_terms($post_id, $data['genres'],'ophim_genres',false);

    return $post_id;
}

function save_images($image_url, $post_id, $posttitle, $set_thumb = false)
{
	// $image_url = str_replace('img.ophim1.com', 'img.hiephanhthienha.com', $image_url);
	// Khởi tạo curl để tải về hình ảnh
	$ch = curl_init($image_url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36");
	$file = curl_exec($ch);
	curl_close($ch);

	$postname 		= sanitize_title($posttitle);
	$im_name 			= "$postname-$post_id.jpg";
	$res 					= wp_upload_bits($im_name, '', $file);
	insert_attachment($res['file'], $post_id, $set_thumb);
	return $res;
}

function insert_attachment($file, $post_id, $set_thumb)
{
	$dirs 							= wp_upload_dir();
	$filetype 					= wp_check_filetype($file);
	$attachment 				= array(
		'guid' 						=> $dirs['baseurl'] . '/' . _wp_relative_upload_path($file),
		'post_mime_type' 	=> $filetype['type'],
		'post_title' 			=> preg_replace('/\.[^.]+$/', '', basename($file)),
		'post_content' 		=> '',
		'post_status' 		=> 'inherit'
	);
	$attach_id 					= wp_insert_attachment($attachment, $file, $post_id);
	$attach_data 				= wp_generate_attachment_metadata($attach_id, $file);
	wp_update_attachment_metadata($attach_id, $attach_data);
	if ($set_thumb != false) set_post_thumbnail($post_id, $attach_id);
	return $attach_id;
}

function get_list_episode($sourcePage, $post_id)
{
    update_post_meta($post_id, 'ophim_episode_list', $sourcePage["episodes"]);
	return json_encode($sourcePage["episodes"]);
}

function slugify($str, $divider = '-')
{
	$str = trim(mb_strtolower($str));
	$str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
	$str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
	$str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
	$str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
	$str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
	$str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
	$str = preg_replace('/(đ)/', 'd', $str);
	$str = preg_replace('/[^a-z0-9-\s]/', '', $str);
	$str = preg_replace('/([\s]+)/', $divider, $str);
	return $str;
}

function getStatus($status) {
	$hl_status = "completed";
	switch (strtolower($status)) {
		case 'ongoing':
			$hl_status = "ongoing";
			break;
		case 'completed':
			$hl_status = "completed";
			break;
		default:
			$hl_status = "is_trailer";
			break;
	}
	return $hl_status;
}