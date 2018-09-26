<?php
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
set_time_limit(0);
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ����� ��������� ���������� ������� ����� ���������
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); 
?>
<?

// ������ ���������. ���������� ������� ����������
// � ��������� ������ ������������ 

$errors = "";
//��������� ���������
$mSign = md5($_REQUEST["OutSum"].":".$_REQUEST["InvId"].":".MERCHANT_PASSWORD2.":Shp_code=".$_REQUEST["Shp_code"].":Shp_params=".$_REQUEST["Shp_params"]);

if (strtoupper($mSign) == strtoupper($_REQUEST["SignatureValue"])) 
{
	//��������� �����
	//����������� ������ � �����������
	$_REQUEST["Shp_params"] = iconv("UTF-8", "WINDOWS-1251", $_REQUEST["Shp_params"]);

	//����������� ����������
	if(CModule::IncludeModule("iblock"))
	{
	    //�������� �������������� ��������� ������� � ����������� ����������
		list($userId, $salonId, $cityCode) = explode("_", $_REQUEST["Shp_params"]);

		$_REQUEST["OutSum"] = intval($_REQUEST["OutSum"]);

		//��������� ����������, ������ ��������
			$arSelect = Array("ID", "IBLOCK_ID");
			$arFilter = Array("IBLOCK_ID"=>8, "NAME"=>$_REQUEST["Shp_code"],"ACTIVE"=>"N");
			$result2 = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
			if($arFields = $result2->GetNext())
			{
				$el = new CIBlockElement;

				$arLoadProductArray = Array(
					
					"ACTIVE"            => "Y"
					
						
				);

				if(!$el->Update($arFields["ID"],$arLoadProductArray))
					$errors .= "�� ������� ������������ ���������� ������.".$_REQUEST["Shp_code"];	
					
			}
			else
				$errors .= "�� ������� ����� ������������ ������.".$_REQUEST["Shp_code"];
			

	    
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
	//���������� ������� ��������� ��������� �������
	print "OK".$_REQUEST["Shp_code"];
}
else
{
	// ���������� ����������� ������
	SendError($errors);
}

?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?> 

