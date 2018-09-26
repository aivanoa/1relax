<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вакансии");
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
		'title' => 'Вакансии'
	),
), $catlink);


$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_*"); //IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
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
	"IBLOCK_TYPE" => "content",	// Тип инфоблока
	"IBLOCK_ID" => "11",	// Инфоблок
	"NEWS_COUNT" => "50",	// Количество новостей на странице
	"USE_SEARCH" => "N",	// Разрешить поиск
	"USE_RSS" => "N",	// Разрешить RSS
	"USE_RATING" => "N",	// Разрешить голосование
	"USE_CATEGORIES" => "N",	// Выводить материалы по теме
	"USE_FILTER" => "Y",	// Показывать фильтр
	"FILTER_NAME" => "arrFilterNews",	// Фильтр
	"FILTER_FIELD_CODE" => array(	// Поля
		0 => "",
		1 => "",
	),
	"FILTER_PROPERTY_CODE" => array(	// Свойства
		0 => "",
		1 => "",
	),
	"SORT_BY1" => "DATE_CREATE",	// Поле для первой сортировки новостей
	"SORT_ORDER1" => "DESC",	// Направление для первой сортировки новостей
	"SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
	"SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
	"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
	"SEF_MODE" => "Y",	// Включить поддержку ЧПУ
	"SEF_FOLDER" => "/vacancy/",	// Каталог ЧПУ (относительно корня сайта)
	"AJAX_MODE" => "N",	// Включить режим AJAX
	"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
	"AJAX_OPTION_STYLE" => "N",	// Включить подгрузку стилей
	"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
	"CACHE_TYPE" => "A",	// Тип кеширования
	"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
	"CACHE_FILTER" => "Y",	// Кешировать при установленном фильтре
	"CACHE_GROUPS" => "N",	// Учитывать права доступа
	"SET_TITLE" => "N",	// Устанавливать заголовок страницы
	"SET_STATUS_404" => "N",	// Устанавливать статус 404, если не найдены элемент или раздел
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
	"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
	"USE_PERMISSIONS" => "N",	// Использовать дополнительное ограничение доступа
	"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
	"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
	"LIST_FIELD_CODE" => array(	// Поля
		0 => "NAME",
		1 => "PREVIEW_TEXT",
		2 => "DATE_CREATE",
		3 => "",
	),
	"LIST_PROPERTY_CODE" => array(	// Свойства
		0 => "SALON",
		1 => "",
	),
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
	"DISPLAY_NAME" => "N",	// Выводить название элемента
	"META_KEYWORDS" => "-",	// Установить ключевые слова страницы из свойства
	"META_DESCRIPTION" => "-",	// Установить описание страницы из свойства
	"BROWSER_TITLE" => "-",	// Установить заголовок окна браузера из свойства
	"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
	"DETAIL_FIELD_CODE" => array(	// Поля
		0 => "NAME",
		1 => "PREVIEW_TEXT",
		2 => "DATE_CREATE",
		3 => "",
	),
	"DETAIL_PROPERTY_CODE" => array(	// Свойства
		0 => "SALON",
		1 => "",
	),
	"DETAIL_DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
	"DETAIL_DISPLAY_BOTTOM_PAGER" => "N",	// Выводить под списком
	"DETAIL_PAGER_TITLE" => "",	// Название категорий
	"DETAIL_PAGER_TEMPLATE" => "",	// Название шаблона
	"DETAIL_PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
	"DISPLAY_TOP_PAGER" => "Y",	// Выводить над списком
	"DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
	"PAGER_TITLE" => "Вакансии",	// Название категорий
	"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
	"PAGER_TEMPLATE" => "vacancy",	// Название шаблона
	"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
	"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
	"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
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
Пока не добавлено ни одной <?=$arResult["NAME"]?>.
</p>

<?php } ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>