<?

include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("�������� �� �������");

?> 
<h1>�������� ��&nbsp;�������</h1>
 
<h2>������ ��� ����� ���������? 
  <br />
 
  <br />
 </h2>
 
<p>&nbsp;&mdash; ��&nbsp;�������� ��� ������ ������, ��� ������� ��&nbsp;������������ ������. </p>
 
<p>&nbsp;&mdash; �������� ������ ������ ���������� �&nbsp;������. </p>
 
<p>&nbsp;&mdash; �������� ������ ������ ���������� �&nbsp;<nobr>�������-�����������</nobr>. 
  <br />
 </p>
 
<p>&mdash;&nbsp;�������� ���� ������� �������������� �����.</p>
 
<p> 
  <br />
 </p>
 
<p>���������� ��������� ��&nbsp;<a href="/" >������� ��������</a> ����� �&nbsp;����� ������������ ��� ����������.�</p>

<p>
  <br />
</p>

<p>
  <br />
 </p>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>