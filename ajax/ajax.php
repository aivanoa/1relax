<?php
	require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
	
	$result = array();
	
	$result['task'] = !empty($_POST['task']) ? $_POST['task'] : '';
	switch($result['task']) {
		case 'auth_resend': {
			$userID = !empty($_POST['user']) ? $_POST['user'] : 0;
			$resU = CUser::GetByID($userID);
			if($lotU = $resU->Fetch()) {
				if($lotU['ACTIVE'] == 'N') {
					$password = randString(6);
					$confirm = randString(8);
					
					$arFields = array(
						'PASSWORD' => $password,
						'CONFIRM_PASSWORD' => $password,
						'CONFIRM_CODE' => $confirm
					);
					$cuser = new CUser;
					if($cuser->Update($lotU['ID'], $arFields)) {

					//$arResult = $USER->ChangePassword($lotU['LOGIN'], $lotU['CONFIRM_CODE'], $password, $password);
					//$result['cc'] = $lotU['CONFIRM_CODE'];
					//if($arResult['TYPE'] == 'OK') {
						$arSend = array(
							'USER_ID' => $lotU['ID'],
							'LOGIN' => $lotU['LOGIN'],
							'EMAIL' => $lotU['EMAIL'],
							'CONFIRM_CODE' => $confirm,
							'PASSWORD' => $password,
							'CITY' => $GLOBALS['arCity']['CODE'],
						);
						CEvent::SendImmediate('NEW_USER_CONFIRM', 's1', $arSend);
						$result['status'] = 'ok';
					}
					else {
						$result['status'] = 'error';
						$result['result'] = json_encode($cuser->LAST_ERROR);
					}
				}
			}
		} break;
	}
	
	echo json_encode($result);
	die();
	