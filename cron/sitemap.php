<?php
$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__)."/..");
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php"); 
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if(!CModule::IncludeModule("iblock")) die(); 




$arSelect = Array("PROPERTY_*","ID", "CODE", "NAME");
$arFilter = Array("IBLOCK_ID"=>2, "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

$cities = array();
while($ob = $res->GetNextElement()) $cities[] = $ob->GetFields();


function xmlRow($loc, $city)
{
	$lastmod = date('Y-m-d');
	$base = 'http://'.$city.'.1relax.ru';
	$_loc = $base.$loc;

	return "<url>\n\t<loc>$_loc</loc>\n\t<lastmod>$lastmod</lastmod>\n</url>\n";
}
$salonsLinks = array_map(function( $city ){

	$arSelect = Array("PROPERTY_CITY","ID", "CODE", "NAME","DETAIL_PAGE_URL"); 
	$arFilter = Array("IBLOCK_ID" => 1,  "ACTIVE" => "Y", "PROPERTY_ACTIVE_ADMINISTRATOR"=>false, "PROPERTY_CITY" => $city['ID']);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

	$salons = array();
	$girls = array();
	while ($ob = $res->GetNextElement()){
		$t = $ob->GetFields();

		$salons[] = xmlRow( $t['DETAIL_PAGE_URL'], $city['CODE'] );
		
		//девушки по салону
		$arFilter = Array("IBLOCK_ID"=>3, "PROPERTY_SALON"=>$t["ID"], "ACTIVE" => "Y");
		$resg = CIBlockElement::GetList(array(),$arFilter);
		while($arGirls = $resg->GetNext())
		{
			$girls[] = xmlRow( $t['DETAIL_PAGE_URL']."girl-".$arGirls["ID"]."/", $city['CODE'] );
		}
	};


	$arSelect = Array("PROPERTY_CITY","ID", "CODE", "NAME","DETAIL_PAGE_URL"); 
	$arFilter = Array("IBLOCK_ID" => 7,  "ACTIVE" => "Y", "PROPERTY_CITY" => $city['ID']);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

	$articles = array();
	while ($ob = $res->GetNextElement()){
		$t = $ob->GetFields();

		$articles[] = xmlRow( $t['DETAIL_PAGE_URL'], $city['CODE'] );
	};

	$salons = array_merge(array(
		xmlRow( '/', $city['CODE'] ),
		xmlRow( '/salons/', $city['CODE'] ),
		xmlRow( '/girls/', $city['CODE'] ),
		xmlRow( '/news/', $city['CODE'] ),
		// xmlRow( '/vacancy/', $city['CODE'] ),
		// xmlRow( '/reklama/', $city['CODE'] ),
		xmlRow( '/articles/', $city['CODE'] ),
		xmlRow( '/about/', $city['CODE'] ),
	), $salons, $articles, $girls );
	    
	return array_merge($city, array(
		'URLS' => implode($salons, "\n")
	));

}, $cities);



array_walk($salonsLinks, function($el){
	$string =  $el['URLS'];
	$file = "/home/bitrix/ext_www/1relax.ru/sitemaps/{$el['CODE']}.xml";
	
	echo $file, "\r\n";
	
	file_put_contents($file, $string );
});
