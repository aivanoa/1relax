<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Изменение программы");
?>
<?$APPLICATION->IncludeComponent("architect:iblock.element.add.form", "programms", array(
	"IBLOCK_TYPE" => "content",
	"IBLOCK_ID" => "12",
	"STATUS_NEW" => "NEW",
	"LIST_URL" => "/personal/salon/?type=programms",
	"USE_CAPTCHA" => "N",
	"USER_MESSAGE_EDIT" => "Спасибо. Программа сохранена.",
	"USER_MESSAGE_ADD" => "Спасибо. Программа добавлена и начнёт отображаться на сайте сразу после проверки модератором",
	"DEFAULT_INPUT_SIZE" => "60",
	"RESIZE_IMAGES" => "N",
	"PROPERTY_CODES" => array(
		0 => "NAME",
		1 => "PREVIEW_TEXT",
		2 => "67",
		3 => "68",
        4 => "69",
        5 => "70",
        6 => "71"
	),
	"PROPERTY_CODES_REQUIRED" => array(
		0 => "NAME",
		1 => "PREVIEW_TEXT",
	),
	"GROUPS" => array(
		0 => "5",
	),
	"STATUS" => "ANY",
	"ELEMENT_ASSOC" => "PROPERTY_ID",
	"ELEMENT_ASSOC_PROPERTY" => "40",
	"MAX_USER_ENTRIES" => "10000",
	"MAX_LEVELS" => "1",
	"LEVEL_LAST" => "N",
	"MAX_FILE_SIZE" => "0",
	"PREVIEW_TEXT_USE_HTML_EDITOR" => "N",
	"DETAIL_TEXT_USE_HTML_EDITOR" => "N",
	"SEF_MODE" => "N",
	"SEF_FOLDER" => "/salons/",
	"CUSTOM_TITLE_NAME" => "Заголовок программы",
	"CUSTOM_TITLE_TAGS" => "",
	"CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",
	"CUSTOM_TITLE_DATE_ACTIVE_TO" => "",
	"CUSTOM_TITLE_IBLOCK_SECTION" => "",
	"CUSTOM_TITLE_PREVIEW_TEXT" => "Текст программы",
	"CUSTOM_TITLE_PREVIEW_PICTURE" => "",
	"CUSTOM_TITLE_DETAIL_TEXT" => "",
	"CUSTOM_TITLE_DETAIL_PICTURE" => ""
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>