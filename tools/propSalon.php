<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Установка свойств салонов");
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
		// Сортировку устанавливаем по формуле
		// Ставка*10000000000+Баланс*100000+ID пользователя
		// Для того чтобы исключить салоны с одинаковой сортировкой
		// Чтобы можно было точно определить место салона
		//$SORT = 4*10000000000 + $arFields["PROPERTY_SUMM_VALUE"]*100000 + $arFields["ID"];
		//$SUMM = $arFields["PROPERTY_SUMM_VALUE"]+250;


						// Если следующее списание возможно, устанавливаем одну цифру сортировки, с учетом клика
						if($arFields["PROPERTY_SUMM_VALUE"]>=$arFields["PROPERTY_CLICK_VALUE"])
						{
							// Пересчитываем сортировку салона
							// Сортировку устанавливаем по формуле
							// Ставка*10000000000+Баланс*100000+ID пользователя
							// Для того чтобы исключить салоны с одинаковой сортировкой
							// Чтобы можно было точно определить место салона
							$SORT = $arFields["PROPERTY_CLICK_VALUE"]*10000000000 + $arFields["PROPERTY_SUMM_VALUE"]*100000 + $arFields["ID"];
						}
						else
						{
							// Если следующее списание НЕвозможно, устанавливаем другую цифру сортировки, без учета клика
							// Пересчитываем сортировку салона
							// Сортировку устанавливаем по формуле
							// Баланс*100000+ID пользователя
							// Для того чтобы исключить салоны с одинаковой сортировкой
							// Чтобы можно было точно определить место салона
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