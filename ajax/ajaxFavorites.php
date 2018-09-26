<? session_start();
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Срипт добавляет/удаляет в избранное
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/scripts/favorites.php"); 

$result = array(
	"status" => "error"
);

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST["id"]) && $_POST["id"])
{
	$id = (int)($_POST["id"]);
	
	$result = array(
		"status" => "ok",
		"type" => Favorites::set($id),
		"count" => Favorites::getCount()
	);
}

print json_encode($result);
