<?php
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); 

	$result = array();
	
	if(empty($_REQUEST['action']) || empty($_REQUEST['salon'])) {
		$result = array(
			'status' => 'error',
			'message' => 'wrong input data'
		);
	}
	else {
		global $USER;
		CModule::IncludeModule('iblock');
		$res = CIBlockElement::GetList(array(), array('ID' => (int)$_REQUEST['salon'], 'USER' => $USER->GetID()), false, false, array('ID', 'IBLOCK_ID', 'PROPERTY_SUMM', 'PROPERTY_CLICK'));
		if($salon = $res->Fetch()) {
			$result['status'] = 'ok';
			$result['is_active'] = $salon['PROPERTY_SUMM_VALUE'] > 0 && $salon['PROPERTY_SUMM_VALUE'] >= $salon['PROPERTY_CLICK_VALUE'] ? 1 : 0;
			if(trim($_REQUEST['action']) == 'off') {
				$act = 8;
				$result['is_pause'] = 1;
			}
			else {
				$act = false;
				$result['is_pause'] = 0;
			}
			CIBlockElement::SetPropertyValuesEx($salon['ID'], $salon['IBLOCK_ID'], array('REKLAMA_OFF' => $act));
			$result['action'] = $_REQUEST['action'];
			editIBlockSortGirlsBySalons($salon);
		}
		else {
			$result = array(
				'status' => 'error',
				'message' => 'access denied'
			);
		}
	}

	echo json_encode($result);
	die();
