<?php
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
set_time_limit(0);
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ����� ��������� ���������� ��������� ��� ������ ����� ���������
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); 



//��������� �����
    //����������� ������ � �����������
    $_REQUEST["data"] = iconv("UTF-8", "WINDOWS-1251", $_REQUEST["data"]);

    //����������� ����������
    if(CModule::IncludeModule("iblock"))
    {

        

        //�������� �������������� ��������� ������� � ����������� ����������
        list($userId, $salonId, $cityCode,$idZ) = explode("_", $_REQUEST["data"]);

        $arSelect = Array("ID");
        $arFilter = Array("IBLOCK_ID"=>8, 'PROPERTY_SALON' => $salonId);
        $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
        $trnsCnt = $res->SelectedRowsCount()+1;
        $NEW_ID = $salonId.'-'.$trnsCnt;
  
        $_REQUEST["OutSum"] = intval($_REQUEST["sum"]);

        //��������� ����������, ������ ��������
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
            echo "�� ������� �������� ����������. ".$el->LAST_ERROR;
        else{
            echo $userId."_".$salonId."_".$cityCode."_".$NEW_ID;
            die();
        }
}