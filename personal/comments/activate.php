<?
 require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php"); 
if($_REQUEST["id"] && $_REQUEST["action"] && (int)$_REQUEST["id"]>0)
{
    $_REQUEST["ID"] = (int)$_REQUEST["id"];
}
else
LocalRedirect('/personal/salon/?type=comments');
global $USER;
CModule::IncludeModule("iblock");
$res = CIBlockElement::GetList(Array(),Array("ID"=>$_REQUEST["ID"]));
if($ob = $res->GetNextElement())
{
 $arProps = $ob->GetProperties();

    if($arProps["USER"]["VALUE"]==$USER->GetID())
    {
        if($_REQUEST["action"]=="N")
            $action = "5";
        else
            $action = "";
         CIBlockElement::SetPropertyValuesEx($_REQUEST["ID"], 1, array("COMMENTS_DEACTIVATE" =>$action));         
    }
    
    
}

LocalRedirect('/personal/salon/?type=comments');
?>