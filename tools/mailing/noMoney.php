<?

//require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");


?>

<?




if(CModule::IncludeModule("iblock"))
{
    /*
    $res = CIBlockElement::GetList(array(),array("IBLOCK_ID"=>1),false,false,array("ID"));

    while($el = $res->GetNext())
    {


           CIBlockElement::SetPropertyValuesEx($el["ID"], 1, array("U_NO_MONEY" => 9));
           CIBlockElement::SetPropertyValuesEx($el["ID"], 1, array("U_MONEY_80" => 10));
            CIBlockElement::SetPropertyValuesEx($el["ID"], 1, array("U_POSITION_DOWN" => 11));

    }

    die;
    */
    //Выборка салонов
    $arSelect = Array(
        "ID",
        "IBLOCK_ID",
        "PROPERTY_SUMM",
        "PROPERTY_CLICK",
        "PROPERTY_SORT",
        "PROPERTY_CITY",
        "PROPERTY_USER",
        "NAME",
        "PROPERTY_U_NO_MONEY",
        "NAME"
    );
    $arFilter = Array(
        //">ID"             => "49816",
        "IBLOCK_ID"       => "1",
        ">PROPERTY_SUMM"  => "0",
        //"PROPERTY_SUMM"  => 0,
    );
    $res = CIBlockElement::GetList(array("PROPERTY_SORT"=>"DESC"), $arFilter, false, false, $arSelect);
    while($arFields = $res->GetNext())
    {

        if($arFields["PROPERTY_SUMM_VALUE"]<$arFields["PROPERTY_CLICK_VALUE"])
        {

            $res2 = CIBlockElement::GetList(array("CREATED"=>"DESC"), array("IBLOCK_ID"=> "8", "PROPERTY_SALON"=>$arFields["ID"]), false, array("nPageSize"=>1),array("PROPERTY_SUMM","DATE_CREATE","PROPERTY_U_100","IBLOCK_ID","ID"));
            if($arPost = $res2->GetNext())
            {

                if($arPost["PROPERTY_U_100_VALUE"]=="Y")
                    continue;

                if ($arFields["PROPERTY_U_NO_MONEY_VALUE"] == "Y") {
                    $city = CIBlockElement::GetByID($arFields["PROPERTY_CITY_VALUE"])->Fetch();

                    $user = CUser::GetByID($arFields["PROPERTY_USER_VALUE"])->Fetch();


                    $arEventFields = array(


                        "SALON" => $arFields["NAME"],
                        "SITE_URL2" => $city["CODE"],
                        "EMAIL_TO" => $user["EMAIL"],


                    );

                    CEvent::Send("NO_MONEY", "s1", $arEventFields);
                    CIBlockElement::SetPropertyValuesEx($arPost["ID"], $arPost["IBLOCK_ID"], array("U_100" =>14));
                }
            }
        }

    }



}
?>

