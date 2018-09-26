<?php
$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__)."/..");
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php"); 
$filename = dirname(__FILE__)."/../sitemaps/sitemap.xml";

$sitemap = 
'<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<script type="text/javascript" charset="utf-8" id="zm-extension"/>
';
	
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"),array("IBLOCK_ID" => 2,"ACTIVE" => "Y"), false, false, array());
while($arCity = $res->GetNext())
{
	$sitemap .= 
'
<sitemap>
<loc>http://'. $arCity["CODE"] .'.1relax.ru/sitemap.xml</loc>
</sitemap>
';
}
$sitemap .= '</sitemapindex>';
file_put_contents($filename, $sitemap);