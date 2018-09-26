<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Удаление девушки");
?>


<?
$_REQUEST["girl"] = intVal($_REQUEST["girl"]);
if(!isset($_REQUEST["girl"]))
{
	//Делаем редирект в список девушек
	LocalRedirect("/personal/salon/?type=girls");
	exit();
}

//Данные салона
$salonId = $GLOBALS["arSalon"]["ID"];

if(CModule::IncludeModule("iblock") && $USER->IsAuthorized() && $salonId != 0)
{
	//Проверяем, есть ли девушка, принадлежность, статус
	$arFilter = Array("IBLOCK_ID"=>"3", "ID"=>$_REQUEST["girl"], "PROPERTY_SALON"=>$salonId);
	$arSelect = Array("ID");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
	if($arFields = $res->GetNext())
	{
		//Удаляем девушку
		CIBlockElement::Delete($_REQUEST["girl"]);
		//Делаем редирект в список девушек
		LocalRedirect('/personal/salon/?strIMessage='.urlencode("Девушка удалена.").'&type=girls');
		exit();	  
	}
	else
	{
		//Делаем редирект в список девушек
		LocalRedirect("/personal/salon/?type=girls");
		exit();	    
	}
}
else 
{
	//Делаем редирект в список девушек
	LocalRedirect("/personal/girls/");
	exit();
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>