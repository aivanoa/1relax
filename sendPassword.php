<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("�������������� ������ ����� ��������� �������");?>
<h1><?$APPLICATION->ShowTitle("�������������� ������ ����� ��������� �������!");?></h1>





<?

$flag = true;


if(!$_POST["USER_LOGIN"])
    LocalRedirect("/personal/?forgot_password=yes");
$form = true;
$change = false;
$_POST["USER_LOGIN"] = $_POST["USER_LOGIN"];


if($_POST["checkpassword"])
{
    $error = false;
    if(strlen($_POST["CHECKCODE"])<=0 && strlen($_POST["PASSWORD"])<=0&& strlen($_POST["CHECKPASSWORD"])<=0)
        $error = "�� ����� �� ��� ����";
    if($_POST["PASSWORD"]!==$_POST["CHECKPASSWORD"])
        $error = "��������� ������ �� ���������";

    if(!$error)
    {
        $change = true;

		$phone = $_POST["USER_LOGIN"];
		$phone = preg_replace("/\D+/", "", $phone);
		$phone = preg_replace("/ /", "", $phone);
		
		if ($phone{0} == "8")
		{
		 $phone = "7".substr($phone, 1);
		}
		
        $res =   CIBlockElement::GetList(array(),array("IBLOCK_ID"=>1,"PROPERTY_PHONEAUTH"=>$phone),false,false,array("PROPERTY_USER"));
        $arSalon = $res->GetNext();

        if($arSalon["PROPERTY_USER_VALUE"]>0) {

            $rsUser = CUser::GetByID($arSalon["PROPERTY_USER_VALUE"]);
            $arUser = $rsUser->Fetch();
            if($arUser["UF_CHECKCODE"]==$_POST["CHECKCODE"] && strlen($arUser["UF_CHECKCODE"])>4)
            {
                $USER->Update($arUser["ID"],array("PASSWORD"=>$_POST["PASSWORD"],"CONFIRM_PASSWORD"=>$_POST["PASSWORD"]));
			
                $form = false;
                LocalRedirect("/personal/?true=1");
            }
            else
                $error = "��� �� ��� ��������";
        }
 




    }

}
//echo $USER->Update(1288,array("PASSWORD"=>'333333',"CHECKWORD"=>"123123"));

$EMAIL = $_POST["USER_LOGIN"];


if(!strpos($EMAIL,"@") && strlen($EMAIL)>0 && $form){

    CModule::IncludeModule("iblock");

	$phone = $EMAIL;
	$phone = preg_replace("/\D+/", "", $phone);
	$phone = preg_replace("/ /", "", $phone);
	
	if ($phone{0} == "8")
	{
	 $phone = "7".substr($phone, 1);
	}
	

    $res =   CIBlockElement::GetList(array(),array("IBLOCK_ID"=>1,"PROPERTY_PHONEAUTH"=>$phone),false,false,array("PROPERTY_USER"));
    $arSalon = $res->GetNext();

    if($arSalon["PROPERTY_USER_VALUE"]>0)
    {


        $rsUser = CUser::GetByID($arSalon["PROPERTY_USER_VALUE"]);
        $arUser = $rsUser->Fetch();

        $LOGIN = $arUser["LOGIN"];
        $rand = rand(100000,999999);
        $USER->Update($arUser["ID"],array("UF_CHECKCODE"=>$rand));
        $phone = preg_replace("/\D+/", "", $EMAIL);

        if ($phone{0} == "8")
        {
            $phone = "7".substr($phone, 1);
        }

        $postData = array(
            "user"=>"1relax@bk.ru",
            "password"=>'VZoQSjkq5sxq5NFx96yaYbkVy3U6',
            "to"=> $phone,
            "text"=>$rand,
            "from"=>"1relax"
        );
        // ������� �����������
        $ch = curl_init('https://gate.smsaero.ru/send/');
        // ������������ ����� ��� ��������
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        // ���� � ���, ��� ����� �������� ���������
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // ���������� ������
        $response = curl_exec($ch);
        // ��������� ����������
        curl_close($ch);


        ?>

            <p>�� ��� ����� �������� ��������� ��� ��� �������������� ������. ��� �������� � ������� 5 �����.</p>

        <form name="check" method="post" target="_top" action="">
            <?
            if (strlen($_POST["backurl"]) > 0)
            {
                ?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <?
            }
            ?>

            <input type="hidden" name="USER_LOGIN" value="<?=$EMAIL?>" />
<?if($error):?>
            <p style="color:red"><?=$error?>. ��������� ����� ������</p>
        <?endif;?>
            <table cellspacing="10">
                <tr>
                    <td width="50">�</td>
                    <td width="50%">����������� ��� (�� ���)</td>

                    <td><input class="input" type="text" name="CHECKCODE" size="40" maxlength="50" value="" /></td>
                </tr>
                <tr>
                    <td width="50">�</td>
                    <td>����� ������</td>
                    <td><input class="input" type="text" name="PASSWORD" size="40" maxlength="50" value="" /></td>
                </tr>
                <tr>
                    <td width="50">�</td>
                    <td>��������� ����� ������</td>
                    <td><input class="input" type="text" name="CHECKPASSWORD" size="40" maxlength="50" value="" /></td>
                </tr>



                <tr>
                    <td>�</td>
                    <td></td>
                    <td><input type="submit" class="input button" name="checkpassword" value=" � ��������  � " /></td>
                </tr>

            </table>

        </form>



        <?
    }
    else
        $flag = false;
}
else
    $flag = false;

if(!$flag && !$change)
    LocalRedirect("/personal/?forgot_password=yes&error=1");
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>






<?
class Smsaero
{
    private $gate;
    private $username;
    private $password;
    private $from;
    private $typeanswer;
    private $useragent;

    function __construct($username,
                         $password,
                         $from,
                         $typeanswer = 'json',
                         $useragent = 'Mozilla/5.0 (Windows NT 6.1; rv:15.0) Gecko/20100101 Firefox/15.0.1')
    {
        $this->username = $username;
        $this->password = $password;
        $this->typeanswer = "&answer={$typeanswer}";
        $this->from = $from;
        $this->useragent = $useragent;
        $this->gate = 'http://gate.smsaero.ru';
    }

    /**
     * ��������� ������ �� ������
     * @param $url ����� �������
     * @return mixed
     */
    private function send_post($url, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->gate . $url . '?' . str_replace('+', '%20', http_build_query($data)) . $this->typeanswer);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->useragent);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    /**
     * �������� ���������
     * @param $to ����� �������� ����������, � ������� 71234567890
     * @param $text ����� ���������, � UTF-8 ���������
     * @param $from ������� ����������� (�������� TEST)
     * @param $date ���� ��� ���������� �������� ��������� (���������� ������ � 1 ������ 1970 ����)
     */
    function send($to, $text, $from = '1relax', $date = null)
    {
        if (is_null($from))
            $from = $this->from;

        $response = $this->send_post(
            "/send/",
            array(
                'user' => $this->username,
                'password' => $this->password,
                'to' => $to,
                'text' => $text,
                'from' => $from,
                'date' => $date
            )
        );

        return $response;
    }

    /**
     * �������� ��������� ������������� ���������
     * @param $id ������������� ���������, ������� ������ ������ ��� �������� ���������
     */
    function getStatus($id)
    {
        return $this->send_post(
            "/status/",
            array(
                'user' => $this->username,
                'password' => $this->password,
                'id' => $id
            )
        );
    }

    /**
     * �������� ��������� �����
     */
    function getBalance()
    {
        return $this->send_post(
            "/balance/",
            array(
                'user' => $this->username,
                'password' => $this->password
            )
        );
    }

    /**
     * ������ ��������� �������� �����������
     */
    function getSenders()
    {
        return $this->send_post(
            "/senders/",
            array(
                'user' => $this->username,
                'password' => $this->password
            )
        );
    }
}


//�����, apikey, �����������
//$sms = new Smsaero('1relax@bk.ru', 'VZoQSjkq5sxq5NFx96yaYbkVy3U6', '1relax');

/*
������( Smsaero::send() ):
------------
accepted    ��������� ������� ��������
empty field. reject �� ��� ������������ ���� ���������
incorrect user or password. reject  ������ �����������
no credits  ������������ ������� �� �������
incorrect sender name. reject   �������� (��������������������) ������� �����������
incorrect destination adress. reject    ������� ����� ����� �������� (������ 71234567890)
incorrect date. reject  ������������ ������ ����
in blacklist. reject    ������� ��������� � ������ ������. ��������! ������ ������ ����������� �� �������� ��� ������������� ���� �������� sendtogroup
incorrect language in '...' use the cyrillic or roman alphabet  � ����� "..." ������������ ������������ ������� �� ��������� � ��������
------------

������� ��������� ���������( Smsaero::getStatus( $id ) ):
------------
delivery success    ��������� ����������
delivery failure    ������ �������� SMS (������ ������� ���, ��� ������� ��������� ��� ���� �������� ����)
smsc submit ��������� �������� ���������
smsc reject ��������� ���������
queue   ������� ��������
wait status �������� ������� (��������� �������)
incorrect id. reject    �������� ������������� ���������
empty field. reject �� ��� ������������ ���� ���������
incorrect user or password. reject  ������ �����������
------------
*/
//$smsServiceResponse = $sms->send($phone, $rand);


//echo '!!!';
//print_r( $smsServiceResponse );


/*
function SendPassword($LOGIN, $EMAIL, $SITE_ID = false)
{

    if(!strpos($EMAIL,"@") && strlen($EMAIL)>0){
        CModule::IncludeModule("iblock");

        $res =   CIBlockElement::GetList(array(),array("IBLOCK_ID"=>1,"%PROPERTY_PHONE%"=>$EMAIL),false,false,array("PROPERTY_USER"));
        $arSalon = $res->GetNext();

        if($arSalon["PROPERTY_USER_VALUE"]>0)
        {
            $rsUser = CUser::GetByID($arSalon["PROPERTY_USER_VALUE"]);
            $arUser = $rsUser->Fetch();
            $LOGIN = $arUser["LOGIN"];
        }
    }



    global $DB, $APPLICATION;

    $arParams = array(
        "LOGIN" => $LOGIN,
        "EMAIL" => $EMAIL,
        "SITE_ID" => $SITE_ID
    );

    $result_message = array("MESSAGE"=>GetMessage('ACCOUNT_INFO_SENT')."<br>", "TYPE"=>"OK");
    $APPLICATION->ResetException();
    $bOk = true;
    foreach(GetModuleEvents("main", "OnBeforeUserSendPassword", true) as $arEvent)
    {
        if(ExecuteModuleEventEx($arEvent, array(&$arParams))===false)
        {
            if($err = $APPLICATION->GetException())
                $result_message = array("MESSAGE"=>$err->GetString()."<br>", "TYPE"=>"ERROR");

            $bOk = false;
            break;
        }
    }

    if($bOk)
    {
        $f = false;
        if($arParams["LOGIN"] <> '' || $arParams["EMAIL"] <> '')
        {
            $confirmation = (COption::GetOptionString("main", "new_user_registration_email_confirmation", "N") == "Y");

            $strSql = "";
            if($arParams["LOGIN"] <> '')
            {
                $strSql =
                    "SELECT ID, LID, ACTIVE, CONFIRM_CODE, LOGIN, EMAIL, NAME, LAST_NAME ".
                    "FROM b_user u ".
                    "WHERE LOGIN='".$DB->ForSQL($arParams["LOGIN"])."' ".
                    "	AND (ACTIVE='Y' OR NOT(CONFIRM_CODE IS NULL OR CONFIRM_CODE='')) ".
                    "	AND (EXTERNAL_AUTH_ID IS NULL OR EXTERNAL_AUTH_ID='') ";
            }
            if($arParams["EMAIL"] <> '')
            {
                if($strSql <> '')
                {
                    $strSql .= "\nUNION\n";
                }
                $strSql .=
                    "SELECT ID, LID, ACTIVE, CONFIRM_CODE, LOGIN, EMAIL, NAME, LAST_NAME ".
                    "FROM b_user u ".
                    "WHERE EMAIL='".$DB->ForSQL($arParams["EMAIL"])."' ".
                    "	AND (ACTIVE='Y' OR NOT(CONFIRM_CODE IS NULL OR CONFIRM_CODE='')) ".
                    "	AND (EXTERNAL_AUTH_ID IS NULL OR EXTERNAL_AUTH_ID='') ";
            }
            $res = $DB->Query($strSql);

            while($arUser = $res->Fetch())
            {

                if($arParams["SITE_ID"]===false)
                {
                    if(defined("ADMIN_SECTION") && ADMIN_SECTION===true)
                        $arParams["SITE_ID"] = CSite::GetDefSite($arUser["LID"]);
                    else
                        $arParams["SITE_ID"] = SITE_ID;
                }

                if($arUser["ACTIVE"] == "Y")
                {
echo '1';
                    echo "<pre>";
                    print_r($arUser);
                    echo "</pre>";

                  //  CUser::SendUserInfo($arUser["ID"], $arParams["SITE_ID"], GetMessage("INFO_REQ"), true, 'USER_PASS_REQUEST');
                    $f = true;
                }
                elseif($confirmation)
                {
                    //unconfirmed registration - resend confirmation email
                    $arFields = array(
                        "USER_ID" => $arUser["ID"],
                        "LOGIN" => $arUser["LOGIN"],
                        "EMAIL" => $arUser["EMAIL"],
                        "NAME" => $arUser["NAME"],
                        "LAST_NAME" => $arUser["LAST_NAME"],
                        "CONFIRM_CODE" => $arUser["CONFIRM_CODE"],
                        "USER_IP" => $_SERVER["REMOTE_ADDR"],
                        "USER_HOST" => @gethostbyaddr($_SERVER["REMOTE_ADDR"]),
                    );

                    $event = new CEvent;

                    echo "<pre>";
                    print_r($arFields);
                    echo "</pre>";
                   // $event->SendImmediate("NEW_USER_CONFIRM", $arParams["SITE_ID"], $arFields);

                    $result_message = array("MESSAGE"=>GetMessage("MAIN_SEND_PASS_CONFIRM")."<br>", "TYPE"=>"OK");
                    $f = true;
                }

                if(COption::GetOptionString("main", "event_log_password_request", "N") === "Y")
                {
                    CEventLog::Log("SECURITY", "USER_INFO", "main", $arUser["ID"]);
                }
            }
        }
        if(!$f)
        {
            return array("MESSAGE"=>GetMessage('DATA_NOT_FOUND')."<br>", "TYPE"=>"ERROR");
        }
    }
    return $result_message;
}
SendPassword("8 917 777 88 50","8 917 777 88 50");
*/