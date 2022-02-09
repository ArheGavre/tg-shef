<?
namespace  Bot\App;
//$token = "1251392703:AAEjjNd1AvchtX8OZVzMTc4tTm42ZA5rbho";
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

/**
 * Класс для работы с телеграм API
 */
class Telegram {

  protected $token = null;

  function __construct($token){
    $this->token = $token;
  }

  /*
  //описание метода
  public function Метод ($аргумент1, $аргумент2, $аргумент3){
    //Required
    $data = [
        'параметр1' => $аргумент1, 'парметр2' => аргумент2,
      ];
    //Optional
    if($аргумент3) $data["параметр3"] = $аргумент3;
    ...
    //
    $this->request('Метод', $data); //если файл то   $this->request('Метод', $data, true);
  }
  */

  //Отправка сообщения
  public function sendMessage($chatId, $text, $replyTo=0, $parseMode=null, $disableNotice=false, $protectContent=false){
    //Required
    $data = [
        'chat_id' => (string)$chatId, 'text' => $text,
      ];
    //Optional
    if($replyTo) $data["reply_to_message_id"] = $replyTo;
    if($parseMode) $data["parse_mode"] = $parseMode;
    if($disableNotice) $data["disable_notification"] = $disableNotice;
    if($protectContent) $data["protect_content"] = $protectContent;
    //
    $this->request('sendMessage', $data);
  }

  //Отправка фото
  public function sendPhoto($chatId, $photo, $caption, $replyTo=null, $disableNotice=false, $protectContent=false){
    //Required
    $data = [
        'chat_id' => $chatId, 'photo' => $photo,
      ];
    //Optional
    if($replyTo) $data["reply_to_message_id"] = $replyTo;
    if($caption) $data["caption"] = $caption;
    if($disableNotice) $data["disable_notification"] = $disableNotice;
    if($protectContent) $data["protect_content"] = $protectContent;
    //
    $this->request('sendPhoto', $data, true);
  }

  //Отправка аудифайлов (мп3 м4а)
  public function sendAudio($chatId, $audio, $caption, $replyTo=null, $disableNotice=false, $protectContent=false){
    //Required
    $data = [
        'chat_id' => $chatId, 'audio' => $audio,
      ];
    //Optional
    if($replyTo) $data["reply_to_message_id"] = $replyTo;
    if($caption) $data["caption"] = $caption;
    if($disableNotice) $data["disable_notification"] = $disableNotice;
    if($protectContent) $data["protect_content"] = $protectContent;
    //
    $this->request('sendAudio', $data, true);
  }

  //Отправка голосовое сообщение (OGG файл кодированній в OPUS)
  public function sendVoice($chatId, $voice, $caption, $replyTo=null, $disableNotice=false, $protectContent=false){
    //Required
    $data = [
        'chat_id' => $chatId, 'voice' => $voice,
      ];
    //Optional
    if($replyTo) $data["reply_to_message_id"] = $replyTo;
    if($caption) $data["caption"] = $caption;
    if($disableNotice) $data["disable_notification"] = $disableNotice;
    if($protectContent) $data["protect_content"] = $protectContent;
    //
    $this->request('sendVoice', $data, true);
  }

  //Отправка отправка видеофайлов  (мп4)
  public function sendVideo($chatId, $video, $caption, $replyTo=null, $disableNotice=false, $protectContent=false){
    //Required
    $data = [
        'chat_id' => $chatId, 'video' => $video,
      ];
    //Optional
    if($replyTo) $data["reply_to_message_id"] = $replyTo;
    if($caption) $data["caption"] = $caption;
    if($disableNotice) $data["disable_notification"] = $disableNotice;
    if($protectContent) $data["protect_content"] = $protectContent;
    //
    $this->request('sendVideo', $data, true);
  }

  //Отправка отправка видеосообщения  (мп4 до 1минуты)
  public function sendVideoNote($chatId, $video, $replyTo=null, $disableNotice=false, $protectContent=false){
    //Required
    $data = [
        'chat_id' => $chatId, 'video_note' => $video,
      ];
    //Optional
    if($replyTo) $data["reply_to_message_id"] = $replyTo;
    if($disableNotice) $data["disable_notification"] = $disableNotice;
    if($protectContent) $data["protect_content"] = $protectContent;
    //
    $this->request('sendVideoNote', $data, true);
  }
  
  //Отправка файлов
  public function sendDocument ($chatId, $file, $caption, $replyTo=null, $disableNotice=false, $protectContent=false){
    //Required
    $data = [
        'chat_id' => $chatId, 'document' => $file,
      ];
    //Optional
    if($replyTo) $data["reply_to_message_id"] = $replyTo;
    if($caption) $data["caption"] = $caption;
    if($disableNotice) $data["disable_notification"] = $disableNotice;
    if($protectContent) $data["protect_content"] = $protectContent;
    //
    $this->request('sendDocument', $data, true);
  }
  
  //Отправка локации (в тому числі  live Location)
  public function sendLocation ($chatId, $lat, $lon, $replyTo=null, 
								$hAccuracy=null, $heading=0, $alertRadius=0, $period=0, 
								$disableNotice=false, $protectContent=false){
    //Required
    $data = [
        'chat_id' => $chatId, 'latitude' => $lat, 'longitude' => $lon,
      ];
    //Optional
	if($replyTo) $data["reply_to_message_id"] = $replyTo;
	if($hAccuracy != null) $data["horizontal_accuracy"] = $hAccuracy; //Радіус визначеності місця розташування, метрi; 0-1500
	//for live locations
    if($heading) $data["heading"] = $heading; //Напрямок, у якому рухається користувач, у градусах; 1-360
	if($alertRadius) $data["proximity_alert_radius"] = $alertRadius; //Макс відстань для сповіщень про наближення до іншого учасника чату в метр; 1-100000 
	if($period) $data["live_period"] = $period; //Період у секундах, протягом якого місцезнаходження оновлюватиметься; 60-86400
	//
    if($disableNotice) $data["disable_notification"] = $disableNotice;
    if($protectContent) $data["protect_content"] = $protectContent;
    //
    $this->request('sendLocation', $data);
  }
  
  //Отправка собітия
  public function sendVenue ($chatId, $lat, $lon, $title, $address){
    //Required
    $data = [
        'chat_id' => $chatId, 'latitude' => $lat, 'longitude' => $lon,
		'title' => $title, 'address' => $address,
      ];
    //
    $this->request('sendVenue', $data);
  }

  /**
  * Обработка запроса в Telegram API.
  * @param   string      $method  Mehtod name
  * @param   array|null  $data параметры
  */
  protected function request($method, $data = null,  $is_file = false ) {
      $curl = curl_init();
      $options = [
        CURLOPT_URL => 'https://api.telegram.org/bot' . $this->token .  '/' . $method,
        CURLOPT_HEADER => false,
        CURLOPT_RETURNTRANSFER => true,
      ];
      curl_setopt_array( $curl, $options );
      //
      if ( $data ) {
        curl_setopt( $curl, CURLOPT_POST, 1 );
        curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );
      }
      //меняем заголовок если файл
      if ( $is_file )
        curl_setopt( $curl, CURLOPT_HTTPHEADER, [ 'Content-Type:multipart/form-data' ] );
      //Выполение запроса
      $out = curl_exec( $curl );
      curl_close( $curl );
      //DEBUG
      $log = "<?header('Content-Type: text/html; charset=utf-8');?><pre> ".print_r(json_decode($out, true),true)."</pre>";
      file_put_contents(__DIR__ . '/log.php', $log);
      //DEBUG
      return $out;
    }
//все хуйня. давай по новой
}
