<?
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^/articles/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/articles/index.php",
	),
	array(
		"CONDITION" => "#^/comments/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/comments/index.php",
	),
	array(
		"CONDITION" => "#^/salons/(.+)/programms/.*#",
		"RULE" => "ELEMENT_CODE=\$1",
		"ID" => "",
		"PATH" => "/salons/programms.php",
	),
	array(
		"CONDITION" => "#^/salons/(.+)/comments/.*#",
		"RULE" => "ELEMENT_CODE=\$1",
		"ID" => "",
		"PATH" => "/salons/comments.php",
	),
	array(
		"CONDITION" => "#^/salons/(.+)/girl-(.+)*#",
		"RULE" => "ELEMENT_CODE=\$1&girl=\$2",
		"ID" => "",
		"PATH" => "/salons/salon.php",
	),
	array(
		"CONDITION" => "#^/personal/girls/(.+)/.*#",
		"RULE" => "ELEMENT_CODE=\$1",
		"ID" => "",
		"PATH" => "/personal/girls/girl.php",
	),
	array(
		"CONDITION" => "#^/girls/(.+)/comments/.*#",
		"RULE" => "ELEMENT_CODE=\$1",
		"ID" => "",
		"PATH" => "/girls/comments.php",
	),
	array(
		"CONDITION" => "#^/salons/(.+)/vacancy/.*#",
		"RULE" => "ELEMENT_CODE=\$1",
		"ID" => "",
		"PATH" => "/salons/vacancy.php",
	),
	array(
		"CONDITION" => "#^/salons/(.+)/girls/.*#",
		"RULE" => "ELEMENT_CODE=\$1",
		"ID" => "",
		"PATH" => "/salons/girls.php",
	),
	array(
		"CONDITION" => "#^/metro/([a-zA-Z_-]+)#",
		"RULE" => "METRO_CODE=\$1&IS_MAIN_PAGE_METRO=1&",
		"ID" => "",
		"PATH" => "./index.php",
	),
	array(
		"CONDITION" => "#^/salons/(.+)/news/.*#",
		"RULE" => "ELEMENT_CODE=\$1",
		"ID" => "",
		"PATH" => "/salons/news.php",
	),
	array(
		"CONDITION" => "#^/salons/(.+)/.*#",
		"RULE" => "ELEMENT_CODE=\$1",
		"ID" => "",
		"PATH" => "/salons/salon.php",
	),
	array(
		"CONDITION" => "#^/click/(.+)/.*#",
		"RULE" => "data=\$1",
		"ID" => "",
		"PATH" => "/click/index.php",
	),
	array(
		"CONDITION" => "#^/girls/(.+)/.*#",
		"RULE" => "ELEMENT_CODE=\$1",
		"ID" => "",
		"PATH" => "/girls/girl.php",
	),
	array(
		"CONDITION" => "#^/sitemap.xml*#",
		"RULE" => "ELEMENT_CODE=\$1",
		"ID" => "",
		"PATH" => "/sitemap.php",
	),
	array(
		"CONDITION" => "#([a-zA-Z_]+)/?#",
		"RULE" => "RAYON_CODE=\$1&IS_MAIN_PAGE_RAYON=1",
		"ID" => "",
		"PATH" => "./index.php",
	),
	array(
		"CONDITION" => "#^/vacancy/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/vacancy/index.php",
	),
	array(
		"CONDITION" => "#^/news/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/news/index.php",
	),
);

?>