#!/usr/bin/php
<?php

/*
** $> cat > page.html
** <html><head><title>Nice page</title></head>
** <body>Hello World <a href=http://cyan.com title="a link">This is a link</a>
** <br /><a href=http://www.riven.com> And this too <img src=wrong.image title="
** And also this"></a>
** </body></html>
** ^D
** $> ./magnifying_glass.php page.html > new_page.html
** $> cat new_page.html
** <html><head><title>Nice page</title></head>
** <body>Hello World <a href=http://cyan.com title="A LINK">THIS IS A LINK</a>
** <br /><a href=http://www.riven.com> AND THIS TOO <img src=wrong.image title=" AND ALSO THIS"></a>
** </body></html>
** $>
*/

if ($argc < 2)
    return;

if (!file_exists($argv[1]))
    return;

function enlarge_title_1($match) {
    return 'title="' . strtoupper($match[1]) . '"';
}

function enlarge_title_2($match) {
    return 'title="' . strtoupper($match[1]);
}

function enlarge_non_tag($match) {
    return strtoupper($match[1]) . $match[2] . strtoupper($match[3]);
}

$data = file_get_contents($argv[1]);
$data = preg_replace_callback('/(<a.*?>)([\s\S]*?)(<\/a>)/im', function ($match) {

	$match_title_1 = '/title="([^"]+)"/';
	// $match_title_2 = '/title=([^" ]+)/';
	$match_non_tag = '/(.*?)(<[^>]+>)(.*?)/';

	$link_tag_1 = $match[1];
	$link_tag_1 = preg_replace_callback($match_title_1, 'enlarge_title_1', $link_tag_1);
	// $link_tag_1 = preg_replace_callback($match_title_2, 'enlarge_title_2', $link_tag_1);

	$contents = $match[2];
	$has_tags = preg_match($match_non_tag, $contents);
	if ($has_tags) {
		$contents = preg_replace_callback($match_non_tag, 'enlarge_non_tag', $contents);
		$contents = preg_replace_callback($match_title_1, 'enlarge_title_1', $contents);
		// $contents = preg_replace_callback($match_title_2, 'enlarge_title_2', $contents); 
	} else {
		$contents = strtoupper($contents);
	}

	$link_tag_2 = $match[3];
	$ret = $link_tag_1 . $contents . $link_tag_2;

	return $ret;
}, $data);

echo $data;
