<?php
// Файлы phpmailer

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';


// Переменные, которые отправляет пользователь
$name = $_POST['name'];
$city=$_POST['city'];
$phone = $_POST['phone'];
$text = $_POST['text'];



	
print_r($_POST);

// Формирование самого письма
$title = "Заголовок письма";
$body = "
<h2>Письмо с сайта</h2>
<b>ФИО:</b> $name<br><br>
<b>Город:</b> $city<br><br>
<b>Телефон:</b> $phone<br><br>
<b>Сообщение:</b><br>$text
";



$error_fields = [];

if ($name === '') {
    $error_fields[] = 'name';
	 print_r("3####");
	 
}

if ($city === '') {
	$error_fields[] = 'city';
}


if (strlen($phone) != 18) {
    $error_fields[] = 'phone';
}



if ($text === '') {
    $error_fields[] = 'text';
}

if (!empty($error_fields)) {
	$response = [
		 "status" => false,
		 "type" => 1,
		 "message" => "Проверьте правильность полей",
		 "fields" => $error_fields
	];

	echo json_encode($response);

	die();
}


// Валидация почты
if (filter_var('coca-cola20022507@mail.ru', FILTER_VALIDATE_EMAIL)) {

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    //$mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

    // Настройки вашей почты
    $mail->Host       = 'smtp.mail.ru'; // SMTP сервера вашей почты
    $mail->Username   = 'qbi_analytics@mail.ru'; // Логин на почте
    $mail->Password   = 'FVrRgnYhYwufCpGayMrE'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('qbi_analytics@mail.ru', 'QBI Analytics'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress('coca-cola20022507@mail.ru');  
    // Ещё один, если нужен


// Отправка сообщения
$mail->isHTML(true);
$mail->Subject = $title;
$mail->Body = $body;    

// Проверяем отравленность сообщения
if ($mail->send()) {$result = "success";} 
else {$result = "error";}

} catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}
} 
// Отображение результата
echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);


header("Refresh")
?>