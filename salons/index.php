<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$page_ = 0;
if($_GET)
	foreach($_GET as $key => $val)
		if(strpos($key, "PAGEN") !== false){
			$page_= (int)$val;
			break;
		}
define("CURRENT_PAGE", $page_);
$cur_page = (CURRENT_PAGE) ? " - �������� ".CURRENT_PAGE : "";
$cur_page2 = (CURRENT_PAGE) ? " �������� ".CURRENT_PAGE."." : "";
$APPLICATION->SetTitle("������ ������������ ������� �� ����� �. {$GLOBALS["arCity"]["NAME"]}. ������ ������� ������� � ���� - 1RELAX{$cur_page}");
$APPLICATION->SetPageProperty("description", "������� ����� ���-������� � �. {$GLOBALS["arCity"]["NAME"]} �� ����� 1RELAX. ������ ������������ ������� �� ����� ������ {$GLOBALS["arCity"]["NAME"]}. � ��� �� ����� ���� ������� � ���������� ����.{$cur_page2}");
?>


<?if(isset($_REQUEST["strIMessage"])):?>
	<p class="notetext"><?=$_REQUEST["strIMessage"]?></p>
<?endif;?>

<?
//��������� �������
global $arrFilterSalons;
$arrFilterSalons["PROPERTY_CITY"] = $GLOBALS["arCity"]["ID"];
$arrFilterSalons["PROPERTY_ACTIVE_ADMINISTRATOR"] = false;
//$arrFilterSalons[">PROPERTY_SORT"] = MIN_SORT;

if (   $GLOBALS["arCity"]['PROPERTY_SALONS_TITLE_VALUE'] != '' ){
	$APPLICATION->SetPageProperty("title", $GLOBALS["arCity"]['PROPERTY_SALONS_TITLE_VALUE'].$cur_page );	
}

if (   $GLOBALS["arCity"]['PROPERTY_SALONS_DESC_VALUE'] != '' ){
	$APPLICATION->SetPageProperty("description", $GLOBALS["arCity"]['PROPERTY_SALONS_DESC_VALUE'].$cur_page2);	
}

if (   $GLOBALS["arCity"]['PROPERTY_SALONS_KEYWORDS_VALUE'] != '' ){
	$APPLICATION->SetPageProperty("keywords", $GLOBALS["arCity"]['PROPERTY_SALONS_KEYWORDS_VALUE']);	
}


if( $_GET['PAGEN_1'] ) $catlink = '/salons/';
breadcrumbs(array(
	array(
		'title' => '������'
	),
), $catlink);


?>

<?$APPLICATION->IncludeComponent("bitrix:news.list", "salons", array(
	"MANUAL_MAP" => true,
	"IBLOCK_TYPE" => "content",
	"IBLOCK_ID" => "1",
	"NEWS_COUNT" => "50",
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
	"DISPLAY_TOP_PAGER" => "Y",
	"DISPLAY_BOTTOM_PAGER" => "Y",
	"PAGER_TITLE" => "������",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_TEMPLATE" => "salons",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "N",
	"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>