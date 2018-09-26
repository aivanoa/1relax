<?php
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
set_time_limit(0);
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ����� ��������� ���������� ������ ������ ��� ��������� ��������
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); 
$out = 1;
// ��������� ����������� ����������
$salon = intVal($_REQUEST["salon"]);

$rate = intVal($_REQUEST["rate"]);

global $USER;
if ($USER->IsAuthorized())
{
	if(CModule::IncludeModule("iblock"))
	{
		//��������� ������
		$arSelect = Array("ID", "IBLOCK_ID", "PROPERTY_USER", "PROPERTY_SUMM", "PROPERTY_CLICK", "PROPERTY_SORT","PROPERTY_76");
		$arFilter = Array("IBLOCK_ID"=>1, "ID"=>$salon);
		$result = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
		if($arFields = $result->GetNext())
		{


            $maxClickRes = CIBlockElement::GetList(array("PROPERTY_CLICK"=>"DESC"), array("ACTIVE"=>"Y","IBLOCK_ID"=>1,"!ID"=>$salon,"PROPERTY_CITY"=>$GLOBALS["arCity"]["ID"],"<PROPERTY_CLICK"=>$rate), false,false,array("PROPERTY_CLICK"))->Fetch();
            $maxClick = $maxClickRes["PROPERTY_CLICK_VALUE"];
            if(!$maxClick)
                $maxClick=4;
            else
               $maxClick++;
			// �������� � ����� ��� ��������
			$arFields["PROPERTY_USER_VALUE"] = intval($arFields["PROPERTY_USER_VALUE"]);
			$arFields["PROPERTY_SUMM_VALUE"] = intval($arFields["PROPERTY_SUMM_VALUE"]);
			$arFields["PROPERTY_CLICK_VALUE"] = intval($arFields["PROPERTY_CLICK_VALUE"]);
			$arFields["PROPERTY_SORT_VALUE"] = intval($arFields["PROPERTY_SORT_VALUE"]);

			if($arFields["PROPERTY_USER_VALUE"]==$USER->GetID())
			{
				
				//��������� ������
				if($rate>=DEFAULT_CLICK_VALUE)
				{
					// ���������� ������������� �� �������
					// ������*10000000000+������*100000+ID ������������
					// ��� ���� ����� ��������� ������ � ���������� �����������
					// ����� ����� ���� ����� ���������� ����� ������

					$SORT = $rate*10000000000 + $arFields["PROPERTY_SUMM_VALUE"]*100000 + $arFields["ID"];

					// ���� ���� ������ ����� - ���������� ����� ����
					if($arFields["PROPERTY_SUMM_VALUE"]<$rate)
                    {

                        $SORT = $arFields["PROPERTY_SUMM_VALUE"]*100000 + $arFields["ID"];
                    }


					//������������� ����� ������ � ���������� ��� ������
                    CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $rate, "CLICK");
					CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $SORT, "SORT");


					// ��������� ����� ������ ��� ������
					// � ��������� ��������� ��������� ������
					//ob_start();

					//������ ��������
					$SUMM = intVal($arFields["PROPERTY_SUMM_VALUE"]);
					$CLICK = intVal($rate);
					$SORT = intVal($SORT);
					$arResult["ID"] = $arFields["ID"];

					//����� ������ � ������
					$arFilter = Array("IBLOCK_ID"=>"1", "ACTIVE"=>"Y", "PROPERTY_CITY"=>$GLOBALS["arCity"]["ID"], ">=PROPERTY_SORT"=>$SORT);
					$PLACE = intVal(CIBlockElement::GetList(false, $arFilter, array()));

					//������ 5-20 �������
					$arSelect = Array("ID", "IBLOCK_ID", "PROPERTY_CLICK");
					$arFilter = Array("IBLOCK_ID"=>"1", "ACTIVE"=>"Y", "PROPERTY_CITY"=>$GLOBALS["arCity"]["ID"]);
					$result = CIBlockElement::GetList(Array("PROPERTY_SORT"=>"DESC"), $arFilter, false, Array("nPageSize"=>20), $arSelect);
					$i = 1;
					while($arFields = $result->GetNext())
					{
						if($i==1)//������ �����
							$place1 = intval($arFields["PROPERTY_CLICK_VALUE"])+1;
						if($i==5)//����� �����
							$place5 = intval($arFields["PROPERTY_CLICK_VALUE"])+1;
						if($i==20)//��������� �����
							$place20 = intval($arFields["PROPERTY_CLICK_VALUE"])+1;
						$i++;
					}

					$response = array(
										'place' => $PLACE,
										'click' => $maxClick ,
										'sort' => $SORT,
										'error' => 0									
									);
										
					if($SUMM>0 && $SUMM>=$CLICK)						
						$response['active'] = 1;
					else
						$response['active'] = 0;	
					
					die( json_encode($response) );
					?>
					<?
					//$out = ob_get_clean();
				}
				else
				{
					$out = '<div class="b-adv"><div class="status">��������� ������. �� �� ������ ������������� ������ ���� '.DEFAULT_CLICK_VALUE.' ������.</div></div>';
				}
			}
			else
			{
				$out = '<div class="b-adv"><div class="status">��������� ������. �� �� ������ ������������� ������ ��� ����� ������.</div></div>';
			}
		}
		else
		{
			$out = '<div class="b-adv"><div class="status">��������� ������. ����� �� ������.</div></div>';
		}
	}
	else
	{
		$out = '<div class="b-adv"><div class="status">��������� ������. ������ ���������� �� ���������.</div></div>';
	}
}
else
{
	$out = '<div class="b-adv"><div class="status">��������� ������. ���������� ��������� �������� �������.</div></div>';
}
?>



<?//header('Content-type: text/html; charset=windows-1251');?>
<?

$response = array(
					'out' => iconv('windows-1251', 'utf-8',  strip_tags($out)),
					'error' => 1
				);
die( json_encode($response) );

?>
<? 
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php"); 
?> 