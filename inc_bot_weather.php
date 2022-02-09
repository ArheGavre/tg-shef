<?

//https://openweathermap.org/weather-conditions

function kelvinsToCelsium($t){
	return round($t-273.15,1);
}
function hpaToMmHg($p){
	return round($p/1.333);
}
function mToKm($m){
	return round($m/10000,1);
}
function windDirection($d){
	if($d > 335 and $d <= 25) return "северный";
	elseif($d > 25 and $d <= 70) return "северо-восточный";
	elseif($d > 70 and $d <= 115) return "восточный";
	elseif($d > 115 and $d <= 160) return "юго-восточный";
	elseif($d > 160 and $d <= 205) return "южный";
	elseif($d > 205 and $d <= 250) return "юго-западный";
	elseif($d > 250 and $d <= 295) return "западный";
	elseif($d > 295 and $d <= 335) return "северо-западный";
	else return "хз какой";
}
function countryIconSet($ci){
	switch($ci){
		case "UA": $country = "🇺🇦"; break;
		case "RU": $country = "🇷🇺"; break;
		case "BY": $country = "🇧🇾"; break;
		case "MD": $country = "🇲🇩"; break;
		case "BG": $country = "🇧🇬"; break;
		case "RO": $country = "🇷🇴"; break;
		case "PL": $country = "🇵🇱"; break;
		case "TR": $country = "🇹🇷"; break;
		case "DE": $country = "🇩🇪"; break;
		case "GR": $country = "🇬🇪"; break;
		case "UZ": $country = "🇺🇿"; break;
		case "US": $country = "🇺🇸"; break;
		case "GB": $country = "🇬🇧"; break;
		case "CN": $country = "🇨🇳"; break;
		default:  $country = "🌏";
	}
	return $country;
}
function getWeatherIcon($wi){
	switch($wi){
		case "01d": $i = "🌞"; break;
		case "01n": $i = "🌘"; break;
		case "02d": case "02n": $i = "🌤"; break;
		case "03d": case "03n": case "04d": case "04n": $i = "☁"; break;
		case "09d": case "09n": $i = "🌧"; break;
		case "10d": case "10n": $i = "🌦"; break;
		case "11d": case "11n": $i = "🌩"; break;
		case "13d": case "13n": $i = "❄"; break;
		case "50d": case "50n": $i = "🌫"; break;
	}
	return $i;
}

////
////
////
function getWeather($m,$r,$c){

	global $weathtoken;

	//get cityname
	if(explode(" ",$c)[1] == null ){
		$city= "%D0%B8%D0%B7%D0%BC%D0%B0%D0%B8%D0%BB";
	}
	else{
		//
		if(explode(" ",$c)[1] == "в"  or explode(" ",$c)[1] == "во" ){
		
			$city = explode(" ",$c)[2];
			$city = mb_substr($city,0,-1);
		}
		else {
			$city = explode(" ",$c)[1];
		}
	}
	//execute
	$d = json_decode(file_get_contents('https://api.openweathermap.org/data/2.5/weather?q='.$city.'&lang=ru&appid='.$weathtoken),true);
	if($d["cod"] != 200){
		$tg->sendMessage($m, "Я хуй знает где ты(вы) искал(а,и) погоду в ".$city, $r, null, 1, 1);
		exit;
	}

	//if executed
	$text = "Погода сейчас в ".$d["name"]." ".countryIconSet($d["sys"]["country"]).chr(10);
	$text .= "🌝 ".date("H:i",$d["sys"]["sunrise"])." 🌙 ".date("H:i",$d["sys"]["sunset"]).chr(10).chr(10);
	$text .= getWeatherIcon($d["weather"][0]["icon"])." ".$d["weather"][0]["description"].chr(10);
	$text .= "🌡Температура ".kelvinsToCelsium($d["main"]["temp"])."°С ".chr(10);
	$text .= "⛄️По ощущениям ".kelvinsToCelsium($d["main"]["feels_like"])."°С".chr(10);
	$text .= "🌀Колебания от ".kelvinsToCelsium($d["main"]["temp_min"])."°С до ".kelvinsToCelsium($d["main"]["temp_max"])."°С".chr(10);
	$text .= "💦Влажность ".$d["main"]["humidity"]."% ".chr(10);
	$text .= "🪨Давление ".hpaToMmHg($d["main"]["pressure"])."ммрт (".$d["main"]["pressure"]."hpa)".chr(10);
	$text .= "👀Видимость ".mToKm($d["visibility"])."Км".chr(10);
	//optional
	
	$text .= $d["wind"] != null   ? "🌬Ветер ".windDirection($d["wind"]["deg"])." ".$d["wind"]["speed"]."м/с".chr(10): "";
	$text .= $d["wind"] != null   ? "💨Порывы до ".$d["wind"]["gust"]."м/с ".chr(10) : "";
	$text .= $d["clouds"] != null ? "☁Облачность ".$d["clouds"]["all"]."%".chr(10) : "";
	$text .= $d["rain"] != null   ? "🌧Осадки в виде дождя 💦".$d["rain"]["3h"]."мм".chr(10) : "";
	$text .= $d["snow"] != null   ? "🌨Осадки в виде снега ❄".$d["snow"]["3h"]."мм".chr(10).chr(10) : "";
	$text .= "ln:".$d["coord"]["lon"]." lt:".$d["coord"]["lat"]." id:".$d["id"].chr(10).chr(10);
	$text .= "Это на сейчас, а вообше в целом......";
	
	$tg->sendMessage($m, $text, $r, null, 1, 1);
	/*
	$dmax = json_decode(file_get_contents("https://api.openweathermap.org/data/2.5/onecall?lat=".$d["coord"]["lat"]."&lon=".$d["coord"]["lon"]."&lang=ru&appid=".$weathtoken),true);
	
	$text = "....Ближайшие 48 часа такая шняга".chr(10).chr(10);
	$dm = $dmax["hourly"] ;
	for($i=0;$i<24;$i++){
		$text .= "🕘".date("d:m H:i",$dm[$i]["dt"])." ".$dm[$i]["weather"][0]["description"].chr(10)." 🌡".kelvinsToCelsium($dm[$i]["temp"])."°С ⛄️:".kelvinsToCelsium($dm[$i]["feels_like"])."°С 💦Роса:".kelvinsToCelsium($dm[$i]["dew_point"])."°С ";
		$text .= "🪨  ".hpaToMmHg($dm[$i]["pressure"])."мм 💦 ".$dm[$i]["humidity"].chr(10)."🎲Шанс осадков".$dm[$i]["pop"].chr(10);
	}
	sendMessage($m, $text, $r, "text");
	$text = "";
	for($i=24;$i<48;$i++){
		$text .= "🕘".date("d:m H:i",$dm[$i]["dt"])." ".$dm[$i]["weather"][0]["description"].chr(10)." 🌡".kelvinsToCelsium($dm[$i]["temp"])."°С ⛄️:".kelvinsToCelsium($dm[$i]["feels_like"])."°С 💦Роса:".kelvinsToCelsium($dm[$i]["dew_point"])."°С ";
		$text .= "🪨  ".hpaToMmHg($dm[$i]["pressure"])."мм 💦 ".$dm[$i]["humidity"].chr(10)."🎲Шанс осадков ".$dm[$i]["pop"]."%".chr(10);
	}
	sendMessage($m, $text, $r, "text");*/
}

	