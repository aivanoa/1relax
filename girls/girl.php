<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Подробно о девушке");
?>

<?ob_start();?>
<?$APPLICATION->IncludeComponent("architect:news.detail", "girl", array(
	"IBLOCK_TYPE" => "content",
	"IBLOCK_ID" => "3",
	"ELEMENT_ID" => "",
	"ELEMENT_CODE" => $_REQUEST["ELEMENT_CODE"],
	"CHECK_DATES" => "N",
	"FIELD_CODE" => array(
		0 => "NAME",
		1 => "PREVIEW_TEXT",
		2 => "PREVIEW_PICTURE",
		3 => "",
	),
	"PROPERTY_CODE" => array(
		0 => "AGE",
		1 => "SIZE",
		2 => "WEIGHT",
		3 => "THALIA",
		4 => "RISE",
		5 => "HIPS",
		6 => "HAIR",
		7 => "EYES",
		8 => "USER",
		9 => "SALON",
		10 => "PHOTOS",
	),
	"IBLOCK_URL" => "",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "N",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_GROUPS" => "N",
	"META_KEYWORDS" => "-",
	"META_DESCRIPTION" => "-",
	"BROWSER_TITLE" => "-",
	"SET_TITLE" => "N",
	"SET_STATUS_404" => "N",
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
	"ADD_SECTIONS_CHAIN" => "N",
	"ACTIVE_DATE_FORMAT" => "d.m.Y",
	"USE_PERMISSIONS" => "N",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "N",
	"PAGER_TITLE" => "",
	"PAGER_TEMPLATE" => "",
	"PAGER_SHOW_ALL" => "N",
	"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?> 
<?
$componentOut = ob_get_clean();
//Пытаемся найти кусок кода, который нужно поместить в EXTRA
eregi("<EXTRA>(.*)<\/EXTRA>", $componentOut, $regs);
$componentOut = str_replace($regs[0], "", $componentOut);
$APPLICATION->SetPageProperty("EXTRA", $regs[1]);
//Пытаемся найти кусок кода, который нужно поместить в TITLE
eregi("<TITLE>(.*)<\/TITLE>", $componentOut, $regs);
$componentOut = str_replace($regs[0], "", $componentOut);
$APPLICATION->SetTitle($regs[1]);
print $componentOut;
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>