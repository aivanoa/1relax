<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Салон");
?>
<?ob_start();?>
<?$APPLICATION->IncludeComponent("architect:news.detail", "promo_settings", Array(
	"IBLOCK_TYPE" => "content",	// Тип информационного блока (используется только для проверки)
	"IBLOCK_ID" => "1",	// Код информационного блока
	"ELEMENT_ID" => $GLOBALS["arSalon"]["ID"],	// ID новости
	"ELEMENT_CODE" => "",	// Код новости
	"CHECK_DATES" => "N",	// Показывать только активные на данный момент элементы
	"FIELD_CODE" => array(	// Поля
		0 => "NAME",
		1 => "PREVIEW_TEXT",
		2 => "PREVIEW_PICTURE",
		3 => "DETAIL_TEXT",
		4 => "",
	),
	"PROPERTY_CODE" => array(	// Свойства
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
	"IBLOCK_URL" => "",	// URL страницы просмотра списка элементов (по умолчанию - из настроек инфоблока)
	"AJAX_MODE" => "N",	// Включить режим AJAX
	"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
	"AJAX_OPTION_STYLE" => "N",	// Включить подгрузку стилей
	"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
	"CACHE_TYPE" => "A",	// Тип кеширования
	"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
	"CACHE_GROUPS" => "N",	// Учитывать права доступа
	"META_KEYWORDS" => "-",	// Установить ключевые слова страницы из свойства
	"META_DESCRIPTION" => "-",	// Установить описание страницы из свойства
	"BROWSER_TITLE" => "-",	// Установить заголовок окна браузера из свойства
	"SET_TITLE" => "N",	// Устанавливать заголовок страницы
	"SET_STATUS_404" => "N",	// Устанавливать статус 404, если не найдены элемент или раздел
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
	"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
	"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
	"USE_PERMISSIONS" => "N",	// Использовать дополнительное ограничение доступа
	"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
	"DISPLAY_BOTTOM_PAGER" => "N",	// Выводить под списком
	"PAGER_TITLE" => "",	// Название категорий
	"PAGER_TEMPLATE" => "",	// Название шаблона
	"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
	"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
	),
	false
);?> 
<?
$componentOut = ob_get_clean();
//Пытаемся найти кусок кода, который нужно поместить в EXTRA
eregi("<EXTRA>(.*)<\/EXTRA>", $componentOut, $regs);
$componentOut = str_replace($regs[0], "", $componentOut);
$APPLICATION->SetPageProperty("EXTRA", $regs[1]);
//Пытаемся найти кусок кода, который нужно поместить в RIGHT
eregi("<RIGHT>(.*)<\/RIGHT>", $componentOut, $regs);
$componentOut = str_replace($regs[0], "", $componentOut);
$APPLICATION->SetPageProperty("RIGHT", $regs[1]);
//Пытаемся найти кусок кода, который нужно поместить в TITLE
eregi("<TITLE>(.*)<\/TITLE>", $componentOut, $regs);
$componentOut = str_replace($regs[0], "", $componentOut);
$APPLICATION->SetTitle($regs[1]);
print $componentOut;
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>