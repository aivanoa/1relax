<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

if($_GET['PAGEN_1'] > 1){
	$page = ' - Страница ' . $_GET['PAGEN_1'];
	$pageForH1 = ', страница ' . $_GET['PAGEN_1'];
	$pageDesc = '. Страница ' . $_GET['PAGEN_1'];
} else {
	$page = '';
	$pageForH1 = '';
	$pageDesc = '';
}

breadcrumbs(array(
	array(
		'title' => 'Избранное'
	),
), $catlink);

$cityTitle = $GLOBALS["arCity"]["PROPERTY_DEC_VALUE"][0];

if (   $GLOBALS["arCity"]['PROPERTY_GIRLS_TITLE_VALUE'] != '' ){
	$APPLICATION->SetPageProperty("title", $GLOBALS["arCity"]['PROPERTY_GIRLS_TITLE_VALUE'] . $page);	
}
else
	$APPLICATION->SetPageProperty("title", "Девушки салонов эротического массажа города $cityTitle – 1RELAX$page");

if (   $GLOBALS["arCity"]['PROPERTY_GIRLS_DESC_VALUE'] != '' ){
	$APPLICATION->SetPageProperty("description", $GLOBALS["arCity"]['PROPERTY_GIRLS_DESC_VALUE'] . $pageDesc);	
}
else
	$APPLICATION->SetPageProperty("description", "Фото девушек, предоставляющих эротический массаж в городе $cityTitle. На сайте 1RELAX.RU только проверенные анкеты эротических массажисток в г. $cityTitle$pageDesc.");

if (   $GLOBALS["arCity"]['PROPERTY_GIRLS_KEYWORDS_VALUE'] != '' ){
	$APPLICATION->SetPageProperty("keywords", $GLOBALS["arCity"]['PROPERTY_GIRLS_KEYWORDS_VALUE']);	
}


if( $_GET['PAGEN_1'] ) $catlink = '/favorites/';
?> 



<script src="/bitrix/templates/main/js/ion.rangeSlider.js"></script>
<script>
	$("#range").ionRangeSlider({
		type: 'double',
		min: 18,
		max: 70,
		step: 1
	});
</script>
<link rel="stylesheet" href="/bitrix/templates/main/css/ion.rangeSlider.css">
<link rel="stylesheet" href="/bitrix/templates/main/css/ion.rangeSlider.skinHTML5.css">






<?
/* Получим ID активных салонов + салон не должен быть выключен админом */

$arSalonsFilter = array(
	"IBLOCK_ID" => 1,
	"PROPERTY_CITY" => $arCity["ID"],
	"ACTIVE" => 'Y',
	"ACTIVE_DATE" => 'Y',
	"!=PROPERTY_ACTIVE_ADMINISTRATOR" => "Y"
);

$arSalonSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_ACTIVE_ADMINISTRATOR");
$res = CIBlockElement::GetList(Array(), $arSalonsFilter, false, false, $arSalonSelect);
$EnabledSalons = array();
while($ob = $res->GetNextElement()){ 
	$arSalonFields = $ob->GetFields();  
	
	if ( $arSalonFields['PROPERTY_ACTIVE_ADMINISTRATOR_VALUE'] == 'Y' )
		continue;
	
	$EnabledSalons[] = $arSalonFields['ID'];	
}
	
if ( count($EnabledSalons) == 0 )
	$EnabledSalons[] ='-1';
	
	
//Установка фильтра
$arrFilterGirls["PROPERTY_CITY"] = $arCity["ID"];

$arrFilterGirls["PROPERTY_SALON"] = $EnabledSalons;
$arrFilterGirls["ACTIVE"] = 'Y';
$arrFilterGirls["IBLOCK_ID"] = 3;

//Фильтр по девушкам из избранного
$arrFilterGirls["ID"] = Favorites::getGirls();

?>
<?$APPLICATION->IncludeComponent("bitrix:news.list", "girls", array(
	"IBLOCK_TYPE" => "content",
	"IBLOCK_ID" => "3",
	"NEWS_COUNT" => "12",
	//"SORT_BY1" => "SORT",
	//"SORT_ORDER1" => "DESC",
	"SORT_BY1" => "PROPERTY_PRIORITY",
	"SORT_ORDER1" => "DESC",
	"SORT_BY2" => "PROPERTY_SORT",
	"SORT_ORDER2" => "DESC",
	"SORT_BY3" => "PROPERTY_SUMM",
	"SORT_ORDER3" => "DESC",
	"FILTER_NAME" => "arrFilterGirls",
	"FIELD_CODE" => array(
		0 => "NAME",
		1 => "PREVIEW_PICTURE",
		2 => "",
	),
	"PROPERTY_CODE" => array(
		0 => "SALON",
		1 => "CHECK_FLAG",
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
	"DISPLAY_TOP_PAGER" => "Y",
	"DISPLAY_BOTTOM_PAGER" => "Y",
	"PAGER_TITLE" => "„евушки",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_TEMPLATE" => "girls",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "N",
	"AJAX_OPTION_ADDITIONAL" => "",
	"PAGE_CURRENT_NAME" => "favorites"
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>