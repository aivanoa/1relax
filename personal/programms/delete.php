<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("�������� ���������");
?>


<?
$_REQUEST["programm"] = intVal($_REQUEST["programm"]);
if(!isset($_REQUEST["programm"]))
{
	//������ �������� � ������ ��������
	LocalRedirect("/personal/salon/?type=programms");
	exit();
}

//������ ������
$salonId = $GLOBALS["arSalon"]["ID"];

if(CModule::IncludeModule("iblock") && $USER->IsAuthorized() && $salonId != 0)
{
	//���������, ���� �� �������, ��������������, ������
	$arFilter = Array("IBLOCK_ID"=>"12", "ID"=>$_REQUEST["programm"], "PROPERTY_SALON"=>$salonId);
	$arSelect = Array("ID");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
	if($arFields = $res->GetNext())
	{
		//������� �������
		CIBlockElement::Delete($_REQUEST["programm"]);
		//������ �������� � ������ ��������
		LocalRedirect('/personal/salon/?strIMessage='.urlencode("��������� �������.").'&type=programms');
		exit();	  
	}
	else
	{
		//������ �������� � ������ ��������
		LocalRedirect("/personal/salon/?type=programms");
		exit();	    
	}
}
else 
{
	//������ �������� � ������ ��������
	LocalRedirect("/personal/salon/?type=programms");
	exit();
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>