<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
// ������������ ������ ����, �.�. ������ �� ���������� $_SERVER
// ������ ���������� ���������� �������� ������ �� ����

// �������, ������������ ����������� ���������� ������, ���������� ����
// � � ������� ����� ������������ �������� ������������� � ������������� � ����

// ����� �������, ��������������, ��� �� ����� ������������ ��������� �� �������� ����� � ������� ����, � ����� ��� �������
// � �� ������ �� ���������� ����� �� ������, �������, �� ���������� � �.�. 

// ���� �� �������� ���� ��� ���� ������
CModule::IncludeModule("iblock");
if(isset($_REQUEST["s"]))
{
    if($_REQUEST["s"]!="")
    {
        echo "===1";
	$ip = $_SERVER['REMOTE_ADDR'];
    // $ip_data = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
	       $ip_data = json_decode(file_get_contents("http://api.sypexgeo.net/ajh71/json/{$ip}"));
    	if ( isset($ip_data->country->iso) && $ip_data->country->iso != 'RU' )
    	{	
		  echo "0";exit;
        }

        // �������� ���������� "s" (session)
        $S_REQUEST = $_REQUEST["s"];

        global $APPLICATION;
        $S_COOKIE = $APPLICATION->get_cookie("PROMO");

        // ���������� ������ �� $_REQUEST � ������ �� $_COOKIE
        if($S_REQUEST==$S_COOKIE)
        {
            echo "===2";
            // ������ ������� �������, �� ������, ���� ������ �� ����� �������
            $BALANCE = 0;
            $CLICK = 0;

            // �������� ������ ������ �� ����������� ����
            $arSelect = Array("ID", "IBLOCK_ID", "NAME","PROPERTY_SUMM", "PROPERTY_CLICK", "PROPERTY_USER","PROPERTY_SORT","PROPERTY_CITY", "PROPERTY_USER", "PROPERTY_U_POSITION_DOWN");
            $arFilter = Array("IBLOCK_ID"=>1, "CODE"=>$_REQUEST["ELEMENT_CODE"]);
            $result = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
            if($arFields = $result->GetNext())
            {
				$rsk = CIBlockElement::GetList(Array("PROPERTY_SORT"=>"DESC"), array("IBLOCK_ID"=>1,"<PROPERTY_SORT"=>$arFields["PROPERTY_SORT_VALUE"]), false, Array("nPageSize"=>1), $arSelect);
				$arRsk = $rsk->GetNext();
                $rsk = CIBlockElement::GetList(Array("PROPERTY_SORT"=>"DESC"), array("IBLOCK_ID"=>1,">PROPERTY_SORT"=>$arFields["PROPERTY_SORT_VALUE"]), false, Array("nPageSize"=>1), $arSelect);
                $arRsk2 = $rsk->GetNext();

                $BALANCE = intval($arFields["PROPERTY_SUMM_VALUE"]);
                $CLICK = intval($arFields["PROPERTY_CLICK_VALUE"]);
                $USER_ID = intval($arFields["PROPERTY_USER_VALUE"]);
                $SALON = intval($arFields["ID"]);


            }

            if($CLICK>0)
            {
                $maxClickRes = CIBlockElement::GetList(array("PROPERTY_CLICK"=>"DESC"), array("ACTIVE"=>"Y","IBLOCK_ID"=>1,"!ID"=>$arFields["ID"],"PROPERTY_CITY"=>$arFields["PROPERTY_CITY_VALUE"],"<PROPERTY_CLICK"=>$CLICK), false,false,array("PROPERTY_CLICK"))->Fetch();
                $CLICK2 = $maxClickRes["PROPERTY_CLICK_VALUE"];
                if(!$CLICK2)
                    $CLICK2=4;
                else
                    $CLICK2++;
            }


            // ���� ������ ������ � ������ ��������� �������� ��������
            if($CLICK>0 && ($BALANCE-$CLICK2)>=0)
            {



                echo "===3";
                // ���������� IP
                $IP = "";
                if (!empty($_SERVER['HTTP_CLIENT_IP']))
                    $IP = $_SERVER['HTTP_CLIENT_IP'];
                elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                    $IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
                else
                    $IP = $_SERVER['REMOTE_ADDR'];

                // ������������� ���� �� ���������, ����������� ���������� ��������
                $spendDo = 1;

                // ���������, ���� ������������ �����������, �� ��� �������� ��� ���������, �� ���������
                if($USER->IsAuthorized())
                    $spendDo = 0;
                else
                {
                    echo "===4";
                    // ���������, �������� �� ������ ������ ��� IP � ������� ������ �� ��������� ����� (2 ����)
                    $arSpendFilter = Array(
                        "IBLOCK_ID"=>9,
                        "PROPERTY_SALON"=>$SALON,
                        ">DATE_CREATE"=>date($DB->DateFormatToPHP(CLang::GetDateFormat()), (time()-2*3600)),
                        Array("LOGIC" => "OR",
                            array("=PROPERTY_SESSION" => $S_COOKIE),
                            array("=PROPERTY_IP" => $IP),
                        ),
                    );
                    $spendCount = CIBlockElement::GetList(false, $arSpendFilter, Array());

echo " - speedcount=".$spendCount." ";
                    if($spendCount>0)
                        $spendDo = 0;

                }

                if($spendDo)
                {
                    // ��������� ��������
                    $el = new CIBlockElement;
                    $arLoadProductArray = Array(
                        "IBLOCK_ID"      => 9,
                        "NAME"           => "����",
                        "ACTIVE"         => "Y",
                        "PROPERTY_VALUES"=> array(
                            "46" => $CLICK,
                            "47" => $USER_ID,
                            "48" => $SALON,
                            "49" => array("VALUE" => 4),
                            "50" => $IP,
                            "55" => $S_COOKIE,
                            "56" => $_SERVER["HTTP_USER_AGENT"],
                            "111" => $_REQUEST['CITY'],
                            "112" => $_REQUEST['UTM'] ? $_REQUEST['UTM'] : null,
                        ),
                    );

                    if($SPENDING = $el->Add($arLoadProductArray))
                    {
                        echo "-���� ��������-";
                        // ��������� ������ ������ �� ������
                        CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], ($BALANCE-$CLICK2), "SUMM");

                        // ���� ��������� �������� ��������, ������������� ���� ����� ����������, � ������ �����
                        if(($BALANCE-$CLICK2*2)>=0)
                        {
                            // ������������� ���������� ������
                            // ���������� ������������� �� �������
                            // ������*10000000000+������*100000+ID ������������
                            // ��� ���� ����� ��������� ������ � ���������� �����������
                            // ����� ����� ���� ����� ���������� ����� ������
                            $NEW_SORT = $CLICK*10000000000 + ($BALANCE-$CLICK)*100000 + $arFields["ID"];
                        }
                        else
                        {
                            // ���� ��������� �������� ����������, ������������� ������ ����� ����������, ��� ����� �����
                            // ������������� ���������� ������
                            // ���������� ������������� �� �������
                            // ������*100000+ID ������������
                            // ��� ���� ����� ��������� ������ � ���������� �����������
                            // ����� ����� ���� ����� ���������� ����� ������
                            $NEW_SORT = ($BALANCE-$CLICK)*100000 + $arFields["ID"];
                        }
                        // ������������� ����� ����������
                        CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $NEW_SORT, "SORT");
						



						
				

                    }
                    else
                    {
                        // ��������� �������������� ������
                        SendError($el->LAST_ERROR);
                    }
                }
            }
        }

    }
}
?>
