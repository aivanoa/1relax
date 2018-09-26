<?
	if(empty($salonID)) {
		$salonID = $arResult['ID'];
	}
$salonData = array(
		'ID' => 0,
		'IBLOCK_ID' => 0,
		'ACTIVE' => 'N',
		'NAME' => '',
		'PREVIEW_TEXT' => '',
		'PREVIEW_PICTURE' => '',
		'PROPERTIES' => array(
			'SUMM' => 0,
			'CLICK' => 0,
			'SORT' => 0,
			'PLACE' => 0,
			'PHONE' => '',
			'CITY' => 0,
			'U_POSITION_COUNT' => 0,
			'ADDRESS' => '',
			'WWW' => '',
			'REKLAMA_OFF' => '',
			'PHONEAUTHCHECK' => '',
			'PHONEAUTH' => '',
			'ACTIVE_ADMINISTRATOR' => false
		)
	);
	
	$resS = CIBlockElement::GetList(array(), array('ID' => $salonID), false, false, array('ID', 'IBLOCK_ID', 'ACTIVE', 'NAME', 'PREVIEW_TEXT', 'PREVIEW_PICTURE', 'PROPERTY_CITY', 'PROPERTY_SUMM', 'PROPERTY_CLICK', 'PROPERTY_U_POSITION_COUNT', 'PROPERTY_SORT', 'PROPERTY_PHONE', 'PROPERTY_ADRESS', 'PROPERTY_WWW', 'PROPERTY_REKLAMA_OFF', 'PROPERTY_PHONEAUTHCHECK', 'PROPERTY_PHONEAUTH', 'PROPERTY_ACTIVE_ADMINISTRATOR'));
	if($lotS = $resS->Fetch()) {
		
		$salonData = array(
			'ID' => $lotS['ID'],
			'IBLOCK_ID' => $lotS['IBLOCK_ID'],
			'ACTIVE' => $lotS['ACTIVE'],
			'NAME' => $lotS['NAME'],
			'PREVIEW_TEXT' => $lotS['PREVIEW_TEXT'],
			'PREVIEW_PICTURE' => !empty($lotS['PREVIEW_PICTURE']) ? CFile::GetPath($lotS['PREVIEW_PICTURE']) : '',
			'PROPERTIES' => array(
				'SUMM' => (int)$lotS['PROPERTY_SUMM_VALUE'],
				'CLICK' => (int)$lotS['PROPERTY_CLICK_VALUE'],
				'SORT' => (int)$lotS['PROPERTY_SORT_VALUE'],
				'PLACE' => 0,
				'PHONE' => $lotS['PROPERTY_PHONE_VALUE'],
				'CITY' => $lotS['PROPERTY_CITY_VALUE'],
				'ADDRESS' => $lotS['PROPERTY_ADRESS_VALUE'],
				'WWW' => $lotS['PROPERTY_WWW_VALUE'],
				'U_POSITION_COUNT' => $lotS['PROPERTY_U_POSITION_COUNT_VALUE'],
				'REKLAMA_OFF' => $lotS['PROPERTY_REKLAMA_OFF_ENUM_ID'],
				'PHONEAUTHCHECK' => $lotS['PROPERTY_PHONEAUTHCHECK_VALUE'],
				'PHONEAUTH' => $lotS['PROPERTY_PHONEAUTH_VALUE'],
				'ACTIVE_ADMINISTRATOR' => !empty($lotS['PROPERTY_ACTIVE_ADMINISTRATOR_VALUE'])
			)
		);
	}
//��������
$showElement = 0;
$showPanel = 0;
if($arResult["ACTIVE"] == "Y")
	$showElement = 1;
if($arResult["ACTIVE"] == "N" && isset($GLOBALS["arSalon"]["ID"]) && $GLOBALS["arSalon"]["ID"] == $arResult["ID"])
	$showElement = 1;	
if(isset($GLOBALS["arSalon"]["ID"]) && $GLOBALS["arSalon"]["ID"] == $arResult["ID"])
	$showPanel = 1;

//�������� ���������� � ������� ��������
$arFilter["PROPERTY_SALON"] = $arResult["ID"];
if(!$showPanel)
	$arFilter["ACTIVE"] = "Y";	
//�������
$arFilter["IBLOCK_ID"] = 3;	
$girlsCount = CIBlockElement::GetList(false, $arFilter, Array());
//�������
$arFilter["IBLOCK_ID"] = 6;	
$newsCount = CIBlockElement::GetList(false, $arFilter, Array());
//�����������
$arFilter["IBLOCK_ID"] = 4;	
$commentsCount = CIBlockElement::GetList(false, $arFilter, Array());


$maxClickRes = CIBlockElement::GetList(array("PROPERTY_CLICK"=>"DESC"), array("ACTIVE"=>"Y","IBLOCK_ID"=>1,"!ID"=>$arResult["ID"],"PROPERTY_CITY"=>$GLOBALS["arCity"]["ID"],"<=PROPERTY_CLICK"=>$arResult["PROPERTY_58"]), false,false,array("PROPERTY_CLICK"))->Fetch();
$maxClick = $maxClickRes["PROPERTY_CLICK_VALUE"];
if(!$maxClick)
    $maxClick=4;
else
    $maxClick++;
?>

<?if($showElement):?>

	<?//������ ��������� �������� - � ���� <RIGHT>, ����� ����� ��������� �������������� ����� � ��������� ���������� �������?>
	
	<?
	//������ ��������
	//echo "<pre>"; print_r(123123);echo "</pre>";
	$SUMM = intVal($arResult["DISPLAY_PROPERTIES"]["SUMM"]["DISPLAY_VALUE"]);
	$CLICK = intVal($arResult["DISPLAY_PROPERTIES"]["CLICK"]["DISPLAY_VALUE"]);
	$SORT = intVal($arResult["DISPLAY_PROPERTIES"]["SORT"]["DISPLAY_VALUE"]);

	//����� ������ � ������
	$arFilter = Array("IBLOCK_ID"=>"1", "ACTIVE"=>"Y", "PROPERTY_CITY"=>$GLOBALS["arCity"]["ID"], ">=PROPERTY_SORT"=>$SORT);
	$PLACE = intVal(CIBlockElement::GetList(false, $arFilter, array()));

	//������ 5-20 �������
	$arSelect = Array("ID", "IBLOCK_ID", "PROPERTY_CLICK", "PROPERTY_SORT", "PROPERTY_SUMM");
	$arFilter = Array("IBLOCK_ID"=>"1", "ACTIVE"=>"Y", "PROPERTY_CITY"=>$GLOBALS["arCity"]["ID"]);
	$result = CIBlockElement::GetList(array("PROPERTY_SORT"=>"DESC"), $arFilter, false, array("nPageSize"=>20), $arSelect);
	$i = 1;
	$currentClick = DEFAULT_CLICK_VALUE;
	while($arFields = $result->GetNext())
	{
		if($arFields["PROPERTY_SUMM_VALUE"] >= $arFields["PROPERTY_CLICK_VALUE"])
		{
			$currentClick = $arFields["PROPERTY_CLICK_VALUE"];
		}
		if($i==1)//������ �����
			$place1 = intval($currentClick)+1;
		if($i==5)//����� �����
			$place5 = intval($currentClick)+1;
		if($i==20)//��������� �����
			$place20 = intval($currentClick)+1;
		$i++;
	}

    $arrFilterStat = array(
        "PROPERTY_SALON" => $arResult["ID"],
        "IBLOCK_ID" => 9,
        "><DATE_CREATE" => array(
            date($DB->DateFormatToPHP(CLang::GetDateFormat()), mktime(0,0,0,date("m"),date("d"),date("Y"))),
            date($DB->DateFormatToPHP(CLang::GetDateFormat()), mktime(0,0,0,date("m"),date("d")+1,date("Y")))
        ),

    );

    $resultStat = CIBlockElement::GetList(array(), $arrFilterStat, array(), false);



	?>

<div class="salon-info-line">
			<div class="container">
			<div class="info-line_right">
				������:   <?       if($arResult["PROPERTIES"]["ACTIVE_ADMINISTRATOR"]["VALUE"]!=""):?><span class="inactive">�� �������<?else:?>
				<span class="active">
       �������
    <?endif;?></span>
				</div>
				<div class="info-line_left">
					<a href="/personal/salon/" class="info-line_info ">
						���������� � ������
					</a>
					<a href="/personal/promo/" class="info-line_advertise active">
						������� �� �����
					</a>
				</div>
				
			</div><!-- end container -->
</div><!-- end salon-info-line -->
  <??>

 
<section class="enter-block lk-1">
			<div class="container">
				<!-- <p class="notice-msg">
					������������ ������� �� ��������� � ������ �������� ��������, ������ � ������
				</p> -->
				<?if($arResult["ACTIVE"] == "N"):?>
				<p class="warn-msg">
					<span>��������!</span> ������ ����� <span>�� �������</span> (����������� �����������) � �� �������� ��� ��������� ������ �������������.
				</p>

					<?endif?>
			</div>
				<div class="lk-wrap">
				<div class="container">
				<div class="lk-wrap_aside">
				<div class="adv-company <?if($SUMM>0 && $SUMM>=$CLICK):?> active <?else:?> inactive <?endif?>">
							<span>
								��������� ��������
							</span>

					<?if($SUMM>0 && $SUMM>=$CLICK && $arResult["PROPERTY_76"]==8):?>
	    		
							<span class="status-adv">
								��������������
							</span>
					
		<?elseif($SUMM>0 && $SUMM>=$CLICK):?>
			
							<span class="status-adv">
								�������
							</span>
						
		<?else:?>
			
							<span class="status-adv">
								���������
							</span>
					
		<?endif;?>
<?//var_dump($arResult['ID'])?>
			<div class="control-block" action='<?if($SUMM>0 && $SUMM>=$CLICK):?> off <?else:?> on <?endif?>'>
								<i class="fa fa-play <?if($SUMM>0 && $SUMM>=$CLICK):?> inactive <?else:?> active <?endif?>" style="cursor: pointer;" aria-hidden="true"></i>
								<i class="fa fa-pause <?if($SUMM>0 && $SUMM>=$CLICK):?> active <?else:?> inactive <?endif?>" style="cursor: pointer;"  aria-hidden="true"></i>
							</div>
							<div class="count-view <?if($SUMM>0 && $SUMM>=$CLICK):?> active <?else:?> inactive <?endif?>" >
								������� �������: <span><?=$resultStat?></span>
							</div>
						</div>
					

	
		<script>
		
			$(function(){
				$(".control-block").click(function(){
					var action = $(this).attr("action");
					$.ajax({
						type: "POST",
						url: "/ajax/pauseRK.php",
						data: {action:action,salon:"<?=$arResult["ID"]?>"},
						success: function (result){
							console.log(result);
							if(action=="on")
							{
								$(".adv-company").removeClass("inactive");
								$(".adv-company").addClass("active");
								$(".fa-play").removeClass('active');
								$(".fa-play").addClass('inactive');
								$(".fa-pause").removeClass('inactive');
								$('.fa-pause').addClass('active');
								$(".status-adv").text("�������");
								$(".control-block").attr('action','off');
								$(".count-view").addClass('active');
							}
							else
							{
								$(".adv-company").addClass("inactive");
								$(".adv-company").removeClass("active");
									$(".fa-play").removeClass('inactive');
								$(".fa-play").addClass('active');
								$('.fa-pause').removeClass('active');
								$('.fa-pause').addClass('inactive');
								$(".status-adv").text("���������");
									$(".count-view").removeClass('active');
									$(".control-block").attr('action','on');
							}
						}
					});
				
				});
			
			
			});
			
		</script>
		<?/*
		<div class="title">����������</div>
		<div class="stat">
			�� �����: 12 / 120 ���.<br />
			�� ������: 120 / 1200 ���.<br />
			�� �����: 1200 / 12000 ���.<br />
			�����: 12000 / 120000 ���.
		</div>
		*/?>
<?//var_dump($salonData['PROPERTIES']);
							/*?><span style="display:none;"><?var_dump ($salonData);?></span><?*/
							$b=1;
							//echo($salonData['PROPERTIES']['REKLAMA_OFF']);
							$arFilter = Array("IBLOCK_ID"=>1, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
							$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), Array());
							$stack = array();
							while($ob = $res->GetNextElement())
							{
								$arFields = $ob->GetFields();
								$arProps = $ob->GetProperties();
								//echo $arFields['NAME'];
								//print_r($arProps);
								//echo $salonData['PROPERTIES']['CITY'];								
								if($salonData['PROPERTIES']['REKLAMA_OFF']!=8){
									if($arProps['REKLAMA_OFF']['VALUE']!="Y"){
										if($arFields['ID']!=$salonData['ID']){
											if($arProps['CITY']['VALUE']==$salonData['PROPERTIES']['CITY']){												
												//if($arProps['U_POSITION_COUNT']['VALUE']!=""){
													//if($salonData['PROPERTIES']['U_POSITION_COUNT'] == $arProps['U_POSITION_COUNT']['VALUE']){
													if($arProps['SUMM']['VALUE'] > $arProps['CLICK']['VALUE']){														
														if($salonData['PROPERTIES']['CLICK'] < $arProps['CLICK']['VALUE']){
															$b++;
															//array_push($stack, $arProps['CLICK']['VALUE']);
															//echo $arProps['CLICK']['VALUE'].' - '.$arFields['NAME'].'<BR/>';
														}elseif($salonData['PROPERTIES']['CLICK'] == $arProps['CLICK']['VALUE']){
															if($salonData['PROPERTIES']['SUMM'] < $arProps['SUMM']['VALUE']){
																$b++;																
																//echo '������� 2<BR/>';
															}
															array_push($stack, $arProps['CLICK']['VALUE']);
															/*echo $arFields['NAME'].' - ';
															echo $arProps['SUMM']['VALUE'].' - ';
															echo $arProps['CLICK']['VALUE'].'<BR/>';*/
														}
														else{array_push($stack, $arProps['CLICK']['VALUE']);}
													}
												//}
											}
										}
									}
								}else{									
									if($arProps['CITY']['VALUE']==$salonData['PROPERTIES']['CITY']){
										array_push($stack, $arProps['CLICK']['VALUE']);
										if($arProps['REKLAMA_OFF']['VALUE']!="Y"){
											if($arProps['SUMM']['VALUE'] > $arProps['CLICK']['VALUE']){
											$b++;
											/*echo $arFields['NAME'].' - ';
											echo $arProps['SUMM']['VALUE'].' - ';
											echo $arProps['REKLAMA_OFF']['VALUE'].' - ';
											echo $arProps['CLICK']['VALUE'].'<BR/>';*/
											}
										}else{										
											if($arFields['ID']!=$salonData['ID']){
												//if($arProps['U_POSITION_COUNT']['VALUE']!=""){
													//if($salonData['PROPERTIES']['U_POSITION_COUNT'] == $arProps['U_POSITION_COUNT']['VALUE']){
													if($arProps['SUMM']['VALUE'] > $arProps['CLICK']['VALUE']){
														if($salonData['PROPERTIES']['CLICK'] < $arProps['CLICK']['VALUE']){
															$b++;
															//array_push($stack, $arProps['CLICK']['VALUE']);
															//echo $arProps['CLICK']['VALUE'].' - '.$arFields['NAME'].'<BR/>';
														}elseif($salonData['PROPERTIES']['CLICK'] == $arProps['CLICK']['VALUE']){
															if($salonData['PROPERTIES']['SUMM'] < $arProps['SUMM']['VALUE']){
																$b++;																
																//echo '������� 2<BR/>';
															}
															array_push($stack, $arProps['CLICK']['VALUE']);
															/*echo $arFields['NAME'].' - ';
															echo $arProps['SUMM']['VALUE'].' - ';
															echo $arProps['CLICK']['VALUE'].'<BR/>';*/
														}else{array_push($stack, $arProps['CLICK']['VALUE']);}
													}
												//}
											}
										}
									}
								}
								/*if($b==1) print_r($arProps);
								$b++;	*/							
							}//echo $salonData['PROPERTIES']['CLICK'];
							?> 
						<div class="lk-wrap_aside__salon">
							<div class="aside_salon__item">
								��� ����� ��������:
								<div class="place">
								<span class="num" > <?php echo $b; ?> </span><span>�����</span>
								</div>
							</div>
							<div class="aside_salon__item">
								������� �������:
								<div class="place">
								<span><?=$SUMM?></span><span>���.</span>
								</div>
								<a href="<? $_SERVER[HTTP_HOST]; ?>/personal/promo/?type=payment" class="add-money">���������</a>
								<a href="<? $_SERVER[HTTP_HOST]; ?>/personal/promo/?type=history" class="history">
									������� ����������
								</a>
							</div>
						</div>
						<div class="lk_rate">
							<div class="lk_rate_item rate-block">
								������
								 <form action="" method="">
								 	<input id="rateValue" type="text" value="<?=$CLICK?>" data-current="<?=$CLICK?>" name="rateValue" placeholder="4">
								 	<a href="/ajax/ajaxSaveRate.php?salon=<?=$arResult["ID"]?>" title="��������� ������" class="hide saveRate">���������</a>
								 </form>
								 <script type="text/javascript">
									$(document).ready(function() {
										$('body').on('click','.saveRate',function(){
											var href=$(this).attr('href');
											var rate = $("#rateValue").val();
											$.ajax({
												url: href,
												type: 'POST',
												 dataType: 'json',
												data: {'rate': rate},
											})
											.done(function(response) {
													
												if( !response.error){
													$('.place .num').html(response.place);
													$('.lk_rate_item .rate').html(response.click);
												}
												
												if(response.active == 1)
												{
													$(".adv-company").removeClass("inactive");
													$(".adv-company").addClass("active");
													$(".fa-play").removeClass('active');
													$(".fa-play").addClass('inactive');
													$(".fa-pause").removeClass('inactive');
													$('.fa-pause').addClass('active');
													$(".status-adv").text("�������");
													$(".control-block").attr('action','off');
													$(".count-view").addClass('active');
												}
												else
												{
													$(".adv-company").addClass("inactive");
													$(".adv-company").removeClass("active");
													$(".fa-play").removeClass('inactive');
													$(".fa-play").addClass('active');
													$('.fa-pause').removeClass('active');
													$('.fa-pause').addClass('inactive');
													$(".status-adv").text("���������");
													$(".count-view").removeClass('active');
													$(".control-block").attr('action','on');
												}
												
												if(response.error){
													alert(response.out);
												}
											})
											.fail(function() {
											})
											.always(function() {
											});
											
											return false;
										});
									});

								</script>
								 ���.
							</div>
							<div class="lk_rate_item">
								���������� ������ <span class="rate"><?$temp=max($stack);echo $temp+1;?></span> ���. <a href="#actual" id='title_for_first_link'>��� ��� �����?</a>
								<script>
									$(document).ready(function() {
										$('body').on('mouseover', 'a#title_for_first_link', function(event) {
											event.preventDefault();

											$("div#title_for_first_link").show();
											return false;
										});
										$('body').on('mouseleave', 'a#title_for_first_link', function(event) {
											event.preventDefault();
											$("div#title_for_first_link").hide();
											return false;
										});

									});
								</script>
								  <div id="title_for_first_link" class="titleV" style="display: none;">

                <u>���������� ������</u> - ��� ���������, ������� ����������� �� ����� ������ �� ���� �������.
                ����, � �������, � ���������� ���������� ����� ������ 4 ���., � � ������ ������ 20 ���.,
                �� <u>���������� ������</u> ��� ��� ����� 5 ���. ������� � ����� ������ ��� ��� ���� �������.
                <img src="<?=SITE_TEMPLATE_PATH?>/images/chat.png" class="chatPng">
            </div>
							</div>
							<div class="lk_rate_item">
								�� ������ ���������� ����� ������ (����� ����� �� 4 ���.)
							</div>
						</div>
					</div>


            <script>
                $(document).ready(function(){

                    // ��� ��������� �� ������
                    $(".link_test").mouseover
                    (function(){

                        // �������� ID �����, ������� ����� ��������
                        var title = $(this).attr("title2");

                        // ���������� ����

                        $(title).fadeIn();
                    });

                    // ��� ����� ����� �� ������
                    $(".link_test").mouseout
                    (function(){

                        // �������� ID �����, ������� ����� ��������
                        var title = $(this).attr("title2");

                        // �������� ����
                        $(title).fadeOut();

                    });
                });


            </script>
<?endif?>

<?//����� ��������� ��������?>

<?if(isset($_REQUEST["strIMessage"])):?>
	

<p class="notetext"><?=$_REQUEST["strIMessage"]?></p>
<?endif;?>

<?if($showPanel):?>

	
	<?//��������?>
<?/*
<p class="usermenu">
� ����� ������������ ������� �<?=$arResult["FIELDS"]["NAME"]?>�. 
</p>
*/?>

<?endif?>

<?if($showElement):?>
<div class="lk-wrap_content">
	<div class="lk_tabs adv_tabs">

	<?$URL = parse_url($_SERVER["REQUEST_URI"])?>
	<?$URL["path"] = str_replace("index.php", "", $URL["path"])?>

	<?if($URL["path"]=="/personal/promo/"):?>
		<input id="adv_lk1" type="radio" name="tabs" <?php if (!isset($_GET['type'])){?> checked <? } ?> >
		<label for="adv_lk1">�������� �������</label>
	<?else:?>
		<input id="adv_lk1" type="radio" name="tabs">
		<label for="adv_lk1">�������� �������</label>
	<?endif;?>

	<?if($SUMM>0 && $SUMM>=$CLICK):?>
	<input id="adv_lk2" type="radio" name="tabs">
	<label for="adv_lk2">���������� �� ������</label>
	<?else:?><?endif;?>
	<input id="adv_lk3" type="radio" name="tabs" <?php if (isset($_GET['type']) && $_GET['type']=='payment'){?> checked <? } ?>>
	<label for="adv_lk3">��������� ������ </label>
	<input id="adv_lk4" type="radio" name="tabs">
	<label for="adv_lk4">������ �������</label>
	<input id="adv_lk5" type="radio" name="tabs">
	<label for="adv_lk5">��������� </label>
	<input id="adv_lk6" type="radio" name="tabs" <?php if (isset($_GET['type']) && $_GET['type']=='history'){?> checked <? } ?>>
	<label for="adv_lk6">������� ����������</label>
<style>
.b-menu li{
padding: 0 14px!important;
}
</style>
<?endif?>