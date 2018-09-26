<?
//if($GLOBALS['arCity']['NAME']=="������"){header('Location: http://1relax.ru');}
//��� ������� � Ajax ������
if( $_POST['isAjax'] ){
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
} else {
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetPageProperty("keywords", "������, ����������� ������, �������, ������, �������, ���� �������, ��� ������, ������� ����������, ����������� ������ � ".$GLOBALS["arCity"]["PROPERTY_DEC_VALUE"][5].", base massage");
    $APPLICATION->SetPageProperty("title", "����������� ������ � ".$GLOBALS["arCity"]["PROPERTY_DEC_VALUE"][5]." - ������ � ������� ����������");
    $APPLICATION->SetDirProperty("keywords", "����������� ������ � ".$GLOBALS["arCity"]["PROPERTY_DEC_VALUE"][5].", ����������� ������ ".$GLOBALS["arCity"]["NAME"].", ������ ������");
    $APPLICATION->SetDirProperty("description", "����������� ������ � ".$GLOBALS["arCity"]["PROPERTY_DEC_VALUE"][5].", ������ � ������� ���������� ��� ������ ".$GLOBALS["arCity"]["NAME"]."");
    $APPLICATION->SetTitle("����������� ������ � ".$GLOBALS["arCity"]["PROPERTY_DEC_VALUE"][5]);

}

//�������� �� ������� ���� /metro/
if (substr($_SERVER['REQUEST_URI'], 0, 7) == '/metro/' && ! isset($_GET["METRO_CODE"])) {
	LocalRedirect("/", false, "301 Moved permanently");
}


$metroCode = $_GET['METRO_CODE'];
$rayonCode = $_GET['RAYON_CODE'];


//print_r($_GET);print_r($GLOBALS["arCity"]);//die;

//��������� �������

global $arrFilterSalons;
$arrFilterSalons["PROPERTY_CITY"] = $GLOBALS["arCity"]["ID"];

$cityTitle = ( $GLOBALS["arCity"]['PROPERTY_TITLE_VALUE'] ) ? $GLOBALS["arCity"]['PROPERTY_TITLE_VALUE'] : false;
$cityDesc = ( $GLOBALS["arCity"]['PROPERTY_DESC_VALUE'] ) ? $GLOBALS["arCity"]['PROPERTY_DESC_VALUE'] : false;
$cityKeyWords = ( $GLOBALS["arCity"]['PROPERTY_KEYWORDS_VALUE'] ) ? $GLOBALS["arCity"]['PROPERTY_KEYWORDS_VALUE'] : false;



//�����
//������ ������ ��� ���������� ������ ��� ������
$metro_station = array();
if($metroCode && in_array($GLOBALS["arCity"]["CODE"], array("msk", "spb")))
{
	$arFilter = Array(
		"IBLOCK_CODE"=> "metro_stations",
		"CODE" => $metroCode,
		"ACTIVE_DATE"=>"Y",
		"ACTIVE"=>"Y",
		'PROPERTY_CITY' => $GLOBALS["arCity"]["ID"]
	);
	$res = CIBlockElement::GetList(array(), $arFilter);



	if($ob = $res->GetNextElement())
	{
		$metro_station = $ob->GetFields();
		$metro_station["PROPERTIES"] = $ob->GetProperties();
		
	if (isset($_GET['TEST4']))
		var_dump($metro_station["PROPERTIES"]["CITY"]["VALUE"]);
		//���� ������ �� ���������
		if( $GLOBALS["arCity"]["ID"] != $metro_station["PROPERTIES"]["CITY"]["VALUE"] )
			$metro_station = array();


	}
}



//����� �������� ������� �� ��������
$arFilter = Array("IBLOCK_ID" => 2,  "ACTIVE" => "Y", "ID" => $GLOBALS["arCity"]["ID"]);
$res = CIBlockElement::GetList( Array(), $arFilter, false, false, array("PROPERTY_*","ID", "IBLOCK_ID") );
$arProps = $res->GetNextElement()->GetProperties();

$transMap = array();
foreach ($arProps['RAYON']['VALUE'] as $key => $value) {

    $trans = $arProps['RAYON_TRANS']['VALUE'][$key];
    if( !$trans ) continue;
    $transMap[$value] = $trans;
}
//������ ��� ��������� ��������������
$transMapReverse = array_flip($transMap);


if( $transMapReverse[$rayonCode] ){
    $APPLICATION->SetDirProperty("description", "������ ������� ������������ ������� � �. {$GLOBALS["arCity"]["PROPERTY_DEC_VALUE"][0]} {$transMapReverse[$rayonCode]} ����� �� ����� 1RELAX. ����������� ������ ����� ����� � ��� ���� ���������!");
    $APPLICATION->SetTitle("������ ������������ ������� {$transMapReverse[$rayonCode]} ����� {$GLOBALS["arCity"]["PROPERTY_DEC_VALUE"][0]} � 1RELAX");
    $APPLICATION->SetPageProperty('title', "������ ������������ ������� {$transMapReverse[$rayonCode]} ����� {$GLOBALS["arCity"]["PROPERTY_DEC_VALUE"][0]} � 1RELAX");
}

if( $cityTitle ){
    $APPLICATION->SetTitle($cityTitle);
    $APPLICATION->SetPageProperty('title',$cityTitle);
}

if( $cityDesc )
    $APPLICATION->SetDirProperty('description',$cityDesc);

if( $cityKeyWords ){
    $APPLICATION->SetDirProperty('keywords',$cityKeyWords);
    $APPLICATION->SetPageProperty('keywords',$cityKeyWords);
}

//METRO filter && META
$breadcrumbs = array();
if($metro_station)
{
	//filter
	$arrFilterSalons["PROPERTY_METRO"] = $metro_station["ID"];
	
	//title
	$title = (isset($metro_station["PROPERTIES"]["TITLE"]["VALUE"]["TEXT"]) && $metro_station["PROPERTIES"]["TITLE"]["VALUE"]["TEXT"])
				? $metro_station["PROPERTIES"]["TITLE"]["VALUE"]["TEXT"]
				: "����������� ������ � {$metro_station["NAME"]}. ������ ������������ ������� ����� {$metro_station["NAME"]} � 1RELAX";


	$APPLICATION->SetPageProperty('title', $title);
	
	//description
	$description = (isset($metro_station["PROPERTIES"]["DESCRIPTION"]["VALUE"]["TEXT"]) && $metro_station["PROPERTIES"]["DESCRIPTION"]["VALUE"]["TEXT"])
				? $metro_station["PROPERTIES"]["DESCRIPTION"]["VALUE"]["TEXT"]
				: "������� ������� ������������ ������� ����� ����� {$metro_station["NAME"]}. ����������� ������ ��� ������ ����� {$metro_station["NAME"]} (18+).";
	$APPLICATION->SetDirProperty("description", $description);
	
	$breadcrumbs = array(
		array(
			'title' => $metro_station["NAME"],
			'link' => "/metro/{$metro_station["CODE"]}/"
		)
	);
}

/*�������� ��� �������*/
if( $transMapReverse[$rayonCode] ){
    $arFilter = Array("IBLOCK_CODE" => 'rayonfootertext',  "ACTIVE" => "Y", "PROPERTY_RAYON" => $transMapReverse[$rayonCode]);
    $res = CIBlockElement::GetList( Array(), $arFilter, false, false, array("PROPERTY_*","ID", "IBLOCK_ID") );
    
	if ( $element = $res->GetNextElement() ) {
		$arProps = $element->GetProperties();
		if( $arProps ){
			$arProps = array_map(function( $e ){
				if ( in_array($e['CODE'], array('TITLE','DESCRIPTION','KEYWORDS')) )
					return $e['VALUE'];
			}, $arProps);

			if( $arProps['TITLE'] ){
				$APPLICATION->SetTitle($arProps['TITLE']);
				$APPLICATION->SetPageProperty('title',$arProps['TITLE']);
			}
			 if( $arProps['DESCRIPTION'] ){
				$APPLICATION->SetDirProperty('description',$arProps['DESCRIPTION']);
			}
			 if( $arProps['KEYWORDS'] ){
				$APPLICATION->SetDirProperty('keywords',$arProps['KEYWORDS']);
				$APPLICATION->SetPageProperty('keywords',$arProps['KEYWORDS']);
			}
		}
	}
}
/*--�������� ��� �������--*/






if( !$_POST['isAjax'] ){
    if(strlen( $_REQUEST["rayon"])>0)
        $arrFilterSalons["PROPERTY_RAYON"] = $_REQUEST["rayon"];
    else
        if( $transMapReverse[$rayonCode] )
            $arrFilterSalons["PROPERTY_RAYON"] = $transMapReverse[$rayonCode];

    if(strlen( $_REQUEST["min_price_ot"])>0)
        $arrFilterSalons[">=PROPERTY_7"] = (int)$_REQUEST["min_price_ot"];
    if(strlen( $_REQUEST["min_price_do"])>0)
        $arrFilterSalons["<=PROPERTY_7"] = (int)$_REQUEST["min_price_do"];
} else {

    foreach ($_POST['data'] as $key => $value) {
        if( $value['name'] === 'rayon' ) $arrFilterSalons["PROPERTY_RAYON"] = $transMapReverse[$value['value']];
            
        if( $value['name'] === 'min_price_ot' && $value['value'] ) $arrFilterSalons[">=PROPERTY_7"] = $value['value'];
            
        if( $value['name'] === 'min_price_do' && $value['value'] ) $arrFilterSalons["<=PROPERTY_7"] = $value['value'];
    }

    
}



$arrFilterSalons["PROPERTY_ACTIVE_ADMINISTRATOR"] = false;



if($breadcrumbs)
	breadcrumbs($breadcrumbs);

?>
<div class="inSpisok" >
<?$APPLICATION->IncludeComponent("bitrix:news.list", "salons", array(
	"IBLOCK_TYPE" => "content",
	"IBLOCK_ID" => "1",
	"NEWS_COUNT" => "9999",
	"SORT_BY1" => "PROPERTY_SORT",
	"SORT_ORDER1" => "DESC",
	"SORT_BY2" => "PROPERTY_SUMM",
	"SORT_ORDER2" => "DESC",
	"FILTER_NAME" => "arrFilterSalons",
	"FIELD_CODE" => array(
		0 => "",
		1 => "",
	),
	"PROPERTY_CODE" => array(
		0 => "ADRESS",
		1 => "TIME_START",
		2 => "TIME_END",
		3 => "PRICE",
		4 => "SUMM",
		5 => "CLICK",
		6 => "SORT",
		7 => "CHECKBC",
		7 => "REKLAMA_OFF",
		8 =>"CHECKBC"
	),
	"CHECK_DATES" => "Y",
	"DETAIL_URL" => "",
	"AJAX_MODE" => $_POST['isAjax'],
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "N",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_FILTER" => "Y",
	"CACHE_GROUPS" => "N",
	"PREVIEW_TRUNCATE_LEN" => "",
	"ACTIVE_DATE_FORMAT" => "d.m.Y",
	"SET_TITLE" => "N",
	"SET_STATUS_404" => "N",
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
	"ADD_SECTIONS_CHAIN" => "N",
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",
	"PARENT_SECTION" => "",
	"PARENT_SECTION_CODE" => "",
	"INCLUDE_SUBSECTIONS" => "Y",
	"DISPLAY_TOP_PAGER" => "Y",
	"DISPLAY_BOTTOM_PAGER" => "Y",
	"PAGER_TITLE" => "������",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_TEMPLATE" => "home",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "N",
	"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?>
</div>


<div class="inMap"  style="display: none">

    <?$APPLICATION->IncludeComponent("bitrix:news.list", "salonsInMap", array(
            "IBLOCK_TYPE" => "content",
            "IBLOCK_ID" => "1",
            "NEWS_COUNT" => "999",
            "SORT_BY1" => "PROPERTY_SORT",
            "SORT_ORDER1" => "DESC",
            "SORT_BY2" => "PROPERTY_SUMM",
            "SORT_ORDER2" => "DESC",
            "FILTER_NAME" => "arrFilterSalons",
            "FIELD_CODE" => array(
                0 => "",
                1 => "",
            ),
    "PROPERTY_CODE" => array(
        0 => "ADRESS",
        1 => "TIME_START",
        2 => "TIME_END",
        3 => "PRICE",
        4 => "SUMM",
        5 => "CLICK",
        6 => "SORT",
        7 => "CHECKBC",
        7 => "REKLAMA_OFF",
        8 =>"CHECKBC"
    ),
            "CHECK_DATES" => "Y",
            "DETAIL_URL" => "",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "N",
            "AJAX_OPTION_HISTORY" => "N",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "CACHE_FILTER" => "Y",
            "CACHE_GROUPS" => "N",
            "PREVIEW_TRUNCATE_LEN" => "",
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "SET_TITLE" => "N",
            "SET_STATUS_404" => "N",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "ADD_SECTIONS_CHAIN" => "N",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "PARENT_SECTION" => "",
            "PARENT_SECTION_CODE" => "",
            "INCLUDE_SUBSECTIONS" => "Y",
            "DISPLAY_TOP_PAGER" => "Y",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "PAGER_TITLE" => "������",
            "PAGER_SHOW_ALWAYS" => "Y",
            "PAGER_TEMPLATE" => "",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "AJAX_OPTION_ADDITIONAL" => ""
        ),
        false
    );?>
</div>




<?php


if( !$_POST['isAjax'] )
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>