<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Удаление программы");
?>


<?
$_REQUEST["programm"] = intVal($_REQUEST["programm"]);
if(!isset($_REQUEST["programm"]))
{
	//Делаем редирект в список новостей
	LocalRedirect("/personal/salon/?type=programms");
	exit();
}

//Данные салона
$salonId = $GLOBALS["arSalon"]["ID"];

if(CModule::IncludeModule("iblock") && $USER->IsAuthorized() && $salonId != 0)
{
	//Проверяем, есть ли новость, принадлежность, статус
	$arFilter = Array("IBLOCK_ID"=>"12", "ID"=>$_REQUEST["programm"], "PROPERTY_SALON"=>$salonId);
	$arSelect = Array("ID");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
	if($arFields = $res->GetNext())
	{
		//Удаляем новость
		CIBlockElement::Delete($_REQUEST["programm"]);
		//Делаем редирект в список новостей
		LocalRedirect('/personal/salon/?strIMessage='.urlencode("Программа удалена.").'&type=programms');
		exit();	  
	}
	else
	{
		//Делаем редирект в список новостей
		LocalRedirect("/personal/salon/?type=programms");
		exit();	    
	}
}
else 
{
	//Делаем редирект в список новостей
	LocalRedirect("/personal/salon/?type=programms");
	exit();
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>