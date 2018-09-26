<?php  


$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__)."/..");
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php"); 
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if(!CModule::IncludeModule("iblock")) die(); 


//перебор всех кликов, фильтр по дате
function each_click( $callback )
{
	$day = 1;
	$arFilter = array(
		'IBLOCK_CODE' => 'spending',
		'<=DATE_CREATE' => ConvertTimeStamp(time(), "FULL"),
		'>=DATE_CREATE' => ConvertTimeStamp(time()-86400*$day , "FULL"),
		);
	$arSelectFields = array(
		'PROPERTY_SUMM',
		'PROPERTY_SALON',
		'PROPERTY_REASON',
		'PROPERTY_IP',
		'PROPERTY_USER',
		'DATE_CREATE'
		);
	$res = CIBlockElement::GetList( array(), $arFilter, false, ['nPageSize' => 10], $arSelectFields );
	while ( $qwe = $res->GetNext() ) {
		$callback( $qwe );
	}
	
}


//получить страну по IP
function getCountry( $ip )
{
	// $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
	$details = json_decode(file_get_contents("http://api.sypexgeo.net/ajh71/json/{$ip}"));
	return $details->country;
}


//перебор кликов не из России
function each_not_RU( $callback )
{
	each_click( function( $data ) use ( $callback ){

		$country =  getCountry( $data['PROPERTY_IP_VALUE'] );
		if ( $country == 'RU' || $country == '' || $data['PROPERTY_SALON_VALUE'] == '' ) return;

		$callback( $data['PROPERTY_SALON_VALUE'] );

	} );
}


//перебор опасных кликов( более 5 кликов )
function each_danger_click( $callback ){
	$res = array();
	each_not_RU( function( $salon ) use ( &$res ) {
		$res[$salon]['cnt'] += 1; 
	} );

	foreach ($res as $key => $value) {
		if ( $value['cnt'] >= 5 ) $callback( $key );
	}

}


//отослать уведомление на почту
function send_mail(){
	$dc = array();
	each_danger_click(function( $salon ) use ( &$dc ) {
		$dc[] = $salon;
	});

	$dc = implode($dc, '<br>');

	$to      = '';
	$subject = 'Подозрительные клики';
	$message = 'У следующих салонов есть подозрительные клики:<br> '. $dc .' ';
	$headers = 'From: noreply@1relax.ru' . "\r\n" .
	    'Reply-To: noreply@1relax.ru' . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();
	mail($to, $subject, $message, $headers);
}

send_mail();

