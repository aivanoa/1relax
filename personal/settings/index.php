<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("�����");
?>
<?ob_start();?>
<?$APPLICATION->IncludeComponent("architect:news.detail", "promo_settings", Array(
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
		13 => "U_NO_MONEY",
		14 => "U_MONEY_80",
		15 => "U_POSITION_DOWN",
	
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
//�������� ����� ����� ����, ������� ����� ��������� � EXTRA
eregi("<EXTRA>(.*)<\/EXTRA>", $componentOut, $regs);
$componentOut = str_replace($regs[0], "", $componentOut);
$APPLICATION->SetPageProperty("EXTRA", $regs[1]);
//�������� ����� ����� ����, ������� ����� ��������� � RIGHT
eregi("<RIGHT>(.*)<\/RIGHT>", $componentOut, $regs);
$componentOut = str_replace($regs[0], "", $componentOut);
$APPLICATION->SetPageProperty("RIGHT", $regs[1]);
//�������� ����� ����� ����, ������� ����� ��������� � TITLE
eregi("<TITLE>(.*)<\/TITLE>", $componentOut, $regs);
$componentOut = str_replace($regs[0], "", $componentOut);
$APPLICATION->SetTitle($regs[1]);
print $componentOut;
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>