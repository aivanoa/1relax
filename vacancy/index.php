<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("��������");
$APPLICATION->SetPageProperty("robots", "noindex,nofollow");
?>
<?
	// global $arrFilterNews;
	// $arrFilterNews[0] = array(
	// 	"LOGIC" => "OR",
	// 	array("PROPERTY_CITY" => $GLOBALS["arCity"]["ID"]),
	// 	array("PROPERTY_CITY" => false),
	// );


	
if (   $GLOBALS["arCity"]['PROPERTY_VACANCY_TITLE_VALUE'] != '' ){
	$APPLICATION->SetPageProperty("title", $GLOBALS["arCity"]['PROPERTY_VACANCY_TITLE_VALUE']);	
}

if (   $GLOBALS["arCity"]['PROPERTY_VACANCY_DESC_VALUE'] != '' ){
	$APPLICATION->SetPageProperty("description", $GLOBALS["arCity"]['PROPERTY_VACANCY_DESC_VALUE']);	
}

if (   $GLOBALS["arCity"]['PROPERTY_VACANCY_KEYWORDS_VALUE'] != '' ){
	$APPLICATION->SetPageProperty("keywords", $GLOBALS["arCity"]['PROPERTY_VACANCY_KEYWORDS_VALUE']);	
}	
	
if( $_GET['PAGEN_1'] ) $catlink = '/vacancy/';
breadcrumbs(array(
	array(
		'title' => '��������'
	),
), $catlink);


$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_*"); //IBLOCK_ID � ID ����������� ������ ���� �������, ��. �������� arSelectFields ����
$arFilter = Array(
	"IBLOCK_ID" => IntVal(1), 
	"ACTIVE" => "Y",
	"PROPERTY_CITY" => $GLOBALS["arCity"]["ID"],
	">PROPERTY_SUMM"=> 0,
	"!=PROPERTY_ACTIVE_ADMINISTRATOR" => "Y",
	"PROPERTY_REKLAMA_OFF" => false
);

$res = CIBlockElement::GetList(Array(), $arFilter, false,false, $arSelect);
while ($ob = $res->GetNextElement()) {
    $arFields = $ob->GetFields();
	
	if ( $arFields['PROPERTY_ACTIVE_ADMINISTRATOR_VALUE'] == 'Y' )
		continue;
	
    if ( $arFields['PROPERTY_57']*1 < $arFields['PROPERTY_58']*1 ) continue;
    $id[] = $arFields["ID"];
}




if(count($id)>0){

    $arrFilterNews = array("PROPERTY_SALON"=>$id);

    $APPLICATION->IncludeComponent("bitrix:news", "vacancy", Array(
	"IBLOCK_TYPE" => "content",	// ��� ���������
	"IBLOCK_ID" => "11",	// ��������
	"NEWS_COUNT" => "50",	// ���������� �������� �� ��������
	"USE_SEARCH" => "N",	// ��������� �����
	"USE_RSS" => "N",	// ��������� RSS
	"USE_RATING" => "N",	// ��������� �����������
	"USE_CATEGORIES" => "N",	// �������� ��������� �� ����
	"USE_FILTER" => "Y",	// ���������� ������
	"FILTER_NAME" => "arrFilterNews",	// ������
	"FILTER_FIELD_CODE" => array(	// ����
		0 => "",
		1 => "",
	),
	"FILTER_PROPERTY_CODE" => array(	// ��������
		0 => "",
		1 => "",
	),
	"SORT_BY1" => "DATE_CREATE",	// ���� ��� ������ ���������� ��������
	"SORT_ORDER1" => "DESC",	// ����������� ��� ������ ���������� ��������
	"SORT_BY2" => "SORT",	// ���� ��� ������ ���������� ��������
	"SORT_ORDER2" => "ASC",	// ����������� ��� ������ ���������� ��������
	"CHECK_DATES" => "Y",	// ���������� ������ �������� �� ������ ������ ��������
	"SEF_MODE" => "Y",	// �������� ��������� ���
	"SEF_FOLDER" => "/vacancy/",	// ������� ��� (������������ ����� �����)
	"AJAX_MODE" => "N",	// �������� ����� AJAX
	"AJAX_OPTION_JUMP" => "N",	// �������� ��������� � ������ ����������
	"AJAX_OPTION_STYLE" => "N",	// �������� ��������� ������
	"AJAX_OPTION_HISTORY" => "N",	// �������� �������� ��������� ��������
	"CACHE_TYPE" => "A",	// ��� �����������
	"CACHE_TIME" => "36000000",	// ����� ����������� (���.)
	"CACHE_FILTER" => "Y",	// ���������� ��� ������������� �������
	"CACHE_GROUPS" => "N",	// ��������� ����� �������
	"SET_TITLE" => "N",	// ������������� ��������� ��������
	"SET_STATUS_404" => "N",	// ������������� ������ 404, ���� �� ������� ������� ��� ������
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// �������� �������� � ������� ���������
	"ADD_SECTIONS_CHAIN" => "N",	// �������� ������ � ������� ���������
	"USE_PERMISSIONS" => "N",	// ������������ �������������� ����������� �������
	"PREVIEW_TRUNCATE_LEN" => "",	// ������������ ����� ������ ��� ������ (������ ��� ���� �����)
	"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",	// ������ ������ ����
	"LIST_FIELD_CODE" => array(	// ����
		0 => "NAME",
		1 => "PREVIEW_TEXT",
		2 => "DATE_CREATE",
		3 => "",
	),
	"LIST_PROPERTY_CODE" => array(	// ��������
		0 => "SALON",
		1 => "",
	),
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// �������� ������, ���� ��� ���������� ��������
	"DISPLAY_NAME" => "N",	// �������� �������� ��������
	"META_KEYWORDS" => "-",	// ���������� �������� ����� �������� �� ��������
	"META_DESCRIPTION" => "-",	// ���������� �������� �������� �� ��������
	"BROWSER_TITLE" => "-",	// ���������� ��������� ���� �������� �� ��������
	"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",	// ������ ������ ����
	"DETAIL_FIELD_CODE" => array(	// ����
		0 => "NAME",
		1 => "PREVIEW_TEXT",
		2 => "DATE_CREATE",
		3 => "",
	),
	"DETAIL_PROPERTY_CODE" => array(	// ��������
		0 => "SALON",
		1 => "",
	),
	"DETAIL_DISPLAY_TOP_PAGER" => "N",	// �������� ��� �������
	"DETAIL_DISPLAY_BOTTOM_PAGER" => "N",	// �������� ��� �������
	"DETAIL_PAGER_TITLE" => "",	// �������� ���������
	"DETAIL_PAGER_TEMPLATE" => "",	// �������� �������
	"DETAIL_PAGER_SHOW_ALL" => "N",	// ���������� ������ "���"
	"DISPLAY_TOP_PAGER" => "Y",	// �������� ��� �������
	"DISPLAY_BOTTOM_PAGER" => "Y",	// �������� ��� �������
	"PAGER_TITLE" => "��������",	// �������� ���������
	"PAGER_SHOW_ALWAYS" => "N",	// �������� ������
	"PAGER_TEMPLATE" => "vacancy",	// �������� �������
	"PAGER_DESC_NUMBERING" => "N",	// ������������ �������� ���������
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// ����� ����������� ������� ��� �������� ���������
	"PAGER_SHOW_ALL" => "N",	// ���������� ������ "���"
	"AJAX_OPTION_ADDITIONAL" => "",	// �������������� �������������
	"SEF_URL_TEMPLATES" => array(
		"news" => "",
		"section" => "",
		"detail" => "#ELEMENT_ID#/",
	)
	),
	false
);

} else {


?>

<p class="warning">
���� �� ��������� �� ����� <?=$arResult["NAME"]?>.
</p>

<?php } ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>