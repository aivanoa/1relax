<?php
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ����� ��������� ���������� ������� ����� ������. ������

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

if ( $_GET['TEST']){
	$_REQUEST = unserialize('a:12:{s:17:"notification_type";s:12:"p2p-incoming";s:6:"amount";s:4:"4.98";s:8:"datetime";s:20:"2018-02-22T11:03:50Z";s:7:"codepro";s:5:"false";s:15:"withdraw_amount";s:4:"5.00";s:6:"sender";s:15:"410012609805441";s:9:"sha1_hash";s:40:"50ad8478f8bb839977d3c22346a84eabd39d0f8f";s:10:"unaccepted";s:5:"false";s:15:"operation_label";s:36:"2220b751-0009-5000-8000-00002d040242";s:12:"operation_id";s:19:"1145225260376004009";s:8:"currency";s:3:"643";s:5:"label";s:25:"3011_781486_beta_781486-7";}a:0:{}a:12:{s:17:"notification_type";s:12:"p2p-incoming";s:6:"amount";s:4:"4.98";s:8:"datetime";s:20:"2018-02-22T11:03:50Z";s:7:"codepro";s:5:"false";s:15:"withdraw_amount";s:4:"5.00";s:6:"sender";s:15:"410012609805441";s:9:"sha1_hash";s:40:"50ad8478f8bb839977d3c22346a84eabd39d0f8f";s:10:"unaccepted";s:5:"false";s:15:"operation_label";s:36:"2220b751-0009-5000-8000-00002d040242";s:12:"operation_id";s:19:"1145225260376004009";s:8:"currency";s:3:"643";s:5:"label";s:25:"3011_781486_beta_781486-7";}');
	$_GET = $_REQUEST;
	$_POST = $_REQUEST;
}

$mSign = sha1($_REQUEST["notification_type"]."&".$_REQUEST["operation_id"]."&".$_REQUEST["amount"]."&".$_REQUEST["currency"]."&".$_REQUEST["datetime"]."&".$_REQUEST["sender"]."&".$_REQUEST["codepro"]."&"."THC07D+LNNT8ETCGM1uXNZvL"."&".$_REQUEST["label"]);
 
$file = fopen ("file.txt","r+");

if ( !$file )
{
    echo("������ �������� �����");
}
else
{
    foreach($_REQUEST as $key=>$par)
    fputs ( $file, $key."-".$par."\n");
}
fputs ( $file, "mSign"."-".$mSign."\n");

fclose ($file);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>
<?

// ������ ���������. ���������� ������� ����������
// � ��������� ������ ������������ 

$errors = "";
//��������� ���������
//$mSign = md5($_REQUEST["OutSum"].":".$_REQUEST["InvId"].":"."".":Shp_params=".$_REQUEST["Shp_params"]);


if (strtoupper($mSign) == strtoupper($_REQUEST["sha1_hash"]))
{
    //��������� �����
    //����������� ������ � �����������
    $_REQUEST["label"] = iconv("UTF-8", "WINDOWS-1251", $_REQUEST["label"]);

    //����������� ����������
    if(CModule::IncludeModule("iblock"))
    {
        //�������� �������������� ��������� ������� � ����������� ����������
        list($userId, $salonId, $cityCode,$idZ) = explode("_", $_REQUEST["label"]);

        $_REQUEST["OutSum"] = intval($_REQUEST["amount"]);

		
		
		//��������� ����������, ������ ��������
			$arSelect = Array("ID", "IBLOCK_ID");
			$arFilter = Array("IBLOCK_ID"=>8, "NAME"=>$idZ,"ACTIVE"=>"N");
			$result2 = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
			if($arFields = $result2->GetNext())
			{
				$el = new CIBlockElement;

				$arLoadProductArray = Array(
					
					"ACTIVE"            => "Y"
					
						
				);

				if(!$el->Update($arFields["ID"],$arLoadProductArray))
					$errors .= "�� ������� ������������ ���������� ������.".$idZ;	
					
			}
			else
				$errors .= "�� ������� ����� ������������ ������.".$idZ;
				
        if(!strlen($errors))
        {
            // �������� ������, ����, ���������� ������
            $arSelect = Array("ID", "IBLOCK_ID", "PROPERTY_SUMM", "PROPERTY_CLICK", "PROPERTY_SORT");
            $arFilter = Array("IBLOCK_ID"=>1, "ID"=>$salonId);
            $result = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
            if($arFields = $result->GetNext())
            {
                $arFields["PROPERTY_SUMM_VALUE"] = intval($arFields["PROPERTY_SUMM_VALUE"]);
                $NEW_BALANCE = $arFields["PROPERTY_SUMM_VALUE"]+$_REQUEST["OutSum"];

				
                CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $NEW_BALANCE, "SUMM");

                // �������� � ����� ��� ��������
                $arFields["PROPERTY_CLICK_VALUE"] = intval($arFields["PROPERTY_CLICK_VALUE"]);
                $arFields["PROPERTY_SORT_VALUE"] = intval($arFields["PROPERTY_SORT_VALUE"]);

                // ���� ���� ������ DEFAULT_CLICK_VALUE, ������ ������ DEFAULT_CLICK_VALUE
                if($arFields["PROPERTY_CLICK_VALUE"] < DEFAULT_CLICK_VALUE)
                {
                    $arFields["PROPERTY_CLICK_VALUE"] = DEFAULT_CLICK_VALUE;
                }

                // ���������� ������������� �� �������
                // ������*10000000000+������*100000+ID ������������
                // ��� ���� ����� ��������� ������ � ���������� �����������
                // ����� ����� ���� ����� ���������� ����� ������
                $NEW_SORT = $arFields["PROPERTY_CLICK_VALUE"]*10000000000 + $NEW_BALANCE*100000 + $arFields["ID"];

                // ��������� ����� �����, ���� �� ������ ��� ����� �����
                if($NEW_BALANCE>=$arFields["PROPERTY_CLICK_VALUE"])
                {
                    CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $NEW_SORT, "SORT");
                }
            }
            else
            {
                $errors .= "�� ������ ����� ��� ��������� �������� �������. �� ������� ��������� ������";
            }

        }

    }
    else
    {
        //������ ���������� �� ���������
        $errors .= "������ ���������� �� ���������";
    }
}
else
{
    //��������� �� �����
    $errors .= "��������� �� �����";
}

if(!strlen($errors))
{
    list($userId, $salonId, $cityCode,$idZ) = explode("_", $_REQUEST["label"]);
    //���������� ������� ��������� ��������� �������
    print "OK".$idZ;
}
else
{
	var_dump($errors);

    // ���������� ����������� ������
 //   SendError($errors);
}

?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?> 

