<?
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require_once("app/telegram.php");
require_once("inc_bot_words.php");

use Bot\App\Telegram as Telegram;

$token = "1251392703:AAEjjNd1AvchtX8OZVzMTc4tTm42ZA5rbho";
$weathtoken = "d5bd967c274eeaeff897ebabe3e4ad03";
$data = file_get_contents('php://input');
$data = json_decode($data, true);
file_put_contents(__DIR__ . '/t.php', "<?header('Content-Type: text/html; charset=utf-8');?><pre> ".print_r($data, true)."</pre>");

function prepareFile($f){
	return curl_file_create(__DIR__ . $f);
}

$chat = $data["message"]["chat"]["id"];

$tg = new Telegram($token);
//$tg->sendMessage($chat, "Сообщение без уведомления и нельзя переслать", 0, null, 1, 1);
//$tg->sendVenue ($chat, 45.21, 28.33, "Коноебство", "ул. хуева кукуева 54");


//796088662 тирон 594606318 погорелова "Onamisa" 635315102 леша 

require_once("inc_bot_weather.php");

require_once("inc_bot_functions.php");


function parserMessage($m){
	global $randReplies;
	global $triggers;

	$chat = $m["message"]["chat"]["id"];
	$messId = $m["message"]["message_id"];
	
	if($m["message"]["entities"] != null){
		if (mb_stripos($m["message"]["text"], "pornspam", 0, 'UTF-8') !== false){
			pornSpam($chat,$messId);
		}
		exit;
	}
	
	foreach ($triggers as $t) {
		if (mb_stripos($m["message"]["text"], $t, 0, 'UTF-8') !== false){
			switch($t){
				case "порн": case "сись": case "сос":  case "🔞":  case "🍓": case "вирт":  case "флирт": 
						$tg->sendMessage($chat, "http://porno365.biz/movie/".rand(501, 29982), $messId, null, 1, 0); break;
				case "зелен": case "слав": 
						$tg->sendMessage($chat, "@arhegavre тут о тебе", $messId); break;
				case "курс": case "валют": 
						getCurrensy($chat,$messId); break;
				case "погод": case "weath":
						getWeather($chat,$messId,$m["message"]["text"]); break;
				//case "титан": case "депрес": case "дикап": case  "снег": 
				//		sendMessage($chat, "ггг", $messId, "vid", "/v/titanik.mp4"); break;
				case "мэй": case "вэй": case "мей": case "вей": 	
						antiMoldovenesti($chat,$messId); break;
				case "сове":
						ttm($chat,$messId); break;
			}
			exit;
		}
	}
	
	
	if(rand(0, 25) == 5)	kufurbas($chat,$messId);
	if(rand(0, 18) == 5)	ttm($chat,$messId);
}

parserMessage($data);
exit;
