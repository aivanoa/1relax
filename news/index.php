<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$cityTitle = $GLOBALS["arCity"]["PROPERTY_DEC_VALUE"][5];

$page_ = 0;
if($_GET)
	foreach($_GET as $key => $val)
		if(strpos($key, "PAGEN") !== false){
			$page_= (int)$val;
			break;
		}
define("CURRENT_PAGE", $page_);
$cur_page = (CURRENT_PAGE) ? " – страница ".CURRENT_PAGE : "";
$cur_page2 = (CURRENT_PAGE) ? " Страница ".CURRENT_PAGE."." : "";


if (   $GLOBALS["arCity"]['PROPERTY_ACTIONS_TITLE_VALUE'] != '' ){
	$APPLICATION->SetPageProperty("title", $GLOBALS["arCity"]['PROPERTY_ACTIONS_TITLE_VALUE']);	
}
else
	$APPLICATION->SetPageProperty("title", "Акции салонов эротического массажа города {$GLOBALS["arCity"]["NAME"]} – 1RELAX{$cur_page}");

if (   $GLOBALS["arCity"]['PROPERTY_ACTIONS_DESC_VALUE'] != '' ){
	$APPLICATION->SetPageProperty("description", $GLOBALS["arCity"]['PROPERTY_ACTIONS_DESC_VALUE']);	
}
else
	$APPLICATION->SetPageProperty("description", "Специальные предложения и акции от салонов эротического массажа в г. {$GLOBALS["arCity"]["NAME"]}. На сайте 1RELAX.RU представлены все актуальные акционные предложения салонов эротического массажа в городе {$GLOBALS["arCity"]["NAME"]}. {$cur_page2}");

if (   $GLOBALS["arCity"]['PROPERTY_ACTIONS_KEYWORDS_VALUE'] != '' ){
	$APPLICATION->SetPageProperty("keywords", $GLOBALS["arCity"]['PROPERTY_ACTIONS_KEYWORDS_VALUE']);	
}


if( $_GET['PAGEN_1'] ) $catlink = '/news/';
breadcrumbs(array(
	array(
		'title' => 'Акции салонов'
	),
), $catlink);

	global $arrFilterNews;
	$arrFilterNews[0] = array(
		"LOGIC" => "OR",
		array("PROPERTY_CITY" => $GLOBALS["arCity"]["ID"]),
		array("PROPERTY_CITY" => false),
	);


$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_*"); //IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
$arFilter = Array(
"IBLOCK_ID" => IntVal(1),
"ACTIVE" => "Y",
"PROPERTY_CITY" => $GLOBALS["arCity"]["ID"],
">PROPERTY_SUMM"=>0,
"!=PROPERTY_ACTIVE_ADMINISTRATOR" => "Y",
);
$res = CIBlockElement::GetList(Array(), $arFilter, false,false, $arSelect);
while ($ob = $res->GetNextElement()) {
    $arFields = $ob->GetFields();
    $arProps = $ob->GetProperties();
	

	if ( $arProps['ACTIVE_ADMINISTRATOR']['VALUE'] == 'Y' )
		continue;
	
    $id[] = $arFields["ID"];
}
if(count($id)>0)
    $arrFilterNews[1] = array("PROPERTY_SALON"=>$id);
else
    $arrFilterNews[1] = array("PROPERTY_SALON"=>-1);
	
?>
<?$APPLICATION->IncludeComponent("bitrix:news", "news", array(
	"IBLOCK_TYPE" => "content",
	"IBLOCK_ID" => "6",
	"NEWS_COUNT" => "20",
	"USE_SEARCH" => "N",
	"USE_RSS" => "N",
	"USE_RATING" => "N",
	"USE_CATEGORIES" => "N",
	"USE_FILTER" => "Y",
	"FILTER_NAME" => "arrFilterNews",
	"FILTER_FIELD_CODE" => array(
		0 => "",
		1 => "",
	),
	"FILTER_PROPERTY_CODE" => array(
		0 => "",
		1 => "",
	),
	"SORT_BY1" => "DATE_CREATE",
	"SORT_ORDER1" => "DESC",
	"SORT_BY2" => "SORT",
	"SORT_ORDER2" => "ASC",
	"CHECK_DATES" => "Y",
	"SEF_MODE" => "Y",
	"SEF_FOLDER" => "/news/",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "N",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_FILTER" => "Y",
	"CACHE_GROUPS" => "N",
	"SET_TITLE" => "N",
	"SET_STATUS_404" => "N",
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
	"ADD_SECTIONS_CHAIN" => "N",
	"USE_PERMISSIONS" => "N",
	"PREVIEW_TRUNCATE_LEN" => "",
	"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
	"LIST_FIELD_CODE" => array(
		0 => "NAME",
		1 => "PREVIEW_TEXT",
		2 => "DATE_CREATE",
		3 => "",
	),
	"LIST_PROPERTY_CODE" => array(
		0 => "SALON",
		1 => "SUMM",
        2=>"CLICK"
	),
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",
	"DISPLAY_NAME" => "N",
	"META_KEYWORDS" => "-",
	"META_DESCRIPTION" => "-",
	"BROWSER_TITLE" => "-",
	"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
	"DETAIL_FIELD_CODE" => array(
		0 => "NAME",
		1 => "PREVIEW_TEXT",
		2 => "DATE_CREATE",
		3 => "",
	),
	"DETAIL_PROPERTY_CODE" => array(
		0 => "SALON",
		1 => "",
	),
	"DETAIL_DISPLAY_TOP_PAGER" => "N",
	"DETAIL_DISPLAY_BOTTOM_PAGER" => "N",
	"DETAIL_PAGER_TITLE" => "",
	"DETAIL_PAGER_TEMPLATE" => "",
	"DETAIL_PAGER_SHOW_ALL" => "N",
	"DISPLAY_TOP_PAGER" => "Y",
	"DISPLAY_BOTTOM_PAGER" => "Y",
	"PAGER_TITLE" => "Новости и акции",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_TEMPLATE" => "news",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "N",
	"AJAX_OPTION_ADDITIONAL" => "",
	"SEF_URL_TEMPLATES" => array(
		"news" => "",
		"section" => "",
		"detail" => "#ELEMENT_ID#/",
	)
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>