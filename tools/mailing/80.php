<?

//require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

?>

<?
if(CModule::IncludeModule("iblock"))
{

    //Выборка салонов
    $arSelect = Array(
        "ID",
        "IBLOCK_ID",
        "PROPERTY_SUMM",
        "PROPERTY_CLICK",
        "PROPERTY_SORT",
        "PROPERTY_CITY",
        "PROPERTY_USER",
        "PROPERTY_U_MONEY_80",
        "NAME"
    );
    $arFilter = Array(
        //">ID"             => "49816",
        "IBLOCK_ID"       => "1",
        ">=PROPERTY_SUMM"  => "0",
        //"PROPERTY_SUMM"  => 0,
    );
    $res = CIBlockElement::GetList(array("PROPERTY_SORT"=>"DESC"), $arFilter, false, false, $arSelect);
    while($arFields = $res->GetNext())
    {

        $res2 = CIBlockElement::GetList(array("CREATED"=>"DESC"), array("IBLOCK_ID"=> "8", "PROPERTY_SALON"=>$arFields["ID"]), false, array("nPageSize"=>1),array("PROPERTY_SUMM","DATE_CREATE","PROPERTY_U_80","IBLOCK_ID","ID"));
        if($arPost = $res2->GetNext())
        {
            if($arPost["PROPERTY_U_80_VALUE"]=="Y")
                continue;



            $s = 0;
            $res3 = CIBlockElement::GetList(array(), array("IBLOCK_ID"=> "9", "PROPERTY_SALON"=>$arFields["ID"],">DATE_CREATE"=>ConvertDateTime($arPost["DATE_CREATE"], "DD.MM.YYYY HH:MI:SS")), false, false ,array("PROPERTY_SUMM","DATE_CREATE"));
            while($arSpis = $res3->GetNext())
            {

                //  echo $arSpis["DATE_CREATE"]."---".$arPost["DATE_CREATE"]."<br>";
                $s+=$arSpis["PROPERTY_SUMM_VALUE"];

            }

            if((($s*100)/$arPost["PROPERTY_SUMM_VALUE"])>80)
            {
                if($arFields["PROPERTY_U_MONEY_80_VALUE"]=="Y")
                {

                    $city = CIBlockElement::GetByID($arFields["PROPERTY_CITY_VALUE"])->Fetch();

                    $user = CUser::GetByID($arFields["PROPERTY_USER_VALUE"])->Fetch();


                    $arEventFields = array(


                        "SALON"            => $arFields["NAME"],
                        "SITE_URL2"            => $city["CODE"],
                        "EMAIL_TO"            => $user["EMAIL"],
                        "SUMM"=> $arPost["PROPERTY_SUMM_VALUE"]



                    );

                    CEvent::Send("MONEY_80", "s1", $arEventFields);

                    CIBlockElement::SetPropertyValuesEx($arPost["ID"], $arPost["IBLOCK_ID"], array("U_80" =>13));
                }
            }

        }




    }
}
?>

