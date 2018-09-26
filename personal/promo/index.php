<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("�����");
?>
<?ob_start();?>

<?$APPLICATION->IncludeComponent("architect:news.detail", "promo_auth", Array(
	"IBLOCK_TYPE" => "content",	// ��� ��������������� ����� (������������ ������ ��� ��������)
	"IBLOCK_ID" => "1",	// ��� ��������������� �����
	"ELEMENT_ID" => $GLOBALS["arSalon"]["ID"],	// ID �������
	"ELEMENT_CODE" => "",	// ��� �������
	"CHECK_DATES" => "N",	// ���������� ������ �������� �� ������ ������ ��������
	"FIELD_CODE" => array(	// ����
		0 => "NAME",
		1 => "PREVIEW_TEXT",
		2 => "PREVIEW_PICTURE",
		3 => "DETAIL_TEXT",
		4 => "",
	),
	"PROPERTY_CODE" => array(	// ��������
		"ADRESS",
		"COORDS",
		"PHONE",
		"PRICE",
		"EMAIL",
		"WWW",
		"USER",
		"TIME",
		"CITY",
		"PHOTOS",
		"SUMM",
		"CLICK",
		"SORT",
		"U_NO_MONEY",
		"U_MONEY_80",
		"U_POSITION_DOWN",
	),
	"IBLOCK_URL" => "",	// URL �������� ��������� ������ ��������� (�� ��������� - �� �������� ���������)
	"AJAX_MODE" => "N",	// �������� ����� AJAX
	"AJAX_OPTION_JUMP" => "N",	// �������� ��������� � ������ ����������
	"AJAX_OPTION_STYLE" => "N",	// �������� ��������� ������
	"AJAX_OPTION_HISTORY" => "N",	// �������� �������� ��������� ��������
	"CACHE_TYPE" => "A",	// ��� �����������
	"CACHE_TIME" => "36000000",	// ����� ����������� (���.)
	"CACHE_GROUPS" => "N",	// ��������� ����� �������
	"META_KEYWORDS" => "-",	// ���������� �������� ����� �������� �� ��������
	"META_DESCRIPTION" => "-",	// ���������� �������� �������� �� ��������
	"BROWSER_TITLE" => "-",	// ���������� ��������� ���� �������� �� ��������
	"SET_TITLE" => "N",	// ������������� ��������� ��������
	"SET_STATUS_404" => "N",	// ������������� ������ 404, ���� �� ������� ������� ��� ������
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// �������� �������� � ������� ���������
	"ADD_SECTIONS_CHAIN" => "N",	// �������� ������ � ������� ���������
	"ACTIVE_DATE_FORMAT" => "d.m.Y",	// ������ ������ ����
	"USE_PERMISSIONS" => "N",	// ������������ �������������� ����������� �������
	"DISPLAY_TOP_PAGER" => "N",	// �������� ��� �������
	"DISPLAY_BOTTOM_PAGER" => "N",	// �������� ��� �������
	"PAGER_TITLE" => "",	// �������� ���������
	"PAGER_TEMPLATE" => "",	// �������� �������
	"PAGER_SHOW_ALL" => "N",	// ���������� ������ "���"
	"AJAX_OPTION_ADDITIONAL" => "",	// �������������� �������������
	),
	false
);?> 
<?
$componentOut = ob_get_clean();
//������� ����� ����� ����, ������� ����� ��������� � EXTRA
$extra_start = strpos($componentOut, '<EXTRA>');
$extra_stop = strpos($componentOut, '</EXTRA>');

if ( $extra_start !== false && $extra_stop  !== false ){
	$extra_str = substr($componentOut, $extra_start, $extra_stop );
	
	$componentOut = str_replace($extra_str, "", $componentOut);
	$extra_str = str_replace("<EXTRA>", "", $extra_str);
	$extra_str = str_replace("</EXTRA>", "", $extra_str);
	$APPLICATION->SetPageProperty("EXTRA", $extra_str);	
}

//������� ����� ����� ����, ������� ����� ��������� � RIGHT

$right_start = strpos($componentOut, '<RIGHT>');
$right_stop = strpos($componentOut, '</RIGHT>');

if ( $right_start !== false && $right_stop  !== false ){
	$right_str = substr($componentOut, $right_start, $right_stop );
	
	$componentOut = str_replace($right_str, "", $componentOut);
	$right_str = str_replace("<RIGHT>", "", $right_str);
	$right_str = str_replace("</RIGHT>", "", $right_str);
	$APPLICATION->SetPageProperty("RIGHT", $right_str);	
}

//������� ����� ����� ����, ������� ����� ��������� � TITLE


preg_match("/<TITLE>(.*)<\/TITLE>/", $componentOut, $regs);
$componentOut = str_replace($regs[0], "", $componentOut);
$APPLICATION->SetTitle($regs[1]);
print $componentOut;
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>