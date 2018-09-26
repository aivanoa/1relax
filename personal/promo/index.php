<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Салон");
?>
<?ob_start();?>

<?$APPLICATION->IncludeComponent("architect:news.detail", "promo_auth", Array(
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
//ѕытаемс¤ найти кусок кода, который нужно поместить в EXTRA
$extra_start = strpos($componentOut, '<EXTRA>');
$extra_stop = strpos($componentOut, '</EXTRA>');

if ( $extra_start !== false && $extra_stop  !== false ){
	$extra_str = substr($componentOut, $extra_start, $extra_stop );
	
	$componentOut = str_replace($extra_str, "", $componentOut);
	$extra_str = str_replace("<EXTRA>", "", $extra_str);
	$extra_str = str_replace("</EXTRA>", "", $extra_str);
	$APPLICATION->SetPageProperty("EXTRA", $extra_str);	
}

//ѕытаемс¤ найти кусок кода, который нужно поместить в RIGHT

$right_start = strpos($componentOut, '<RIGHT>');
$right_stop = strpos($componentOut, '</RIGHT>');

if ( $right_start !== false && $right_stop  !== false ){
	$right_str = substr($componentOut, $right_start, $right_stop );
	
	$componentOut = str_replace($right_str, "", $componentOut);
	$right_str = str_replace("<RIGHT>", "", $right_str);
	$right_str = str_replace("</RIGHT>", "", $right_str);
	$APPLICATION->SetPageProperty("RIGHT", $right_str);	
}

//ѕытаемс¤ найти кусок кода, который нужно поместить в TITLE


preg_match("/<TITLE>(.*)<\/TITLE>/", $componentOut, $regs);
$componentOut = str_replace($regs[0], "", $componentOut);
$APPLICATION->SetTitle($regs[1]);
print $componentOut;
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>