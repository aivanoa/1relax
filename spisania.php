<?php
/**
 * Created by PhpStorm.
 * User: repin_000
 * Date: 23.09.2015
 * Time: 9:26
 */

require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
if(!$USER->IsAdmin() || !$_REQUEST["ID"])
    die;

if(CModule::IncludeModule("iblock")) {
    $res = CIBlockElement::GetList(array("CREATED"=>"DESC"), array(	"IBLOCK_ID" => 9,
																	"PROPERTY_SALON"=>$_REQUEST["ID"], 
																	">=DATE_CREATE"=>"16.07.2018",
																	"<DATE_CREATE"=>"17.07.2018",
																	));
	$total = $count =  0;
    while ($el = $res->GetNextElement()) {
   
        $arProp = $el->GetProperties();
        $arF = $el->GetFields();
        echo "<pre>";
        print_r($arProp[IP][VALUE]);
        echo "</pre>";

		echo "<pre>";
		var_dump( file_get_contents('http://ipgeobase.ru:7020/geo?ip=' . $arProp[IP][VALUE]) );
		echo "</pre>";
		
        echo "<pre>";
        print_r($arF["DATE_CREATE"]);
        echo "</pre>";
        echo "<pre>";
        print_r($arProp[SUMM][VALUE]);
        echo " rub.</pre>";
        echo "<hr>";
		$total += $arProp[SUMM][VALUE];
		$count++;
    }
	echo "<hr>";
	echo "Итого " . $total . ' руб<br>';
	echo "Итого " . $count . ' кликов';
}