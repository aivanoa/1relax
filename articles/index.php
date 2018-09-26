<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	if($_GET['PAGEN_1'] > 1) {
		$pageTitle = ' - Страница ' . $_GET['PAGEN_1'];
		$pageForH1 = ', страница ' . $_GET['PAGEN_1'];
		$pageDesc = '. Страница ' . $_GET['PAGEN_1'];
	}
	else {
		$pageTitle = '';
		$pageForH1 = '';
		$pageDesc = '';
	}

	$APPLICATION->SetPageProperty('title', 'Статьи и другая информация о эротическом массаже в г. '.$GLOBALS['arCity']['NAME'].' – 1RELAX' . $pageTitle);
	$APPLICATION->SetPageProperty('description', 'Полезная информация и статьи на сайте 1RELAX ('.$GLOBALS["arCity"]["NAME"].'). Рекомендации и особенности техник массажа' . $pageDesc . '.');


?>
<?$arrFilterArticles["PROPERTY_CITY"] = $GLOBALS["arCity"]["ID"]?>
<?$APPLICATION->IncludeComponent("bitrix:news", "articles", array(
	"IBLOCK_TYPE" => "content",
	"IBLOCK_ID" => "7",
	"NEWS_COUNT" => "20",
	"USE_SEARCH" => "N",
	"USE_RSS" => "N",
	"USE_RATING" => "N",
	"USE_CATEGORIES" => "N",
	"USE_FILTER" => "Y",
	"FILTER_NAME" => "arrFilterArticles",
	"FILTER_FIELD_CODE" => array(
		0 => "",
		1 => "",
	),
	"FILTER_PROPERTY_CODE" => array(
		0 => "",
		1 => "",
	),
	"SORT_BY1" => "SORT",
	"SORT_ORDER1" => "ASC",
	"SORT_BY2" => "SORT",
	"SORT_ORDER2" => "ASC",
	"CHECK_DATES" => "Y",
	"SEF_MODE" => "Y",
	"SEF_FOLDER" => "/articles/",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "N",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_FILTER" => "N",
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
		2 => "",
	),
	"LIST_PROPERTY_CODE" => array(
		0 => "",
		1 => "",
	),
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",
	"DISPLAY_NAME" => "N",
	"META_KEYWORDS" => "-",
	"META_DESCRIPTION" => "-",
	"BROWSER_TITLE" => "-",
	"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
	"DETAIL_FIELD_CODE" => array(
		0 => "NAME",
		1 => "DETAIL_TEXT",
		2 => "DATE_CREATE",
		3 => "",
	),
	"DETAIL_PROPERTY_CODE" => array(
		0 => "",
		1 => "",
	),
	"DETAIL_DISPLAY_TOP_PAGER" => "N",
	"DETAIL_DISPLAY_BOTTOM_PAGER" => "N",
	"DETAIL_PAGER_TITLE" => "",
	"DETAIL_PAGER_TEMPLATE" => "",
	"DETAIL_PAGER_SHOW_ALL" => "N",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "Y",
	"PAGER_TITLE" => "Статьи",
	"PAGER_SHOW_ALWAYS" => "Y",
	"PAGER_TEMPLATE" => "girls",
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