<?php
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
set_time_limit(0);

$error = false;
$success = false;

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Срипт выполняет сохранение ставки салона для рекламной кампании
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); 

// Проверяем поступившие переменные
$salon = intVal($_REQUEST["salon"]);

$PHONEAUTH = $_REQUEST["PHONEAUTH"];

global $USER;
if ($USER->IsAuthorized())
{
	if(CModule::IncludeModule("iblock"))
	{
		//Получение салона
		$arSelect = Array("ID", "IBLOCK_ID", "PROPERTY_USER", "PROPERTY_SUMM", "PROPERTY_CLICK", "PROPERTY_SORT","PROPERTY_PHONEAUTH");
		$arFilter = Array("IBLOCK_ID"=>1, "ID"=>$salon);
		$result = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
		if($arFields = $result->GetNext())
		{



			if($arFields["PROPERTY_USER_VALUE"]==$USER->GetID())
			{
				//Проверяем ставку
				if(!empty($PHONEAUTH))
				{

                    require_once($_SERVER["DOCUMENT_ROOT"]."/tools/phone.php");
                    $PHONEAUTH = phone($PHONEAUTH);

                    $PHONEAUTH = preg_replace("/\D+/", "", $PHONEAUTH);
    				$PHONEAUTH = preg_replace("/ /", "", $PHONEAUTH);
                	$PHONEAUTH = preg_replace("/^8(\d{10}\z)/", "7$1", $PHONEAUTH);

                	if ( !isPhoneAvailable( $PHONEAUTH ) )
                		$error = 'Этот номер уже занят. Попробуйте ввести другой.';
                	else {
	                		//Устанавливаем новую ставку и сортировку для салона
	                    CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $PHONEAUTH, "PHONEAUTH");
						CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], 15, "PHONEAUTHCHECK");
						$success = true;
                	}
				}
				else
				{
					$error = 'Вы не указали телефон.';
				}
			}
			else
			{
				$error = 'Вы не можете менять телефон для этого салона.';
			}
		}
		else
		{
			$error = 'Салон не найден.';
		}
	}
	else
	{
		$error = 'Модуль инфоблоков не подключен.';
	}
}
else
{
	$error = 'Попробуйте выполнить действие позднее.';
}
?>





<?php

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// RESPONSE
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

$msg = '';
if ( $error  )   $msg = mb_convert_encoding($error, 'utf-8');
if ( $success  ) $msg = mb_convert_encoding($PHONEAUTH, 'utf-8');


$res = array(
		'error'   => ( $error ) ? true : false,
		'success' => ( $success ) ? true : false,
		'msg'     => $msg
	);

echo json_encode($res);