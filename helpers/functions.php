<?php
function cutHtml($string, $begin, $end)
{
	$middle = explode($begin, $string);
	$result = explode($end, $middle[1]);
	return $result[0];
}

function cutStr($string, $begin, $end)
{
	$middle = explode($begin, $string);
	$result = explode($end, $middle[1]);
	return strip_tags(trim($result[0]));
}

function cleanStr($str)
{
	$str = str_replace("&nbsp;", " ", $str);
	$str = preg_replace('/\s+/', ' ', $str);
	$str = trim($str);
	return $str;
}

function oIsset($data, $meta, $default = '')
{
    if(!is_array($data)) {
        $data = json_encode($data);
        $data = json_decode($data, true);
    }
    return isset($data[$meta]) ? $data[$meta] : $default;
}
