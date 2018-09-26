<?

include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");

?> 
<h1>Страница не&nbsp;найдена</h1>
 
<h2>Почему это могло произойти? 
  <br />
 
  <br />
 </h2>
 
<p>&nbsp;&mdash; Вы&nbsp;ошиблись при наборе ссылки, или перешли по&nbsp;неправильной ссылке. </p>
 
<p>&nbsp;&mdash; Владелец салона удалил информацию о&nbsp;салоне. </p>
 
<p>&nbsp;&mdash; Владелец салона удалил информацию о&nbsp;<nobr>девушке-массажистке</nobr>. 
  <br />
 </p>
 
<p>&mdash;&nbsp;Страница была удалена администрацией сайта.</p>
 
<p> 
  <br />
 </p>
 
<p>Попробуйте вернуться на&nbsp;<a href="/" >главную страницу</a> сайта и&nbsp;найти интересующую вас информацию. </p>

<p>
  <br />
</p>

<p>
  <br />
 </p>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>