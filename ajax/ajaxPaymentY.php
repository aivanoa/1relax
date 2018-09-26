<?php
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
set_time_limit(0);
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Срипт выполняет вычисление сигнатуры для оплаты через Робокассу
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); 



//Сигнатура верна
    //Раскодируем строку с параметрами
    $_REQUEST["data"] = iconv("UTF-8", "WINDOWS-1251", $_REQUEST["data"]);

    //Подключение инфоблоков
    if(CModule::IncludeModule("iblock"))
    {

        

        //Получаем дополнительные параметры платежа и присваиваем переменные
        list($userId, $salonId, $cityCode,$idZ) = explode("_", $_REQUEST["data"]);

        $arSelect = Array("ID");
        $arFilter = Array("IBLOCK_ID"=>8, 'PROPERTY_SALON' => $salonId);
        $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
        $trnsCnt = $res->SelectedRowsCount()+1;
        $NEW_ID = $salonId.'-'.$trnsCnt;
  
        $_REQUEST["OutSum"] = intval($_REQUEST["sum"]);

        //Добавляем пополнение, деньги получены
        $el = new CIBlockElement;

        $arLoadProductArray = Array(
            "IBLOCK_ID"         => 8,
            "NAME"              => $NEW_ID,
            "ACTIVE"            => "N",
			"CODE"              => $NEW_ID,
            "PROPERTY_VALUES"   => array(
                "SUMM"			=> $_REQUEST["OutSum"],
                "USER"			=> $userId,
                "SALON"			=> $salonId,
				"PAYSYSTEM" => Array("VALUE" => 6 )
            ),
        );

        if(!$el->Add($arLoadProductArray))
            echo "Не удалось добавить пополнение. ".$el->LAST_ERROR;
        else{
            echo $userId."_".$salonId."_".$cityCode."_".$NEW_ID;
            die();
        }
}