<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("��������� ������� �������");
?>

<?
if(CModule::IncludeModule("iblock"))
{
	//������� �������
	$arSelect = Array(
		"ID",
		"IBLOCK_ID",
		"PROPERTY_SUMM",
		"PROPERTY_CLICK",
		"PROPERTY_SORT",
	);
	$arFilter = Array(
		//">ID"             => "49816",
		"IBLOCK_ID"       => "1",
		//"!PROPERTY_SUMM"  => "1000",
		"PROPERTY_SUMM"  => 0,
	);
	$res = CIBlockElement::GetList(array("PROPERTY_SORT"=>"DESC"), $arFilter, false, array("nPageSize"=>50), $arSelect);
	while($arFields = $res->GetNext())
	{
		// ���������� ������������� �� �������
		// ������*10000000000+������*100000+ID ������������
		// ��� ���� ����� ��������� ������ � ���������� �����������
		// ����� ����� ���� ����� ���������� ����� ������
		//$SORT = 4*10000000000 + $arFields["PROPERTY_SUMM_VALUE"]*100000 + $arFields["ID"];
		//$SUMM = $arFields["PROPERTY_SUMM_VALUE"]+250;


						// ���� ��������� �������� ��������, ������������� ���� ����� ����������, � ������ �����
						if($arFields["PROPERTY_SUMM_VALUE"]>=$arFields["PROPERTY_CLICK_VALUE"])
						{
							// ������������� ���������� ������
							// ���������� ������������� �� �������
							// ������*10000000000+������*100000+ID ������������
							// ��� ���� ����� ��������� ������ � ���������� �����������
							// ����� ����� ���� ����� ���������� ����� ������
							$SORT = $arFields["PROPERTY_CLICK_VALUE"]*10000000000 + $arFields["PROPERTY_SUMM_VALUE"]*100000 + $arFields["ID"];
						}
						else
						{
							// ���� ��������� �������� ����������, ������������� ������ ����� ����������, ��� ����� �����
							// ������������� ���������� ������
							// ���������� ������������� �� �������
							// ������*100000+ID ������������
							// ��� ���� ����� ��������� ������ � ���������� �����������
							// ����� ����� ���� ����� ���������� ����� ������
							$SORT = $arFields["PROPERTY_SUMM_VALUE"]*100000 + $arFields["ID"];
						}


		print $arFields["PROPERTY_SUMM_VALUE"]."|".$arFields["PROPERTY_SORT_VALUE"]."|".$arFields["PROPERTY_CLICK_VALUE"]."<br />";
		print $SUMM."|".$SORT."|".$arFields["PROPERTY_CLICK_VALUE"]."<br />";
		//CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $SORT, "SORT");
		//CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $SUMM, "SUMM");
		//CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], "4", "CLICK");
		//print $arFields["ID"]."<br />";
	}
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>