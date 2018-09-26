<?php

$mailTo = 'admin@1relax.ru';


$resp = array(
		'error' => false,
		'errorMsg' => ''
	);
$data = json_decode($_POST['data']);


$to      = $mailTo;
$subject = 'Заявка на рекламу от '.$data->email;
$message = 'Имя: '.$data->name."\r\n";
$message.= 'Салон: '.$data->salon."\r\n";
$message.= 'Email: '.$data->email."\r\n";
$message.= 'Телефон: '.$data->telephone."\r\n";
$message.= 'Сообщение: '.$data->comment."\r\n";
$headers = 'From: '   .$data->email . "\r\n" .
           'Reply-To:'.$data->email . "\r\n".
           'X-Mailer: PHP/' . phpversion() . "MIME-Version: 1.0" . "\r\n" . 
		   "Content-type: text/html; charset=utf-8" . "\r\n";


if ( mail($to, $subject, $message, $headers) === false ){
	$resp = array(
		'error' => true,
		'errorMsg' => 'Ошибка отправки почты.'
	);
}
// $resp['to'] = $to;
// $resp['subject'] = $subject;
// $resp['message'] = $message;
// $resp['headers'] = $headers;


echo json_encode($resp);

?>