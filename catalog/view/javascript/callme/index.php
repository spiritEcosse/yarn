<?
// www.nazartokar.com
// www.dedushka.org
// icq: 167-250-811
// nazartokar@gmail.com

//давайте укажем кодировку
header("Content-Type: text/html; charset=utf-8");

//адрес почты для отправки уведомления
//несколько ящиков перечисляются через запятую
$to = $this->config->get('config_email');
//адрес, от которого придёт уведомление
$from = $this->config->get('config_name');

//далее можно не трогать

$time = time(); // время отправки
$interval = $time - $_GET['ctime'];

if ($interval < 3600) { // если прошло менее часа, указано в секундах
	$result = "error";
	$cls = "c_error";
	$time = "";
	$message = "Сообщение уже было отправлено.";	
} else {
	if ( (strlen($_GET['cname']) > 2) && ( (strlen($_GET['cphone']) > 5 ) ) ) {

	$ip = $_SERVER['REMOTE_ADDR'];

	$title = "Перезвоните мне";
	$title = iconv('UTF-8', 'windows-1251', $title);
	$mess =  "Телефон: \n".substr(htmlspecialchars(trim($_GET['cphone'])), 0, 150)."\n\nИмя: \n".substr(htmlspecialchars(trim($_GET['cname'])), 0, 150);

	if (strlen($_GET['ccmnt']) > 2) {
		$mess = $mess."\n\nКомментарий: \n".substr(htmlspecialchars(trim($_GET['ccmnt'])), 0, 1000);
	}

	$mess = $mess.("\n\nОтправлено со страницы: \n".html_entity_decode($_GET['url']));
	$mess = $mess.("\n\nIP: \n".$ip);

	$headers = "From: ".$from."\r\n";
	$headers .= "Content-type: text/plain; charset=utf-8\r\n";

	@mail($to, $title, $mess, $headers);
		$result = "success";
		$cls = "c_success";
		$message = "Спасибо, сообщение отправлено."; //сообщение об отправке
		//$message = $mess;
	} else {
		$result = "error";
		$cls = "c_error";
		$time = "";
		$message = "Заполните как минимум первых 2 поля.";
	}
} ?>
{
"result": "<? echo $result; ?>",
"cls": "<? echo $cls; ?>",
"time": "<? echo $time; ?>",
"message": "<? echo $message; ?>"
}