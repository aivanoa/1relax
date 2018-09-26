<?php
header("Content-Type: text/xml");
$city = array_shift((explode('.', $_SERVER['HTTP_HOST'])));

if ($city != '1relax'){
	$start = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
	$body = file_get_contents("sitemaps/$city.xml", true); 
	$end = '</urlset>';
	echo $start;
	echo $body;
	echo $end;
}
else
	echo file_get_contents("sitemaps/sitemap.xml", true); 
?>