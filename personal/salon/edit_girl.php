<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Редактирование информации о девушке");
?>
<?$APPLICATION->IncludeComponent("architect:iblock.element.add.form", "girl", array(
	"IBLOCK_TYPE" => "content",
	"IBLOCK_ID" => "3",
	"STATUS_NEW" => "NEW",
	"LIST_URL" => "/personal/salon/?tab=girls",
	"USE_CAPTCHA" => "Y",
	"USER_MESSAGE_EDIT" => "Спасибо. Информация о девушке сохранена.",
	"USER_MESSAGE_ADD" => "Спасибо. Девушка добавлена и начнёт отображаться на сайте сразу после проверки модератором",
	"DEFAULT_INPUT_SIZE" => "60",
	"RESIZE_IMAGES" => "N",
	"PROPERTY_CODES" => array(
		0 => "NAME",
		1 => "PREVIEW_TEXT",
		2 => "PREVIEW_PICTURE",
		3 => "19",
		4 => "16",
		5 => "14",
		6 => "20",
		7 => "21",
		8 => "23",
		9 => "13",
		10 => "24",
		11 => "15",
		12 => "18",
		13 => "22",
		14 => "17",
	),
	"PROPERTY_CODES_REQUIRED" => array(
		0 => "NAME",
		1 => "PREVIEW_PICTURE",
	),
	"GROUPS" => array(
		0 => "5",
	),
	"STATUS" => "ANY",
	"ELEMENT_ASSOC" => "PROPERTY_ID",
	"ELEMENT_ASSOC_PROPERTY" => "24",
	"MAX_USER_ENTRIES" => "10000",
	"MAX_LEVELS" => "1",
	"LEVEL_LAST" => "N",
	"MAX_FILE_SIZE" => "0",
	"PREVIEW_TEXT_USE_HTML_EDITOR" => "N",
	"DETAIL_TEXT_USE_HTML_EDITOR" => "N",
	"SEF_MODE" => "N",
	"SEF_FOLDER" => "/salons/",
	"CUSTOM_TITLE_NAME" => "Имя девушки",
	"CUSTOM_TITLE_TAGS" => "",
	"CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",
	"CUSTOM_TITLE_DATE_ACTIVE_TO" => "",
	"CUSTOM_TITLE_IBLOCK_SECTION" => "",
	"CUSTOM_TITLE_PREVIEW_TEXT" => "Несколько слов о девушке и услугах",
	"CUSTOM_TITLE_PREVIEW_PICTURE" => "Основное фото",
	"CUSTOM_TITLE_DETAIL_TEXT" => "",
	"CUSTOM_TITLE_DETAIL_PICTURE" => ""
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>