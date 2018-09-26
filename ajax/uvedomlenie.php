<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); 



if(!$_REQUEST["value"] || !$_REQUEST["salon"]|| !$_REQUEST["name"])
	die();
	
global $USER;
CModule::IncludeModule("iblock");
$salonId = (int)$_REQUEST["salon"];


$salon = CIBlockElement::GetList(array(),array("ID"=>$salonId,"USER"=>$USER->GetID()),false,false,array("ID","IBLOCK_ID"))->Fetch();

if($salon["ID"])
{ 

	$arValue = array(
		"U_NO_MONEY"=>9,
		"U_MONEY_80"=>10,
		"U_POSITION_DOWN"=>11
	);
	
	if($_REQUEST["value"]!="true")
		$arValue[$_REQUEST["name"]] = false;
	
	
	CIBlockElement::SetPropertyValuesEx($salon["ID"], $salon["IBLOCK_ID"], array($_REQUEST["name"] =>$arValue[$_REQUEST["name"]]));
}

