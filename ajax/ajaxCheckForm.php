<?php
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
set_time_limit(0);
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Срипт выполняет проверку данных, заполняемых в формах по ajax
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); 



ob_start();
if ($_REQUEST["fieldId"]=="prop3")//Проверка электронного адреса
{
	$arFilter = Array("EMAIL" => $_REQUEST["fieldValue"]);
	$rsUsers = CUser::GetList($by='timestamp_x', $order='desc', $arFilter);
	if($rsUsers->NavNext(true, "f_"))
		print '["'.$_REQUEST["fieldId"].'",false]';	
	else
		print '["'.$_REQUEST["fieldId"].'",true]';
}
$out = ob_get_clean();
header('Content-type: text/html; charset=utf-8');
print $out;
//Отладка с помощью файла
//$f = fopen($_SERVER["DOCUMENT_ROOT"]."/ajax/file.txt", "w+");
//fwrite($f, print_r($_REQUEST, true).$out);
//fclose($f);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php"); 
?> 