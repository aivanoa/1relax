<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Изменение девушки");
?><?$APPLICATION->IncludeComponent(
	"architect:iblock.element.add.form",
	"girl",
	Array(
		"CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",
		"CUSTOM_TITLE_DATE_ACTIVE_TO" => "",
		"CUSTOM_TITLE_DETAIL_PICTURE" => "",
		"CUSTOM_TITLE_DETAIL_TEXT" => "",
		"CUSTOM_TITLE_IBLOCK_SECTION" => "",
		"CUSTOM_TITLE_NAME" => "»м¤ девушки",
		"CUSTOM_TITLE_PREVIEW_PICTURE" => "Основное фото",
		"CUSTOM_TITLE_PREVIEW_TEXT" => "Несколько слов о девушке и услугах",
		"CUSTOM_TITLE_TAGS" => "",
		"DEFAULT_INPUT_SIZE" => "60",
		"DETAIL_TEXT_USE_HTML_EDITOR" => "N",
		"ELEMENT_ASSOC" => "PROPERTY_ID",
		"ELEMENT_ASSOC_PROPERTY" => "24",
		"GROUPS" => array("5"),
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "content",
		"LEVEL_LAST" => "N",
		"LIST_URL" => "/personal/salon/?type=girls",
		"MAX_FILE_SIZE" => "0",
		"MAX_LEVELS" => "1",
		"MAX_USER_ENTRIES" => "10000",
		"PREVIEW_TEXT_USE_HTML_EDITOR" => "N",
		"PROPERTY_CODES" => array("13","14","15","16","17","18","19","20","21","22","23","24","87","NAME","PREVIEW_TEXT","PREVIEW_PICTURE"),
		"PROPERTY_CODES_REQUIRED" => array("14","15","16","18","NAME","PREVIEW_PICTURE"),
		"RESIZE_IMAGES" => "N",
		"SEF_MODE" => "N",
		"STATUS" => "ANY",
		"STATUS_NEW" => "NEW",
		"USER_MESSAGE_ADD" => "Спасибо. девушка добавлена и начнет отображаться на сайте сразу после проверки модератором",
		"USER_MESSAGE_EDIT" => "Спасибо. Информация о девушке сохранена.",
		"USE_CAPTCHA" => "N"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>