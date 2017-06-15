<?php


$config = [
    'simsimi' => [
        // 'endpoint' => 'http://api.simsimi.com/request.p',    // paid key
        'endpoint' => 'http://sandbox.api.simsimi.com/request.p',   // trial key
        'token'    => '9051c54a-ec44-4e5b-ab45-454ccbbae029',
        'locale'   => 'vn'    // View locale support at http://developer.simsimi.com/lclist.
    ]
];

function curl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}

function talkToSimsimi($text) {
    global $config;
    $json = curl($config['simsimi']['endpoint']
            ."?key=".$config['simsimi']['token']
            ."&lc=".$config['simsimi']['locale']
            ."&ft=1.0&text=".urlencode($text));
    $arr = json_decode($json, true);
    if(empty($arr['response'])) {
        // This trial api will have less db. Use paid key for full db. I don't try so I don't know it worth or not?
        $arr['response'] = "[Simsimi not response.]";
    }
    return $arr['response'];
}

if (!empty($_GET)) {
	$text = $_GET["message"];
	// $text = json_decode($text, true);
	// $text = $text["message"];
}else{
	$text = "hello";
}

echo '{
 "messages": [
   {"text":"'
echo talkToSimsimi($text);
echo '"}
 ]
}';
?>