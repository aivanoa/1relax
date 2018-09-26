<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");



if(!$_REQUEST["action"] || !$_REQUEST["salon"])
    die();

global $USER;
CModule::IncludeModule("iblock");
$salonId = (int)$_REQUEST["salon"];
$action = $_REQUEST["action"];

$salon = CIBlockElement::GetList(array(),array("ID"=>$salonId,"USER"=>$USER->GetID()),false,false,array("ID","IBLOCK_ID"))->Fetch();

if($salon["ID"])
{

    if($action=="off")
        $act = 12;
    else
        $act = false;
    CIBlockElement::SetPropertyValuesEx($salon["ID"], $salon["IBLOCK_ID"], array("ACTIVE_ADMINISTRATOR" =>$act));
}
