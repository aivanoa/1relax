<?global $arrFilterBanners?>
<?
$arrFilterBanners["PROPERTY_CITY"] = $GLOBALS["arCity"]["ID"];
$arrFilterBanners["SECTION_ID"] = 3;
?>
<?

$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"banners_right", 
	array(
	"IBLOCK_TYPE" => "content",
	"IBLOCK_ID" => "5",
	"NEWS_COUNT" => "5",
	"SORT_BY1" => "RAND",
	"SORT_ORDER1" => "DESC",
	"SORT_BY2" => "SORT",
	"SORT_ORDER2" => "DESC",
	"FILTER_NAME" => "arrFilterBanners",
	"FIELD_CODE" => array(
		0 => "NAME",
		1 => "",
	),
	"PROPERTY_CODE" => array(
		0 => "LINK",
		1 => "FILE",
		2 => "",
	),
	"CHECK_DATES" => "Y",
	"DETAIL_URL" => "",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "N",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "N",
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
	"PARENT_SECTION" => "3",
	"PARENT_SECTION_CODE" => "",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "N",
	"PAGER_TITLE" => "",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_TEMPLATE" => "",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "N",
	"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);


?>

