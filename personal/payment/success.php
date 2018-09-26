<?
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
set_time_limit(0);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); 
?> 
<?

// Оплата совершена. Необходимо переадресовать пользователя в кабинет
// C соответствующим сообщением

$errors = "";
//Проверяем сигнатуру
$mSign = md5($_REQUEST["OutSum"].":".$_REQUEST["InvId"].":".MERCHANT_PASSWORD2.":Shp_code=".$_REQUEST["Shp_code"].":Shp_params=".$_REQUEST["Shp_params"]);

if (isset($_REQUEST['Shp_params'])) 
{
	//Сигнатура верна
	//Раскодируем строку с параметрами
	$_REQUEST["Shp_params"] = iconv("UTF-8", "WINDOWS-1251", $_REQUEST["Shp_params"]);
	
	//Подключение инфоблоков
	if(CModule::IncludeModule("iblock"))
	{
	    //Получаем дополнительные параметры платежа и присваиваем переменные
		list($userId, $salonId, $cityCode) = explode("_", $_REQUEST["Shp_params"]);
		
		//Делаем редирект в кабинет
		LocalRedirect("http://".$cityCode.".1relax.ru/personal/salon/?strMessage=".urlencode('Ваш платеж успешно зачислен. В течение нескольких минут заказанные услуги появятся в вашем <a href="/personal/salon/">Личном кабинете</a>'));
		exit();	
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

if(strlen($errors))
{
	// Отправляем уведомление админу
	var_dump($errors);
	SendError($errors);
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?> 

