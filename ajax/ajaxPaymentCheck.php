<?php
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
set_time_limit(0);
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Срипт выполняет вычисление сигнатуры для оплаты через Робокассу
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); 
?>
<?


$mBill = $_REQUEST["bill"];
$mSumm = $_REQUEST["cost"];
$mParams = $_REQUEST["params"];
$mSign = md5(MERCHANT_LOGIN.":$mSumm:$mBill:".MERCHANT_PASSWORD.":Shp_params=$mParams");
?>
<input name="SignatureValue" value="<?=$mSign?>" type="hidden">
