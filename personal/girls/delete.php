<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("�������� �������");
?>


<?
$_REQUEST["girl"] = intVal($_REQUEST["girl"]);
if(!isset($_REQUEST["girl"]))
{
	//������ �������� � ������ �������
	LocalRedirect("/personal/salon/?type=girls");
	exit();
}

//������ ������
$salonId = $GLOBALS["arSalon"]["ID"];

if(CModule::IncludeModule("iblock") && $USER->IsAuthorized() && $salonId != 0)
{
	//���������, ���� �� �������, ��������������, ������
	$arFilter = Array("IBLOCK_ID"=>"3", "ID"=>$_REQUEST["girl"], "PROPERTY_SALON"=>$salonId);
	$arSelect = Array("ID");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
	if($arFields = $res->GetNext())
	{
		//������� �������
		CIBlockElement::Delete($_REQUEST["girl"]);
		//������ �������� � ������ �������
		LocalRedirect('/personal/salon/?strIMessage='.urlencode("������� �������.").'&type=girls');
		exit();	  
	}
	else
	{
		//������ �������� � ������ �������
		LocalRedirect("/personal/salon/?type=girls");
		exit();	    
	}
}
else 
{
	//������ �������� � ������ �������
	LocalRedirect("/personal/girls/");
	exit();
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>