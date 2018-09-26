<?php
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
set_time_limit(0);
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Срипт выполняет зачисление средств через Робокассу
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); 
?>
<?

// Оплата совершена. Необходимо создать пополнение
// И пополнить баланс пользователя 

$errors = "";
//Проверяем сигнатуру
$mSign = md5($_REQUEST["OutSum"].":".$_REQUEST["InvId"].":".MERCHANT_PASSWORD2.":Shp_code=".$_REQUEST["Shp_code"].":Shp_params=".$_REQUEST["Shp_params"]);

if (strtoupper($mSign) == strtoupper($_REQUEST["SignatureValue"])) 
{
	//Сигнатура верна
	//Раскодируем строку с параметрами
	$_REQUEST["Shp_params"] = iconv("UTF-8", "WINDOWS-1251", $_REQUEST["Shp_params"]);

	//Подключение инфоблоков
	if(CModule::IncludeModule("iblock"))
	{
	    //Получаем дополнительные параметры платежа и присваиваем переменные
		list($userId, $salonId, $cityCode) = explode("_", $_REQUEST["Shp_params"]);

		$_REQUEST["OutSum"] = intval($_REQUEST["OutSum"]);

		//ПРОВЕРЯЕМ пополнение, деньги получены
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
					$errors .= "Не удалось активировать оплаченную заявку.".$_REQUEST["Shp_code"];	
					
			}
			else
				$errors .= "Не удалось найти неоплаченную заявку.".$_REQUEST["Shp_code"];
			

	    
		if(!strlen($errors))
		{
			// Получаем баланс, клик, сортировку салона
			$arSelect = Array("ID", "IBLOCK_ID", "PROPERTY_SUMM", "PROPERTY_CLICK", "PROPERTY_SORT");
			$arFilter = Array("IBLOCK_ID"=>1, "ID"=>$salonId);
			$result = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
			if($arFields = $result->GetNext())
			{
				$arFields["PROPERTY_SUMM_VALUE"] = intval($arFields["PROPERTY_SUMM_VALUE"]);
				$NEW_BALANCE = $arFields["PROPERTY_SUMM_VALUE"]+$_REQUEST["OutSum"];

				CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $NEW_BALANCE, "SUMM");

				// Приводим к целым все значения
				$arFields["PROPERTY_CLICK_VALUE"] = intval($arFields["PROPERTY_CLICK_VALUE"]);
				$arFields["PROPERTY_SORT_VALUE"] = intval($arFields["PROPERTY_SORT_VALUE"]);

				// Если клик меньше DEFAULT_CLICK_VALUE, делаем равным DEFAULT_CLICK_VALUE
				if($arFields["PROPERTY_CLICK_VALUE"] < DEFAULT_CLICK_VALUE)
				{
					$arFields["PROPERTY_CLICK_VALUE"] = DEFAULT_CLICK_VALUE;
				}

				// Сортировку устанавливаем по формуле
				// Ставка*10000000000+Баланс*100000+ID пользователя
				// Для того чтобы исключить салоны с одинаковой сортировкой
				// Чтобы можно было точно определить место салона
				$NEW_SORT = $arFields["PROPERTY_CLICK_VALUE"]*10000000000 + $NEW_BALANCE*100000 + $arFields["ID"];

				// Проверяем новую сумму, если он больше или равна клику
				if($NEW_BALANCE>=$arFields["PROPERTY_CLICK_VALUE"])
				{
					CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $NEW_SORT, "SORT");
				}
			}
			else
			{
				$errors .= "Не найден салон для получения текущего баланса. Не удалось увеличить баланс";	
			}
			
		}
		
	}
	else
	{
		//Модуль инфоблоков не подключен
		$errors .= "Модуль инфоблоков не подключен";
	}
}
else
{
	//Сигнатура не верна
	$errors .= "Сигнатура не верна";
}

if(!strlen($errors))
{
	//Возвращаем удачный результат платежной системе
	print "OK".$_REQUEST["Shp_code"];
}
else
{
	// Отправляем уведомление админу
	SendError($errors);
}

?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?> 

