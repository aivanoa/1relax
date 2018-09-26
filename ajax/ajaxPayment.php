<?php
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
set_time_limit(0);
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Срипт выполняет вычисление сигнатуры для оплаты через Робокассу
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); 



//Проверяем сигнатуру
$mSign = md5($_REQUEST["OutSum"].":".$_REQUEST["InvId"].":".MERCHANT_PASSWORD2.":Shp_params=".$_REQUEST["Shp_params"]);

//if (strtoupper($mSign) == strtoupper($_REQUEST["SignatureValue"])) 
//{
	//Сигнатура верна
	//Раскодируем строку с параметрами
	$_REQUEST["Shp_params"] = iconv("UTF-8", "WINDOWS-1251", $_REQUEST["Shp_params"]);

	//Подключение инфоблоков
	if(CModule::IncludeModule("iblock"))
	{
	

		//Получаем дополнительные параметры платежа и присваиваем переменные
		list($userId, $salonId, $cityCode) = explode("_", $_REQUEST["Shp_params"]);

		$arSelect = Array("ID");
		$arFilter = Array("IBLOCK_ID"=>8, 'PROPERTY_SALON' => $salonId);
		
		
		$res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
		$trnsCnt = $res->SelectedRowsCount()+1;
		
		$NEW_ID = $salonId.'-'.$trnsCnt;


	    

		$_REQUEST["OutSum"] = intval($_REQUEST["OutSum"]);

		//Добавляем пополнение, деньги получены
	    $el = new CIBlockElement;

		$arLoadProductArray = Array(
			"IBLOCK_ID"         => 8,
			"NAME"              => $NEW_ID,
			"ACTIVE"            => "N",
			"CODE"				=> $NEW_ID,
			"PROPERTY_VALUES"   => array(
				"SUMM"			=> $_REQUEST["OutSum"],
				"USER"			=> $userId,
				"SALON"			=> $salonId,
				"PAYSYSTEM" => Array("VALUE" => 2 )
			),	
		);

		if($InvID = $el->Add($arLoadProductArray)){ 


			$par = $_REQUEST["Shp_params"];
			$sum = $_REQUEST["OutSum"];
			$mSign = strtoupper(md5(MERCHANT_LOGIN.":$sum:0:".MERCHANT_PASSWORD.":Shp_code=$NEW_ID:Shp_params=$par"));
		
			?>
			<input name="InvID" value="0" type="hidden">
			<input name="Shp_code" value="<?=$NEW_ID?>" type="hidden">
			<input name="SignatureValue" value="<?=$mSign?>" type="hidden">

		<?php } 
		else		
			echo "Не удалось добавить пополнение. "."".$el->LAST_ERROR;
		
		
		

	}
	
//}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?> 