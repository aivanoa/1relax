<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("�������� �������");
?>


<?
$_REQUEST["news"] = intVal($_REQUEST["news"]);
if(!isset($_REQUEST["news"]))
{
	//������ �������� � ������ ��������
	LocalRedirect("/personal/salon/?type=news");
	exit();
}

//������ ������
$salonId = $GLOBALS["arSalon"]["ID"];

if(CModule::IncludeModule("iblock") && $USER->IsAuthorized() && $salonId != 0)
{
	//���������, ���� �� �������, ��������������, ������
	$arFilter = Array("IBLOCK_ID"=>"6", "ID"=>$_REQUEST["news"], "PROPERTY_SALON"=>$salonId);
	$arSelect = Array("ID");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
	if($arFields = $res->GetNext())
	{
		//������� �������
		CIBlockElement::Delete($_REQUEST["news"]);
		//������ �������� � ������ ��������
		LocalRedirect('/personal/salon/?strIMessage='.urlencode("������� �������.").'&type=news');
		exit();	  
	}
	else
	{
		//������ �������� � ������ ��������
		LocalRedirect("/personal/salon/?type=news");
		exit();	    
	}
}
else 
{
	//������ �������� � ������ ��������
	LocalRedirect("/personal/news/");
	exit();
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>