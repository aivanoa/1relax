<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("—алон");
?>

<?ob_start();?>

<?
// $GLOBALS["arSalon"]["ID"] = 156278;
$APPLICATION->IncludeComponent("architect:news.detail", "salon_auth", array(
	"IBLOCK_TYPE" => "content",
	"IBLOCK_ID" => "1",
	"ELEMENT_ID" => $GLOBALS["arSalon"]["ID"],
	"ELEMENT_CODE" => "",
	"CHECK_DATES" => "N",
	"FIELD_CODE" => array(
		0 => "NAME",
		1 => "PREVIEW_TEXT",
		2 => "PREVIEW_PICTURE",
		3 => "DETAIL_TEXT",
		4 => "",
	),
	"PROPERTY_CODE" => array(
		0 => "ADRESS",
		1 => "COORDS",
		2 => "PHONE",
		3 => "PRICE",
		4 => "EMAIL",
		5 => "WWW",
		6 => "USER",
		7 => "TIME",
		8 => "CITY",
		9 => "PHOTOS",
		10 => "SUMM",
		11 => "CLICK",
		12 => "SORT",
        13 => "ACTIVE_ADMINISTRATOR"
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
//ѕытаемс€ найти кусок кода, который нужно поместить в EXTRA
$extra_start = strpos($componentOut, '<EXTRA>');
$extra_stop = strpos($componentOut, '</EXTRA>');

if ( $extra_start !== false && $extra_stop  !== false ){
	$extra_str = substr($componentOut, $extra_start, $extra_stop );
	
	$componentOut = str_replace($extra_str, "", $componentOut);
	$extra_str = str_replace("<EXTRA>", "", $extra_str);
	$extra_str = str_replace("</EXTRA>", "", $extra_str);
	$APPLICATION->SetPageProperty("EXTRA", $extra_str);	
}

//ѕытаемс€ найти кусок кода, который нужно поместить в RIGHT

$right_start = strpos($componentOut, '<RIGHT>');
$right_stop = strpos($componentOut, '</RIGHT>');

if ( $right_start !== false && $right_stop  !== false ){
	$right_str = substr($componentOut, $right_start, $right_stop );
	
	$componentOut = str_replace($right_str, "", $componentOut);
	$right_str = str_replace("<RIGHT>", "", $right_str);
	$right_str = str_replace("</RIGHT>", "", $right_str);
	$APPLICATION->SetPageProperty("RIGHT", $right_str);	
}

//ѕытаемс€ найти кусок кода, который нужно поместить в TITLE


preg_match("/<TITLE>(.*)<\/TITLE>/", $componentOut, $regs);
$componentOut = str_replace($regs[0], "", $componentOut);
$APPLICATION->SetTitle($regs[1]);
print $componentOut;
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>