<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Все салоны эротического массажа, эротический и тайский массаж");
$APPLICATION->SetPageProperty("keywords", "массаж, эротически массаж, тайский, салоны, интимный");
$APPLICATION->SetPageProperty("title", "Все салоны эротического массажа в вашем городе, эротический и тайский массаж");
$APPLICATION->SetTitle("Выберите город");
?><?$APPLICATION->IncludeComponent("bitrix:news.list", "citylist", array(
	"IBLOCK_TYPE" => "content",
	"IBLOCK_ID" => "2",
	"NEWS_COUNT" => "1000",
	"SORT_BY1" => "NAME",
	"SORT_ORDER1" => "ASC",
	"SORT_BY2" => "NAME",
	"SORT_ORDER2" => "ASC",
	"FILTER_NAME" => "",
	"FIELD_CODE" => array(
		0 => "",
		1 => "",
	),
	"PROPERTY_CODE" => array(
		0 => "",
		1 => "",
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
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>