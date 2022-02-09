<?

function cURLGet($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	//return the transfer as a string
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch); 
	return $output;
}

function pornSpam($m,$r){
	sendMessage($m, "Ох понеслась !!!!!!!!!!!!!", $r, "text");
	for($i=0;$i<rand(5, 10);$i++){
		$tg->sendMessage($chat, "http://porno365.biz/movie/".rand(501, 29982), $messId, null, 1, 0);
		sleep(1);
	}
}

function getCurrensy($m,$r){
	$d = json_decode(file_get_contents('https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11'),true);
	$text = "Курс валют 💰".chr(10);
	foreach($d as $c){
		$text .= "💸".$c["ccy"]." 💶".round($c["buy"],2)." 💷".round($c["sale"],2)."".chr(10);
	} 
	$tg->sendMessage($m, $text, $r, null, 1);
}

function antiMoldovenesti($m,$r){
	$a = array("https://www.youtube.com/watch?v=UlMAIE8Rzrs","https://www.youtube.com/watch?v=ODzyLwIx50s",
						"https://www.youtube.com/watch?v=jlUkweucQS8","https://www.youtube.com/watch?v=m1kjPaVAeeE",
						"https://www.youtube.com/watch?v=SgU-KhODCdE","https://www.youtube.com/watch?v=h863rO_SYwg",
						"https://www.youtube.com/watch?v=hGrb4FgukEI","https://www.youtube.com/watch?v=bVOMZnPOqUI",
						"https://www.youtube.com/watch?v=gxQlKq2o9yU","https://www.youtube.com/watch?v=pVZpOWOb6iA");
	$tg->sendMessage($m, $a[rand(0, 9)], $r, null, 1);
	//sendMessage($m, "dcdcd", $r, "text");
}

function kufurbas($m,$r){
	$t = json_decode(cURLGet("https://evilinsult.com/generate_insult.php?lang=ru&type=json"),true)["insult"];
	$tg->sendMessage($m, $t, $r, null, 1, 1);
}

function ttm($m,$r){
	$t = '';
	$tag= new DOMDocument();
	$tag->loadHTML(cURLGet("https://theytoldme.com/".rand(1, 1100)));
	$ss = $tag->getElementsByTagName("section");
	foreach($ss as $s){
		$t .= $s->textContent;
	}
	
	$t = preg_replace('/\v(?:[\v\h]+)/', '', mb_strstr($t,"←",true));;
	$tg->sendMessage($m, $t, $r, null, 1, 1);
}

