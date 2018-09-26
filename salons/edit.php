<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Редактирование салона");
$APPLICATION->SetPageProperty("robots", "noindex,nofollow");
global $USER;

//Устанавливаем является ли поле Метро для салона обязательным, если салон находится в москве или питере, то поле обязательно для заполнения
$metro_station_required = false;
if(isset($_GET["CODE"]) && (int)($_GET["CODE"]) > 0)
{
	$arFilter = Array("IBLOCK_ID"=> 1, "ID"=> (int)($_GET["CODE"]));
	$res = CIBlockElement::GetList(array(), $arFilter, false, false, array("ID", "PROPERTY_CITY"));
	if($ob = $res->GetNextElement())
	{
		$fields = $ob->GetFields();
		if(isset($fields["PROPERTY_CITY_VALUE"]) && in_array($fields["PROPERTY_CITY_VALUE"], array(3, 10)))
			$metro_station_required = true;
		
	}
}
?><?

if ($USER->IsAuthorized()) {
    $prop = array(
    0 => "NAME",
   // 1 => "PREVIEW_TEXT",
    2=>'62',
    3 => "PREVIEW_PICTURE",

     6 => "5",
    7 => "6",
    8 => "8",
    9=>"85",
    10 => "38",
    11 => "39",
    12 => "7",
    13 => "3",
    14 => "9",

    16 => "1",
    17 => "12",
    18 => "75",
    19 => SALON_METRO_ID
);
} else {
    $prop = array(
    0 => "NAME",
   // 1 => "PREVIEW_TEXT",
    2=>'62',
    3 => "PREVIEW_PICTURE",

    6 => "5",
    7 => "6",
    8 => "8",
    9=>"85",
    10 => "38",
    11 => "39",
    12 => "7",
    13 => "3",
    14 => "9",

    16 => "1",
    17 => "12",
    18 => "75",
    19 => SALON_METRO_ID
);
}


if(isset($_REQUEST["CODE"]))
{
	$prop[0] = "DETAIL_TEXT";
	
    $prop = array_merge($prop,array(
       // 4 => "DETAIL_TEXT",
        5 => "2",

        14 => "10",
        15 => "4",
    ));
}
else
{

    foreach($prop as $key=>$val){

        if($val==9 || $val==75 || $val==62|| $val==85 )
            unset($prop[$key]);



    }


}

if ($USER->IsAuthorized()) {
    $required = array(
    0 => (isset($_REQUEST["CODE"]) ? "":"NAME"),
  //  1 => "PREVIEW_TEXT",
  //  2 => "PREVIEW_PICTURE",
    3 => "3",
    // 4 => "5",
    5 => "8",
    6 => "38",
    7 => "39",
    8 => "7",

);
if($metro_station_required) $required[] = SALON_METRO_ID;
} else {
    $required = array(
    0 => (isset($_REQUEST["CODE"]) ? "":"NAME"),
  //  1 => "PREVIEW_TEXT",
  //  2 => "PREVIEW_PICTURE",
    3 => "3",
    4 => "5",
    5 => "8",
    6 => "38",
    7 => "39",
    8 => "7",

);
if($metro_station_required) $required[] = SALON_METRO_ID;
}





$APPLICATION->IncludeComponent("architect:iblock.element.add.form", "salon", array(
        "IBLOCK_TYPE" => "content",
        "IBLOCK_ID" => "1",
        "STATUS_NEW" => "NEW",
        "LIST_URL" => (isset($_REQUEST["CODE"])) ? "/personal/salon/" : "/personal/",
        "USE_CAPTCHA" => "N",
        'USE_RECAPTCHA' => $USER->IsAuthorized() ? 'N' : 'Y',
        "USER_MESSAGE_EDIT" => "Спасибо. Информация о салоне сохранена.",
        /*"USER_MESSAGE_ADD" => "
        Спасибо. Салон добавлен в каталог и будет опубликован <s>после проверки модератором.</s>
        Вам необходимо <s>подтвердить указанный емайл</s>, чтобы получить возможность менять и добавлять информацию",
       */
        "DEFAULT_INPUT_SIZE" => "60",
        "RESIZE_IMAGES" => "N",
        "PROPERTY_CODES" => $prop,
        "PROPERTY_CODES_REQUIRED" => $required,
        "GROUPS" => array(
            0 => "2",
        ),
        "STATUS" => "ANY",
        "ELEMENT_ASSOC" => "PROPERTY_ID",
        "ELEMENT_ASSOC_PROPERTY" => "12",
        "MAX_USER_ENTRIES" => "10000",
        "MAX_LEVELS" => "1",
        "LEVEL_LAST" => "N",
        "MAX_FILE_SIZE" => "0",
        "PREVIEW_TEXT_USE_HTML_EDITOR" => "N",
        "DETAIL_TEXT_USE_HTML_EDITOR" => "N",
        "SEF_MODE" => "N",
        "SEF_FOLDER" => "/salons/",
        "CUSTOM_TITLE_NAME" => "Название салона",
        "CUSTOM_TITLE_TAGS" => "",
        "CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",
        "CUSTOM_TITLE_DATE_ACTIVE_TO" => "",
        "CUSTOM_TITLE_IBLOCK_SECTION" => "",
        "CUSTOM_TITLE_PREVIEW_TEXT" => "Краткое описание",
        "CUSTOM_TITLE_PREVIEW_PICTURE" => "Картинка или логотип БЕЗ ТЕЛЕФОННЫХ НОМЕРОВ, рекомендуемый размер 168x100",
        "CUSTOM_TITLE_DETAIL_TEXT" => "Подробное описание салона",
        "CUSTOM_TITLE_DETAIL_PICTURE" => "",
        "CUSTOM_TITLE_3"=>"E-mail (Будет использоваться в качестве логина)"
    ),
    false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>