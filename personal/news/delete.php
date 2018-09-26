<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Удаление новости");
?>


<?
$_REQUEST["news"] = intVal($_REQUEST["news"]);
if(!isset($_REQUEST["news"]))
{
	//Делаем редирект в список новостей
	LocalRedirect("/personal/salon/?type=news");
	exit();
}

//Данные салона
$salonId = $GLOBALS["arSalon"]["ID"];

if(CModule::IncludeModule("iblock") && $USER->IsAuthorized() && $salonId != 0)
{
	//Проверяем, есть ли новость, принадлежность, статус
	$arFilter = Array("IBLOCK_ID"=>"6", "ID"=>$_REQUEST["news"], "PROPERTY_SALON"=>$salonId);
	$arSelect = Array("ID");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
	if($arFields = $res->GetNext())
	{
		//Удаляем новость
		CIBlockElement::Delete($_REQUEST["news"]);
		//Делаем редирект в список новостей
		LocalRedirect('/personal/salon/?strIMessage='.urlencode("Новость удалена.").'&type=news');
		exit();	  
	}
	else
	{
		//Делаем редирект в список новостей
		LocalRedirect("/personal/salon/?type=news");
		exit();	    
	}
}
else 
{
	//Делаем редирект в список новостей
	LocalRedirect("/personal/news/");
	exit();
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>