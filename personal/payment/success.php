<?
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
set_time_limit(0);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); 
?> 
<?

// ������ ���������. ���������� �������������� ������������ � �������
// C ��������������� ����������

$errors = "";
//��������� ���������
$mSign = md5($_REQUEST["OutSum"].":".$_REQUEST["InvId"].":".MERCHANT_PASSWORD2.":Shp_code=".$_REQUEST["Shp_code"].":Shp_params=".$_REQUEST["Shp_params"]);

if (isset($_REQUEST['Shp_params'])) 
{
	//��������� �����
	//����������� ������ � �����������
	$_REQUEST["Shp_params"] = iconv("UTF-8", "WINDOWS-1251", $_REQUEST["Shp_params"]);
	
	//����������� ����������
	if(CModule::IncludeModule("iblock"))
	{
	    //�������� �������������� ��������� ������� � ����������� ����������
		list($userId, $salonId, $cityCode) = explode("_", $_REQUEST["Shp_params"]);
		
		//������ �������� � �������
		LocalRedirect("http://".$cityCode.".1relax.ru/personal/salon/?strMessage=".urlencode('��� ������ ������� ��������. � ������� ���������� ����� ���������� ������ �������� � ����� <a href="/personal/salon/">������ ��������</a>'));
		exit();	
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

if(strlen($errors))
{
	// ���������� ����������� ������
	var_dump($errors);
	SendError($errors);
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?> 

