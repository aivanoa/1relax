<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); 
CModule::IncludeModule('iblock');

$onPage = 12;
$page = $_POST['page']*1;




$arSalonsFilter = array(
	"IBLOCK_ID" => 1,
	"PROPERTY_CITY" => $GLOBALS["arCity"]['ID'],
	"ACTIVE" => 'Y',
	"ACTIVE_DATE" => 'Y',
	"!=PROPERTY_ACTIVE_ADMINISTRATOR" => "Y",
);


if( $_POST['data']['max'] > 0 ) $arSalonsFilter['<=PROPERTY_PRICE'] = $_POST['data']['max'];
if( $_POST['data']['min'] > 0 ) $arSalonsFilter['>=PROPERTY_PRICE'] = $_POST['data']['min'];


$arSalonSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_ACTIVE_ADMINISTRATOR");
$res = CIBlockElement::GetList(Array("PROPERTY_SORT"=>"DESC", 'PROPERTY_SUMM' => "DESC"), $arSalonsFilter, false, false, $arSalonSelect);
$EnabledSalons = array();
while($ob = $res->GetNextElement()){ 
	$arSalonFields = $ob->GetFields();  
	
	if ( $arSalonFields['PROPERTY_ACTIVE_ADMINISTRATOR_VALUE'] == 'Y' )
		continue;
	
	$EnabledSalons[] = $arSalonFields['ID'];	
}
	
if ( count($EnabledSalons) == 0 )
	$EnabledSalons[] ='-1';









if( $_POST['data']['age'] ){
	$age = explode(';', $_POST['data']['age']);
	$ageMax = $age[1];
	$ageMin = $age[0];
} 



$arFilter = array();
$arFilter['IBLOCK_ID'] = 3;
$arFilter['ACTIVE'] = "Y";
$arFilter['PROPERTY_SALON'] = $EnabledSalons;
$arFilter["PROPERTY_CITY"] = $GLOBALS["arCity"]['ID'];



if( $_POST['data']['check'] == 'true' ) $arFilter['PROPERTY_CHECK_FLAG_VALUE'] = "Y";

if( $ageMax ) $arFilter['<=PROPERTY_AGE'] = $ageMax;
if( $ageMin ) $arFilter['>=PROPERTY_AGE'] = $ageMin;

//Фильтр по девушкам для страницы избранное
if(preg_match('/favorites/', $_SERVER['HTTP_REFERER']))
	$arFilter["ID"] = Favorites::getGirls();



$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM","CODE","IBLOCK_ID", "PREVIEW_PICTURE");


$nav = array(
	'nPageSize' => $onPage,
	'iNumPage' => $page
);
$empty = false;
$result = array();
$res = CIBlockElement::GetList(Array("PROPERTY_PRIORITY"=>"DESC", "PROPERTY_SORT"=>"DESC", 'PROPERTY_SUMM' => "DESC"), $arFilter, false, $nav, $arSelect);
while($ob = $res->GetNextElement())
	$result[] = array_merge( $ob->GetFields(), $ob->GetProperties() );

/* Если ничего не найдено */
if ( !count($result) && $page == 1 ){
	$empty = true;
	
	$arFilter = array();
	$arFilter['IBLOCK_ID'] = 3;
	$arFilter['ACTIVE'] = "Y";
	$arFilter['PROPERTY_SALON'] = $EnabledSalons;
	$arFilter["PROPERTY_CITY"] = $GLOBALS["arCity"]['ID'];
	
	//Фильтр по девушкам для страницы избранное
	if(preg_match('/favorites/', $_SERVER['HTTP_REFERER']))
		$arFilter["ID"] = Favorites::getGirls();
	
	$res = CIBlockElement::GetList(Array("PROPERTY_PRIORITY"=>"DESC", "PROPERTY_SORT"=>"DESC", 'PROPERTY_SUMM' => "DESC"), $arFilter, false, $nav, $arSelect);
	while($ob = $res->GetNextElement())
		$result[] = array_merge( $ob->GetFields(), $ob->GetProperties() );
	
}

ob_start();


$more = false;
if ( $res->NavPageCount > $page )
	$more = true;

if($res->NavPageCount > 1 || $page==1)
foreach($result as $arItem) {
$salon =  CIBlockElement::GetByID($arItem["SALON"]["VALUE"])->GetNextElement();
$salon = array_merge($salon->GetFields(), $salon->GetProperties() );
$arItem["PREVIEW_PICTURE"] = CFile::GetFileArray($arItem["PREVIEW_PICTURE"]);
?>
    <div class="girl-page__item">
            <div class="girl-page__img">
                <a href="#" data-id="<?=$arItem["ID"]?>" class="add-to-favor js-girl_favorites <?if(Favorites::isExist($arItem["ID"])) print "active"?>">
                    <span class="favor-ico">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
                            <path d="M24.85,10.126c2.018-4.783,6.628-8.125,11.99-8.125c7.223,0,12.425,6.179,13.079,13.543
                            c0,0,0.353,1.828-0.424,5.119c-1.058,4.482-3.545,8.464-6.898,11.503L24.85,48L7.402,32.165c-3.353-3.038-5.84-7.021-6.898-11.503
                            c-0.777-3.291-0.424-5.119-0.424-5.119C0.734,8.179,5.936,2,13.159,2C18.522,2,22.832,5.343,24.85,10.126z"/>
                        </svg>
                    </span>
                    <span class="close-ico">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        viewBox="0 0 47.971 47.971" style="enable-background:new 0 0 47.971 47.971;" xml:space="preserve">
                            <g>
                                <path fill="#7f7f7f" d="M28.228,23.986L47.092,5.122c1.172-1.171,1.172-3.071,0-4.242c-1.172-1.172-3.07-1.172-4.242,0L23.986,19.744L5.121,0.88
                                c-1.172-1.172-3.07-1.172-4.242,0c-1.172,1.171-1.172,3.071,0,4.242l18.865,18.864L0.879,42.85c-1.172,1.171-1.172,3.071,0,4.242
                                C1.465,47.677,2.233,47.97,3,47.97s1.535-0.293,2.121-0.879l18.865-18.864L42.85,47.091c0.586,0.586,1.354,0.879,2.121,0.879
                                s1.535-0.293,2.121-0.879c1.172-1.171,1.172-3.071,0-4.242L28.228,23.986z"/>
                            </g>
                        </svg>
                    </span>
                </a>
				<? $img_title = "Массажистка {$arItem["NAME"]} – {$salon['PRICE']['VALUE']} р./час"; ?>
                <a href="/salons/<?=$salon["CODE"]?>/girl-<?=$arItem["ID"]?>/"  target="_blank">
                    <img src="<?=resizeImgCrop($arItem["PREVIEW_PICTURE"]["SRC"], 221, 331)?>" alt="<?=$img_title?>" title="<?=$img_title?>">

                    <?php if(!empty($arItem['CHECK_FLAG']['VALUE']) && $arItem['CHECK_FLAG']['VALUE'] == 'Y') { ?>
                        <span class="really-photo">
                            Настоящее<br> фото
                        </span>
                    <?php } ?>

                    <p class="girl-page__name">
                        <span><?=$arItem["NAME"]?></span>
                    </p>
                </a>
            </div>
            <div class="girl-page__data">
                <div class="girl-page__price">
                    <?=$salon['PRICE']['VALUE']?>р./час
                </div>
                <ul class="girl-page__param">
                    <li>
                        <span class="girl__key">Возраст</span>
                        <span class="girl__param"><?=$arItem['AGE']['VALUE']?></span>
                    </li>
                    <li>
                        <span class="girl__key">Грудь</span>
                        <span class="girl__param"><?=$arItem['SIZE']['VALUE']?></span>
                    </li>
                    <li>
                        <span class="girl__key">Рост</span>
                        <span class="girl__param"><?=$arItem['RISE']['VALUE']?>см</span>
                    </li>
                    <li>
                        <span class="girl__key">Вес</span>
                        <span class="girl__param"><?=$arItem['WEIGHT']['VALUE']?>кг</span>
                    </li>
                </ul>
                <ul class="girl-page__saloon">
                    <li>
                        <span class="saloon__key">Салон</span>
                        <span class="aloon__param">
                            <a href="/salons/<?=$salon['CODE']?>/"><?=$salon['NAME']?></a>
                        </span>
                    </li>
                    <li>
                        <span class="saloon__key">Адрес</span>
                        <span class="aloon__param">
                            <a href="/salons/<?=$salon['CODE']?>/#map" rel="nofollow" target="_blank"><?=$salon['ADRESS']['VALUE']?></a>
                        </span>
                    </li>
                </ul>
            </div>
            <!-- /.girl-page__data -->
        </div>
<?php }

$html = ob_get_contents(); 
ob_end_clean();


$res = array(
	'html' => $html,
	'more' => $more,
	'empty' => $empty,
	'nav' => $nav,
	'some' => $res->NavPageCount

);

echo \Bitrix\Main\Web\Json::encode( $res );
die();